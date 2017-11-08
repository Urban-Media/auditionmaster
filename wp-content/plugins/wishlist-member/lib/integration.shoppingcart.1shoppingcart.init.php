<?php
/**
 * Handles the polling of the 1ShoppingCart API
 * to check the status of 1ShoppingCart orders
 * and set level status accordingly
 */

$GLOBALS['wlm_1sc_status_map'] = array(
	'onetime' => array (
		'approved'                   => 'activate', // 
		'accepted'                   => 'activate', // A properly processed order
		'pending'                    => 'activate', // A status for redirect based processors like PayPal where we have to wait for an IPN response
		'authorize'                  => 'activate', // The customer has sufficient funds for the order, but it has not been “captured”. Means the charge hasn’t been completed.
		'authorized'                 => 'activate', // The customer has sufficient funds for the order, but it has not been “captured”. Means the charge hasn’t been completed.
		'declined'                   => 'deactivate', // A proper declined order
		'voided'                     => 'deactivate', // An order that was refunded before capture, meaning it is void and never actually processed
		'cancelled'                  => 'deactivate', // This is an Authorization that has been cancelled rather than captured.
		'refunded'                   => 'deactivate', // An order that was refunded after capture
		'refundedfull'               => 'deactivate', // An order that was refunded after capture
		'refunded - partial'         => 'deactivate', // A partially refunded order
		'refundedpartial'            => 'deactivate', // A partially refunded order
		'refunded partial (offline)' => 'deactivate', // An order that was partially refunded, however, it was not passed to a gateway or payment processor
		'refundedpartialoffline'     => 'deactivate', // An order that was partially refunded, however, it was not passed to a gateway or payment processor
		'refunded (offline)'         => 'deactivate', // An order that is marked as refunded, but it was not passed to a gateway or payment processor.
		'refundedoffline'            => 'deactivate', // An order that is marked as refunded, but it was not passed to a gateway or payment processor.
		'refundedfulloffline'        => 'deactivate', // An order that is marked as refunded, but it was not passed to a gateway or payment processor.
		'archived'                   => 'ignore', // The order has been hidden in our UI unless specifically searched for using “archived”
		'unknown'                    => 'ignore', // Cases where we could not determine success from the payment processor
		'error'                      => 'ignore', // Typically a communication error or bad gateway configuration
	),
	'recurring' => array (
		'active'    => 'activate', // An event that is up to date on charges and has remaining billing cycles
		'overdue'   => 'activate', // An event that is currently re-trying and has remaining billing cycles (payments are in arrears)
		'failed'    => 'deactivate', // This event has exceeded max attempts, and is now stopped
		'cancelled' => 'deactivate', // And event that has been manually terminated; may or may not have remaining billing cycles.
		'completed' => 'ignore', // An event that has charged all applicable charges and has completed the set cycle
		'paused'    => 'ignore', // An event that has been manually put on hold but is not completed or failed
	),
);

class WLM_INTEGRATION_1SHOPPINGCART_INIT {
	var $api;

	/**
	 * Constructor
	 */
	function __construct() {
		global $WishListMemberInstance;

		if ( isset( $WishListMemberInstance ) ) {
			// get 1sc api information
			$onescmerchantid = trim( $WishListMemberInstance->GetOption( 'onescmerchantid' ) );
			$onescapikey = trim( $WishListMemberInstance->GetOption( 'onescapikey' ) );
		}

		// bail if there is no or incomplete api information
		if ( !$onescmerchantid || !$onescapikey ) {
			return;
		}

		// load required libs
		require_once $WishListMemberInstance->pluginDir . '/extlib/OneShopAPI.php';
		require_once $WishListMemberInstance->pluginDir . '/extlib/WLMOneShopAPI.php';

		// initialize api
		$this->api = new WLMOneShopAPI( $onescmerchantid, $onescapikey, 'https://www.mcssl.com' );

		$this->merchantid = $onescmerchantid;
		$this->apikey = $onescapikey;

		// get order details
		if ( !wp_next_scheduled( 'wishlistmember_1shoppingcart_check_order_status' ) ) {
			// wp_schedule_event( time(), 'everyfifteenminutes', 'wishlistmember_1shoppingcart_check_order_status' );
			wp_schedule_event( time(), 'twicedaily', 'wishlistmember_1shoppingcart_check_order_status' );
		}

		// add action for our crons
		add_action( 'wishlistmember_1shoppingcart_check_order_status', array( $this, 'CheckOrderStatusType' ) );
	}

