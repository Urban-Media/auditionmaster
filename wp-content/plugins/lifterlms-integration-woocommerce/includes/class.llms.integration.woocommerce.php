<?php
/**
* LifterLMS WooCommerce Integration Class
*
* @version  1.0.0
* @since    1.3.2
*/

if ( ! defined( 'ABSPATH' ) ) { exit; }

class LLMS_Integration_WooCommerce {

	public $id = 'woocommerce';
	public $title = '';

	/**
	 * Integration Constructor
	 * @since    1.0.0
	 * @version  1.3.0
	 */
	public function __construct() {

		$this->title = __( 'WooCommerce', 'lifterlms-woocommerce' );

		if ( $this->is_available() ) {

			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );

			add_action( 'init', array( $this, 'add_account_endpoints' ) );
			add_action( 'init', array( $this, 'modify_pricing_tables' ) );
			add_action( 'init', array( $this, 'order_status_actions' ) );

			// check if it's a member's only product
			add_action( 'woocommerce_before_shop_loop_item', array( $this, 'before_wc_product' ) ); // loop
			add_action( 'woocommerce_before_single_product', array( $this, 'before_wc_product' ) ); // single

			foreach ( $this->get_account_endpoints() as $endpoint => $title ) {
				add_action( 'woocommerce_account_' . $endpoint .  '_endpoint', array( $this, 'output_endpoint_' . $endpoint ) );
			}

			add_filter( 'query_vars', array( $this, 'add_account_query_vars' ), 0 );
			add_filter( 'woocommerce_account_menu_items', array( $this, 'add_account_menu_item' ) );

			if ( is_admin() ) {

				// remove the default LLMS product metaboxes
				add_action( 'add_meta_boxes', array( $this, 'remove_product_metabox' ), 20 );

				// add & handle custom wc product fields
				add_action( 'woocommerce_process_product_meta', array( $this, 'save_wc_product_fields' ) );
				add_action( 'woocommerce_product_options_advanced', array( $this, 'add_wc_product_fields' ) );

				// our WC metabox
				require_once LLMS_WC_PLUGIN_DIR . 'includes/class.llms.metabox.wc.product.php';

				// output enrollment data in order meta area
				add_action( 'woocommerce_after_order_itemmeta', array( $this, 'output_item_meta' ), 10, 3 );
				// save enrollment updates when updating an order
				add_action( 'woocommerce_process_shop_order_meta', array( $this, 'save_order_enrollments' ), 10, 1 );

				// hide the LLMS Core Payment Gateway notice when WC is active
				add_filter( 'llms_admin_notice_no_payment_gateways', '__return_true' );

			}

		}
	}

	/**
	 * Add LLMS page endpoint accessed via WC My ACcount Page
	 * @return   void
	 * @since    1.0.0
	 * @version  1.0.0
	 */
	public function add_account_endpoints() {

		foreach ( $this->get_account_endpoints() as $endpoint => $title ) {

			add_rewrite_endpoint( $endpoint, EP_ROOT | EP_PAGES );

		}

	}

	/**
	 * Add an order note for enrollment/unenrollment actions based on status changes
	 * @param    obj        $order       WC_Order object
	 * @param    int        $product_id  WP_Post ID of a course or membership
	 * @param    string     $type        note type [enrollment|unenrollment]
	 * @since    1.3.0
	 * @version  1.3.0
	 */
	public function add_order_note( $order, $product_id, $type = 'enrollment' ) {

		if ( apply_filters( 'llms_wc_add_' . $type . '_notes', true ) ) {

			$product = llms_get_post( $product_id );
			if ( is_a( $product, 'WP_Post' ) ) {
				return;
			}

			switch ( $type ) {
				case 'enrollment':
					$msg = __( 'Customer was enrolled into the "%1$s" %2$s.', 'lifterlms-woocommerce' );
				break;

				case 'unenrollment':
					$msg = __( 'Customer was unenrolled from the "%1$s" %2$s.', 'lifterlms-woocommerce' );
				break;

			}

			$order->add_order_note( sprintf( $msg, $product->get( 'title' ), strtolower( $product->get_post_type_label() ) ) );

		}

	}

	/**
	 * Add LLMS page links to the WC My Account Page
	 * @param    array     $items  array of existing menu items
	 * @since    1.0.0
	 * @version  1.0.0
	 */
	public function add_account_menu_item( $items ) {

		$logout = array(
			'customer-logout' => $items['customer-logout']
		);
		unset( $items['customer-logout'] );

		$items = array_merge( $items, $this->get_account_endpoints(), $logout );

		return $items;
	}

	/**
	 * Add LLMS query vars for the pages accessible via WC ACcount page
	 * @param    array     $vars  existing query vars
	 * @since    1.0.0
	 * @version  1.0.0
	 */
	public function add_account_query_vars( $vars ) {

		return array_merge( $vars, array_keys( $this->get_account_endpoints() ) ) ;

	}

	/**
	 * Add some custom fields to WooCommerce Products Advanced tab
	 * @return   void
	 * @since    1.0.0
	 * @version  1.0.0
	 */
	public function add_wc_product_fields() {

		$q = new WP_Query( array(
			'order' => 'ASC',
			'orderby' => 'title',
			'post_status' => 'publish',
			'post_type' => 'llms_membership',
			'posts_per_page' => -1,
		) );

		$options = array(
			'' => __( 'Available to all customers', 'lifterlms-woocommerce' ),
		);

		if ( $q->have_posts() ) {
			foreach ( $q->posts as $post ) {
				$options[ $post->ID ] = $post->post_title . ' (ID# ' . $post->ID . ')';
			}
		}

		woocommerce_wp_select( array(
			'description' => '<br><br>' . sprintf( __( 'Select a LifterLMS membership which a customer must belong to before they can purchase this product. %sLearn More%s.', 'lifterlms-woocommerce' ), '<a href="https://lifterlms.com/docs/getting-started-with-lifterlms-and-woocommerce/#members-only" target="_blank">', '</a>' ),
			'id' => '_llms_membership_id',
			'label' => __( 'Members Only', 'lifterlms-woocommerce' ),
			'options' => $options,
		) );

	}

	/**
	 * Before displaying a WC Product (single and in loops) check if it's a members only product
	 * and replace the button with a members only link instead
	 * @return   void
	 * @since    1.0.0
	 * @version  1.0.0
	 */
	public function before_wc_product() {

		$membership_id = get_post_meta( get_the_ID(), '_llms_membership_id', true );

		if ( $membership_id && ! llms_is_user_enrolled( get_current_user_id(), $membership_id ) ) {

			remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 ); // loop
			remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 ); // single

			add_action( 'woocommerce_after_shop_loop_item', array( $this, 'output_membership_button' ), 10 ); // loop
			add_action( 'woocommerce_single_product_summary', array( $this, 'output_membership_button' ), 30 ); // single

		}

	}

	/**
	 * Enroll the customer in all llms products associated with all items in the order
	 * Called upon order status change to the user-defined "Enrollment Status" setting
	 * @param    int     $order_id  WC Order ID
	 * @return   void
	 * @since    1.0.0
	 * @version  1.3.0
	 */
	public function do_order_enrollments( $order_id ) {

		if ( ! is_numeric( $order_id ) && $order_id instanceof WC_Subscription ) {
			$order = $order_id->get_parent();
		} else {
			$order = wc_get_order( $order_id );
		}

		$user_id = $order->get_user_id();

		$this->log( '`do_order_enrollments()` started for order_id "' . $order->get_id() . '"' );

		// if no user id exists we do nothing. Gotta have a user to assign the course to.
		if ( empty( $user_id ) ) {
			return;
		}

		$products = llms_get_llms_products_in_wc_order( $order );

		$this->log( '$products: ', $products );

		if ( $products ) {
			foreach( $products as $product_id ) {
				if ( llms_enroll_student( $user_id, $product_id, 'wc_order_' . $order->get_id() ) ) {
					$this->add_order_note( $order, $product_id, 'enrollment' );
				}
			}
		}

		$this->log( '`do_order_enrollments()` finished for order_id "' . $order->get_id() . '"' );

	}

	/**
	 * Unenroll the customer from all llms products associated with all items in the order
	 * Called upon order status change to any status in the user-defined "Unenrollment Statuses" setting
	 * @param    int     $order_id  WC Order ID
	 * @return   void
	 * @since    1.0.0
	 * @version  1.3.0
	 */
	public function do_order_unenrollments( $order_id ) {

		if ( ! is_numeric( $order_id ) && $order_id instanceof WC_Subscription ) {
			$order = $order_id->get_parent();
		} else {
			$order = wc_get_order( $order_id );
		}

		$user_id = $order->get_user_id();

		$this->log( '`do_order_unenrollments()` started for order_id "' . $order->get_id() . '"' );

		// if no user id exists we do nothing. Gotta have a user to assign the course to.
		if ( empty( $user_id ) ) {
			return;
		}

		$products = llms_get_llms_products_in_wc_order( $order );

		$this->log( '$products: ', $products );

		if ( $products ) {
			foreach( $products as $product_id ) {
				if ( llms_unenroll_student( $user_id, $product_id, apply_filters( 'llms_wc_unenrollment_new_status' ,'expired', $order->get_id() ), 'wc_order_' . $order->get_id() ) ) {
					$this->add_order_note( $order, $product_id, 'enrollment' );
				}
			}
		}

		$this->log( '`do_order_unenrollments()` finished for order_id "' . $order->get_id() . '"' );

	}

	/**
	 * Register & enqueue scripts & styles
	 * @return   void
	 * @since    1.0.0
	 * @version  1.0.0
	 */
	public function enqueue_scripts() {

		if ( is_course() || is_membership() ) {

			$min = apply_filters( 'llms_wc_minify_assets', true ) ? '.min' : '';

			wp_register_style( 'llms-wc-styles', plugins_url( 'assets/llms-wc-styles' . $min . '.css', LLMS_WC_PLUGIN_FILE ), null, LLMS_WooCommerce()->version );
			wp_enqueue_style( 'llms-wc-styles' );

		}

	}

	/**
	 * Get a list of custom endpoints to add to WC My Account page
	 * @return   array
	 * @since    1.0.0
	 * @version  1.3.0
	 */
	public function get_account_endpoints( $active_only = true ) {

		$endpoints = apply_filters( 'llms_wc_account_endpoints', array(
			'courses' => __( 'Courses', 'lifterlms-woocommerce' ),
			'memberships' => __( 'Memberships', 'lifterlms-woocommerce' ),
			'achievements' => __( 'Achievements', 'lifterlms-woocommerce' ),
			'certificates' => __( 'Certificates', 'lifterlms-woocommerce' ),
			'notifications' => __( 'Notifications', 'lifterlms-woocommerce' ),
			'vouchers' => __( 'Vouchers', 'lifterlms-woocommerce' ),
		) );

		if ( $active_only ) {

			$active = get_option( 'lifterlms_woocommerce_account_endpoints', array_keys( $endpoints ) );
			foreach ( array_keys( $endpoints ) as $endpoint ) {
				if ( ! in_array( $endpoint, $active ) ) {
					unset( $endpoints[ $endpoint ] );
				}
			}

		}

		return $endpoints;

	}

	/**
	 * Determine if the integration is available for use
	 * @return   boolean
	 * @since    1.0.0
	 * @version  1.0.0
	 */
	public function is_available() {
		if ( $this->is_installed() && 'yes' === get_option( 'lifterlms_woocommerce_enabled', 'no' ) ) {
			return true;
		}
		return false;
	}

	/**
	 * Determine if WooCommerce is installed & activated
	 * @return   boolean
	 * @since    1.0.0
	 * @version  1.0.0
	 */
	public function is_installed() {
		if ( function_exists( 'WC' ) ) {
			return true;
		}
		return false;
	}

	/**
	 * Log data to the log woocommerce log file
	 * Only logs if logging is enabled so it's redundant to check logging berofe calling this
	 * @param    mixed     accepts any number of arguments of various data types, each will be logged
	 * @return   void
	 * @since    3.0.0
	 * @version  3.0.0
	 */
	public function log() {
		if ( 'yes' === get_option( 'lifterlms_woocommerce_logging_enabled', 'no' ) ) {
			foreach ( func_get_args() as $data ) {
				llms_log( $data, 'woocommerce' );
			}
		}
	}

	/**
	 * Add enrollment and unenrollment actions based on integration settings
	 * @return   void
	 * @since    1.0.0
	 * @version  1.0.0
	 */
	public function order_status_actions() {

		$enroll = get_option( 'lifterlms_woocommerce_enrollment_status', 'wc-completed' );
		add_action( 'woocommerce_order_status_' . $this->unprefix_status( $enroll ), array( $this, 'do_order_enrollments' ), 10, 1 );

		$unenrolls = get_option( 'lifterlms_woocommerce_unenrollment_statuses', array() );
		foreach ( $unenrolls as $status ) {
			add_action( 'woocommerce_order_status_' . $this->unprefix_status( $status ), array( $this, 'do_order_unenrollments' ), 10, 1 );
		}

		// add subscription actions
		if ( class_exists( 'WC_Subscriptions' ) ) {

			$sub_enroll = get_option( 'lifterlms_woocommerce_subscription_enrollment_status', 'wc-active' );
			add_action( 'woocommerce_subscription_status_' . $this->unprefix_status( $sub_enroll ), array( $this, 'do_order_enrollments' ), 10, 1 );

			$sub_unenrolls = get_option( 'lifterlms_woocommerce_subscription_unenrollment_statuses', array() );
			foreach ( $sub_unenrolls as $status ) {
				add_action( 'woocommerce_subscription_status_' . $this->unprefix_status( $status ), array( $this, 'do_order_unenrollments' ), 10, 1 );
			}

		}

	}

	/**
	 * Output Student Courses
	 * @return   void
	 * @since    1.0.0
	 * @version  1.3.1
	 */
	public function output_endpoint_courses() {
		if ( function_exists( 'LLMS' ) && version_compare( '3.14.0', LLMS()->version, '<=' ) ) {
			lifterlms_template_student_dashboard_my_courses( false );
		} else {
			$student = new LLMS_Student();
			llms_get_template( 'myaccount/my-courses.php', array(
				'student' => $student,
				'courses' => $student->get_courses(),
			) );
		}
	}

	/**
	 * Output student achievements
	 * @return   void
	 * @since    1.0.0
	 * @version  1.3.1
	 */
	public function output_endpoint_achievements() {
		if ( function_exists( 'LLMS' ) && version_compare( '3.14.0', LLMS()->version, '<=' ) ) {
			lifterlms_template_student_dashboard_my_achievements( false );
		} else {
			llms_get_template( 'myaccount/my-achievements.php' );
		}
	}

	/**
	 * Output student certificates
	 * @return   void
	 * @since    1.0.0
	 * @version  1.3.1
	 */
	public function output_endpoint_certificates() {
		if ( function_exists( 'LLMS' ) && version_compare( '3.14.0', LLMS()->version, '<=' ) ) {
			lifterlms_template_student_dashboard_my_certificates( false );
		} else {
			llms_get_template( 'myaccount/my-certificates.php' );
		}
	}

	/**
	 * Output student memberships
	 * @return   void
	 * @since    1.0.0
	 * @version  1.3.1
	 */
	public function output_endpoint_memberships() {
		if ( function_exists( 'LLMS' ) && version_compare( '3.14.0', LLMS()->version, '<=' ) ) {
			lifterlms_template_student_dashboard_my_memberships();
		} else {
			llms_get_template( 'myaccount/my-memberships.php' );
		}
	}

	/**
	 * Output student notifications
	 * @return   void
	 * @since    1.3.0
	 * @version  1.3.0
	 */
	public function output_endpoint_notifications() {
		echo '<h2 class="llms-sd-title">' . __( 'My Notifications', 'lifterlms-woocommerce' ) . '</h2>';
		LLMS_Student_Dashboard::output_notifications_content();
	}

	/**
	 * Output voucher redemeption endpoint
	 * @return   void
	 * @since    1.3.0
	 * @version  1.3.0
	 */
	public function output_endpoint_vouchers() {
		echo '<h2 class="llms-sd-title">' . __( 'Redeem a Voucher', 'lifterlms-woocommerce' ) . '</h2>';
		LLMS_Student_Dashboard::output_redeem_voucher_content();
	}

	/**
	 * Output a quick & dirty match height script so that the [products] shortcode
	 * outputs a nice matched-height pricing-table type situation
	 * @return   void
	 * @since    1.1.0
	 * @version  1.1.1
	 */
	public function output_match_height_scripts() {

		if ( ! is_course() && ! is_membership() ) {
			return;
		}

		?>
		<script>
		;( function( $ ){
			LLMS.wait_for_matchHeight( function() {
				$( 'li.product a.woocommerce-LoopProduct-link' ).matchHeight();
			} );
		} )( jQuery );
		</script>
		<?php
	}

	/**
	 * Output a members only button wheh a product is restricted to a membership
	 * @return   void
	 * @since    1.0.0
	 * @version  1.1.3
	 */
	public function output_membership_button() {
		$membership_id = get_post_meta( get_the_ID(), '_llms_membership_id', true );
		echo apply_filters( 'llms_wc_members_only_button_text', '<a class="single_add_to_cart_button button alt" href="' . get_permalink( $membership_id ) . '">' . __( 'Members Only', 'lifterlms-woocommerce' ) . '</a>', $membership_id );
		/**
		 * Remove the action on the loop so it is rechecked for the next item in the loop
		 */
		remove_action( 'woocommerce_after_shop_loop_item', array( $this, 'output_membership_button' ), 10 );
	}

	/**
	 * Remove LLMS Core Pricing Tables in favor of the WC product shortcodes
	 * @return   void
	 * @since    1.0.0
	 * @version  1.3.0
	 */
	public function modify_pricing_tables() {

		remove_action( 'lifterlms_single_course_after_summary', 'lifterlms_template_pricing_table', 60 );
		remove_action( 'lifterlms_single_membership_after_summary', 'lifterlms_template_pricing_table', 10 );

		add_action( 'lifterlms_single_course_after_summary', 'llms_wc_output_pricing_table', 60 );
		add_action( 'lifterlms_single_membership_after_summary', 'llms_wc_output_pricing_table', 10 );

		add_action( 'wp_print_footer_scripts', array( $this, 'output_match_height_scripts' ), 777 );

	}

	/**
	 * Output Course / Membership enrollment info on the order item meta area
	 * @param    int   $item_id  WC Item ID
	 * @param    obj   $item     WC Item obj
	 * @param    obj   $product  WC Product obj
	 * @return   void
	 * @since    1.2.0
	 * @version  1.3.2
	 */
	public function output_item_meta( $item_id, $item, $product ) {

		if ( ! method_exists( $item, 'get_product_id' ) || ! $item->get_product_id() ) {
			return;
		}

		$llms_products = llms_get_llms_products_by_wc_product_id( $item->get_product_id() );

		if ( ! $llms_products ) {
			return;
		}

		$order = $item->get_order();

		$customer_id = $order->get_customer_id();
		if ( ! $customer_id ) {
			return;
		}
		$student = llms_get_student( $customer_id );

		?>
		<div class="llms-wc-enrollment-data" style="margin-top: 10px;">
			<div class="llms-wc-enrollment-row" style="margin-bottom:5px;border-bottom:1px solid #eee;padding-bottom:5px;">
				<div style="display:inline-block;width:79%"><?php _e( 'Course / Membership', 'lifterlms-woocommerce' ); ?></div>
				<div style="display:inline-block;width:20%;"><?php _e( 'Enrollment Status', 'lifterlms-woocommerce' ); ?></div>
			</div>

		<?php
		foreach ( $llms_products as $product_id ) {
			$post = llms_get_post( $product_id );
			$current_status = $student->get_enrollment_status( $product_id );
			$select = '<select style="width:100%;" name="llms_wc_enrollment_status[' . $product_id . ']">';
			foreach ( llms_get_enrollment_statuses() as $val => $name ) {
				$select .= '<option value="' . $val . '"' . selected( $val, strtolower( $current_status ), false ) . '>' . $name . '</option>';
			}
			$select .= '</select>';
			?>
			<div class="llms-wc-enrollment-row" style="margin-bottom:5px;border-bottom:1px solid #eee;padding-bottom:5px;">
				<div style="display:inline-block;width:79%"><?php printf( '<a href="%2$s">%1$s</a>', $post->get( 'title' ), get_edit_post_link( $post->get( 'id' ) ) ); ?></div>
				<div style="display:inline-block;width:20%;vertical-align:top;"><?php echo $select; ?></div>
			</div>
			<?php
		}
		echo '</div>';

	}

	/**
	 * Remove the default LLMS metaboxes for product options
	 * @return   void
	 * @since    1.0.0
	 * @version  1.0.0
	 */
	public function remove_product_metabox() {

		remove_meta_box( 'lifterlms-product', 'course', 'normal' );
		remove_meta_box( 'lifterlms-product', 'llms_membership', 'normal' );

	}

	/**
	 * Update enrollment statuses when an order is saved and enrollments have been changed from the order item metabox
	 * @param    int     $order_id  WC Order ID
	 * @return   void
	 * @since    1.2.0
	 * @version  1.3.0
	 */
	public function save_order_enrollments( $order_id ) {

		if ( isset( $_POST['llms_wc_enrollment_status'] ) && is_array( $_POST['llms_wc_enrollment_status'] ) ) {

			$order = wc_get_order( $order_id );

			if ( $order instanceof WC_Subscription ) {
				$order = $order->get_parent();
			} else {
				$order = wc_get_order( $order );
			}

			$student = new LLMS_Student( $order->get_customer_id() );

			foreach ( $_POST['llms_wc_enrollment_status'] as $product_id => $new_status ) {

				$current_status = $student->get_enrollment_status( $product_id );

				if ( $new_status !== $current_status ) {

					if ( 'enrolled' === $new_status ) {
						if ( $student->enroll( $product_id, 'wc_order_' . $order->get_id() ) ) {
							$this->add_order_note( $order, $product_id, 'enrollment' );
						}
					} else {
						if ( $student->unenroll( $product_id, 'any', $new_status ) ) {
							$this->add_order_note( $order, $product_id, 'unenrollment' );
						}
					}

				}

			}

		}

	}

	/**
	 * Save custom WC Product fields
	 * @param    int     $post_id  WP Post ID of the WC Product
	 * @return   void
	 * @since    1.0.0
	 * @version  1.0.0
	 */
	public function save_wc_product_fields( $post_id ) {

		if ( isset( $_POST['_llms_membership_id'] ) ) {

			update_post_meta( $post_id, '_llms_membership_id', esc_attr( $_POST['_llms_membership_id'] ) );

		}

	}

	/**
	 * Utility to remove "wc-" prefix from a status string
	 * @param    string     $status  prefixed string
	 * @return   string
	 * @since    1.0.0
	 * @version  1.0.0
	 */
	private function unprefix_status( $status ) {
		return str_replace( 'wc-', '', $status );
	}

}
