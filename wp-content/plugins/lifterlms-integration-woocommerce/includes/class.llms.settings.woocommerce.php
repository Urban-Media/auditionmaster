<?php
/**
 * Manage settings forms on the LifterLMS Integrations Settings Page
 * @since       1.0.0
 * @version     1.3.0
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

class LLMS_Settings_Integrations_WooCommerce {

	public function __construct() {

		add_filter( 'lifterlms_integrations_settings', array( $this, 'integration_settings' ), 10, 1 );
		add_action( 'lifterlms_settings_save_integrations', array( $this, 'save' ), 10 );

	}

	/**
	 * This function adds the appropriate content to the
	 * array that makes up the settings page. It takes in
	 * the content passed to it via the filter and then adds
	 * the mailchimp info to it.
	 *
	 * @param    array $content Content that is contained on the integrations page of LifterLMS
	 * @return   array          The updated content array
	 * @since    1.0.0
	 * @version  1.3.0
	 */
	public function integration_settings( $content ) {

		$content[] = array(
			'type' => 'sectionstart',
			'id' => 'lifterlms_woocommerce_options',
			'class' =>'top'
		);

		$content[] = array(
			'title' => __( 'WooCommerce Settings', 'lifterlms-woocommerce' ),
			'type' => 'title',
			'desc' => '',
			'id' => 'lifterlms_woocommerce_options'
		);

		$content[] = array(
			'desc' 		=> __( 'Use WooCommerce to sell LifterLMS Courses and Memberships', 'lifterlms-woocommerce' ),
			'default'	=> 'no',
			'id' 		=> 'lifterlms_woocommerce_enabled',
			'type' 		=> 'checkbox',
			'title'     => __( 'Enable / Disable', 'lifterlms-woocommerce' ),
		);

		$integration = LLMS()->integrations()->get_integration( 'woocommerce' );

		if ( $integration && $integration->is_available() ) {

			if ( function_exists( 'wc_get_order_statuses' ) ) {

				$content[] = array(
					'class'     => 'llms-select2',
					'desc' 		=> '<br>' . __( 'Customers will be enrolled when a WooCommerce Order reaches this status', 'lifterlms-woocommerce' ),
					'default'	=> 'wc-completed',
					'id' 		=> 'lifterlms_woocommerce_enrollment_status',
					'options'   => wc_get_order_statuses(),
					'type' 		=> 'select',
					'title'     => __( 'Order Enrollment Status', 'lifterlms-woocommerce' ),
				);

				$content[] = array(
					'class'     => 'llms-select2',
					'desc' 		=> '<br>' . __( 'Customers will be unenrolled when a WooCommerce Order reaches any of these statuses', 'lifterlms-woocommerce' ),
					'default'	=> array( 'wc-refunded', 'wc-cancelled', 'wc-failed' ),
					'id' 		=> 'lifterlms_woocommerce_unenrollment_statuses',
					'options'   => wc_get_order_statuses(),
					'type' 		=> 'multiselect',
					'title'     => __( 'Order Unenrollment Status(es)', 'lifterlms-woocommerce' ),
				);

			}

			if ( function_exists( 'wcs_get_subscription_statuses' ) ) {

				$content[] = array(
					'class'     => 'llms-select2',
					'desc' 		=> '<br>' . __( 'Customers will be enrolled when a WooCommerce Subscription reaches this status', 'lifterlms-woocommerce' ),
					'default'	=> 'wc-active',
					'id' 		=> 'lifterlms_woocommerce_subscription_enrollment_status',
					'options'   => wcs_get_subscription_statuses(),
					'type' 		=> 'select',
					'title'     => __( 'Subscription Enrollment Status', 'lifterlms-woocommerce' ),
				);

				$content[] = array(
					'class'     => 'llms-select2',
					'desc' 		=> '<br>' . __( 'Customers will be unenrolled when a WooCommerce Subscription reaches any of these statuses', 'lifterlms-woocommerce' ),
					'default'	=> array( 'wc-cancelled', 'wc-expired', 'wc-on-hold' ),
					'id' 		=> 'lifterlms_woocommerce_subscription_unenrollment_statuses',
					'options'   => wcs_get_subscription_statuses(),
					'type' 		=> 'multiselect',
					'title'     => __( 'Subscription Unenrollment Status(es)', 'lifterlms-woocommerce' ),
				);


			}

			$endpoints = $integration->get_account_endpoints( false );

			$content[] = array(
				'class'     => 'llms-select2',
				'desc' 		=> '<br>' . __( 'The following LifterLMS Student Dashboard areas will be added to the WooCommerce My Account Page', 'lifterlms-woocommerce' ),
				'default'	=> array_keys( $endpoints ),
				'id' 		=> 'lifterlms_woocommerce_account_endpoints',
				'options'   => $endpoints,
				'type' 		=> 'multiselect',
				'title'     => __( 'My Account Endpoints', 'lifterlms-woocommerce' ),
			);

			$content[] = array(
				'desc'          => __( 'Enable debug logging', 'lifterlms-woocommerce' ),
				'desc_tooltip'  => sprintf( __( 'When enabled, debugging information will be logged to "%s"', 'lifterlms-woocommerce' ), llms_get_log_path( 'woocommerce' ) ),
				'id'            => 'lifterlms_woocommerce_logging_enabled',
				'title'         => __( 'Debug Log' ,'lifterlms-woocommerce' ),
				'type'          => 'checkbox',
			);

		}

		$content[] = array(
			'type' => 'sectionend',
			'id' => 'lifterlms_woocommerce_options'
		);

		return $content;

	}

	/**
	 * Flush rewrite rules when saving settings
	 * @return   void
	 * @since    1.3.0
	 * @version  1.3.0
	 */
	public function save() {

		$integration = LLMS()->integrations()->get_integration( 'woocommerce' );
		if ( $integration && $integration->is_available() ) {
			flush_rewrite_rules();
		}

	}

}

return new LLMS_Settings_Integrations_WooCommerce();