	/**
	 * Simple 1SC Get API
	 *
	 * @param string  $request Request being made. Ex: ORDERS/LIST
	 * @param array   $params  Optional parameters to pass
	 * @param integer $limit   RecordSets to retrieve. Default is 1. Set to "0" to get all RecordSets
	 * @return array array of XML Records returned
	 */
	function SimpleAPI( $request, $params = array(), $limit = 1 ) {
		$request = trim( preg_replace( array( '#^/#', '#/$#' ), '', $request ) );
		$pattern = 'https://mcssl.com/API/%d/%s?key=%s';

		if ( empty( $this->merchantid ) || empty( $this->apikey ) || empty( $request ) ) {
			return '';
		}

		if ( !empty( $params ) ) {
			$params = '&' . http_build_query( $params );
		} else {
			$params = '';
		}

		$results = array();
		$read = 1;

		$base_url = sprintf( $pattern, $this->merchantid, $request, $this->apikey );

		while ( $read ) {
			$read = 0;
			$url = $base_url . $params;
			$result = wp_remote_retrieve_body( wp_remote_get( $url ) );
			if ( $result ) {
				$results[] = $result;
				if ( preg_match( '#<nextrecordset>(.+?)</nextrecordset>#im', $result, $matches ) ) {
					if ( preg_match_all( '/<([^\s]+?)>(.+?)</im', $matches[1], $matches ) ) {
						$params = '&' . http_build_query( array_combine( $matches[1], $matches[2] ) );
						$read = 1;
					}
				}
			}

			$limit--;

			if ( empty( $limit ) ) {
				$read = 0;
			}

		}

		return $results;
	}

	/**
	 * Check if returned XML's response is successful
	 * @param string $result XML
	 * @return boolean
	 */
	function SimpleAPIResultSuccessful($result) {
		return (bool) preg_match('#<response[^>]+?success="true"[^>]*?>#im', $result);
	}

	/**
	 * Update status of 1ShoppingCart orders
	 * At the moment, here's the status of how things are:
	 * - One time orders need to be polled for checking
	 * - Recurring orders make use of 1ShoppingCart's instant notification so no polling is needed for that
	 *
	 * Furthermore, we added a way to 
	 */
	function CheckOrderStatusType( ) {
		global $wpdb, $WishListMemberInstance, $wlm_1sc_status_map, $wlm_no_cartintegrationterminate;
		if ( get_transient( 'running-1sc-' . __FUNCTION__ ) ) {
			// return;
		}
		wlm_set_time_limit( DAY_IN_SECONDS / 2 );
		set_transient( 'running-1sc-' . __FUNCTION__, 1, DAY_IN_SECONDS / 2 );

		$reset = get_option('wlm-reset-1sc');
		if($reset) {
			delete_option( 'wlm-reset-1sc' );
			$reset = strtoupper($reset);
			if(in_array($reset, array('O','R'))) {
				$wpdb->query("UPDATE `{$WishListMemberInstance->Tables->userlevel_options}` SET `option_value`=SUBSTRING_INDEX(`option_value`,'-',2) WHERE `option_name`='transaction_id' AND `option_value` REGEXP '^1SC-[0-9]+-{$reset}$'");
			}
		}

		$transaction_ids = get_transient( 'wlm-1sc-xqueue' );
		if(empty($transaction_ids)) {
			// update old 1SC transaction IDs (xxx) to 1SC-xxx
			$wpdb->query("UPDATE `{$WishListMemberInstance->Tables->userlevel_options}` SET `option_value`=CONCAT('1SC-',`option_value`) WHERE `option_name` = 'transaction_id' AND `option_value` REGEXP '^[0-9]+$'");
			// get orders from transaction IDs
			$transaction_ids = $wpdb->get_col( "SELECT DISTINCT `option_value` FROM `{$WishListMemberInstance->Tables->userlevel_options}` WHERE `option_name` = 'transaction_id' AND `option_value` REGEXP '^1SC-[0-9]+.*$' ORDER BY `option_value` ASC" );
			set_transient( 'wlm-1sc-xqueue', $transaction_ids, DAY_IN_SECONDS * 3 );
		}

		$counter = 5;

		while ( $transaction_id = array_shift($transaction_ids) ) {
			$wlm_no_cartintegrationterminate = true;
			$counter--;
			$origtxnid = $transaction_id;
			$transaction_id = explode('-', $transaction_id);
			$transaction_type = strtoupper($transaction_id[2]);
			$transaction_id = $transaction_id[1];
			$transaction_type_needs_update = false;
			if(!in_array($transaction_type, array('O', 'R'))) {
				$transaction_type = '';
				$transaction_type_needs_update = true;
			}

			if('R' == $transaction_type) continue; // do not poll info for orders flagged as recurring

			$result = $this->SimpleAPI('/ORDERS/' . $transaction_id);
			if(!$this->SimpleAPIResultSuccessful($result[0])) continue;

			if(!$transaction_type) { // transaction type unknown, let's check
				$recurring = (bool) preg_match('#<isrecurring>true</isrecurring>#im', $result[0]); // looks like it's recurring
				if($recurring) {
					$orig_result = $result; // save original result (first order)

					// grab client ID
					if(!preg_match('#>(\d+)?</clientid>#im', $result[0], $match)) continue; // get client id

					// pull recurring orders filtered by Client ID
					// * I wish there's a way to just filter recurring orders by Order ID *
					$result = $this->SimpleAPI('/RecurringOrders/List', array('LimitClient' => $match[1]), 100);
					if(!$this->SimpleAPIResultSuccessful($result[0])) continue;

					preg_match_all('#>(\d+)?</recurringorder>#im', $result[0], $matches);
					$recurring_events = $matches[1];
					rsort($recurring_events);
					$found = false;

					// note, this is expensive as we have to loop through all recurring orders for the client and not the order id
					while($recurring_event = array_shift($recurring_events)) { // look for matching recurring event for order
						$result = $this->SimpleAPI('/RecurringOrders/' . $recurring_event);
						if(!$this->SimpleAPIResultSuccessful($result[0])) continue;

						$string = sprintf('#>%d</orderid>#im', $transaction_id);
						if(preg_match($string, $result[0])) {
							$found = true;
							break; // found matching recurring event for order
						}
					}
					if(!$found) {
						// no matching recurring event found so we return the original order's result and set recurring to false
						$result = $orig_result;
						$recurring = false;
					}
					$transaction_type = $recurring ? 'R' : ''; // we've found a recurring event so mark this as recurring, otherwise do not mark it as anything so we can check again later
				} else {
					$transaction_type = 'O';
				}

			}

			$recurring = ('R' == $transaction_type);

			if('' != $transaction_type && $transaction_type_needs_update) {
				$transaction_id = sprintf('1SC-%d-%s', $transaction_id, $transaction_type);
				$query = $wpdb->prepare("UPDATE `{$WishListMemberInstance->Tables->userlevel_options}` SET `option_value`=%s WHERE `option_name` = 'transaction_id' AND `option_value`=%s", $transaction_id, $origtxnid);
				$wpdb->query($query);
				$origtxnid = $transaction_id;
			}

			$field = $recurring ? 'status' : 'orderstatustype';
			$map_index = $recurring ? 'recurring' : 'onetime';

			if(preg_match( '#<'.$field.'>(.+)?</'.$field.'>#im', $result[0], $match )) {
				$orderstatustype = strtolower($match[1]);
				$_POST['sctxnid'] = $origtxnid;
				switch($wlm_1sc_status_map[$map_index][$orderstatustype]) {
					case 'activate':
						$WishListMemberInstance->ShoppingCartReactivate();
						break;
					case 'deactivate':
						$WishListMemberInstance->ShoppingCartDeactivate();
						break;
					default:
						// do nothing
				}
			}

			if(!$counter) {
				$counter = 5;
				set_transient( 'wlm-1sc-xqueue', $transaction_ids, DAY_IN_SECONDS * 3 );
			}
		}

		if($transaction_ids) {
			set_transient( 'wlm-1sc-xqueue', $transaction_ids, DAY_IN_SECONDS * 3 );
		} else {
			delete_transient( 'wlm-1sc-xqueue' );
		}

		delete_transient( 'running-1sc-' . __FUNCTION__ );
	}
}

// load the thing
new WLM_INTEGRATION_1SHOPPINGCART_INIT();

if($_GET['wlm_1sc_reset'] && is_admin()) {
	add_option( 'wlm-reset-1sc', $_GET['wlm_1sc_reset'] );
	do_action( 'wishlistmember_1shoppingcart_check_order_status' );
}