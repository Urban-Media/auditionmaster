<?php
/**
 * Retrieve an array of the WC product IDs associated with a LLMS Course or Membership
 * Ensures that pre 1.1.0 products return an array since < 1.1.0 could only have one product association
 * @param    int     $product_id  WP Post ID of a Course or Membership
 * @return   array
 * @since    1.1.0
 * @version  1.1.0
 */
function llms_product_get_wc_product_ids( $product_id ) {

	$ids = get_post_meta( $product_id, '_llms_wc_product_id', true );

	if ( ! $ids ) {
		$ids = array();
	} elseif ( ! is_array( $ids ) ) {
		$ids = array( $ids );
	}

	return apply_filters( 'llms_product_get_wc_product_ids', $ids );

}

/**
 * Locate LifterLMS Product(s) associated with a WooCommerce Product
 * @param    int     $product_id  WC_Product ID
 * @return   array
 * @since    1.2.0
 * @version  1.3.0
 */
function llms_get_llms_products_by_wc_product_id( $product_id ) {

	$query = new WP_Query( array(
		'meta_query' => array(
			'relation' => 'OR',
			// 1.0 - saved as single id
			array(
				'compare' => '=',
				'key' => '_llms_wc_product_id',
				'value' => $product_id,
			),
			// 1.1 - saved as serialized array of ids
			array(
				'compare' => 'LIKE',
				'key' => '_llms_wc_product_id',
				'value' => sprintf( ':"%d";', $product_id ),
			),
		),
		'post_status' => 'publish',
		'post_type' => array( 'course', 'llms_membership' ),
		'posts_per_page' => -1,
	) );

	$ids = array();

	if ( $query->have_posts() ) {

		foreach ( $query->posts as $post ) {

			$ids[] = $post->ID;

		}

	}

	return $ids;

}

/**
 * Retrieve an array of LifterLMS products attached to items in a WC Order
 * @param    obj     $order   instance of a WC_Order
 * @return   array
 * @since    1.2.0
 * @version  1.2.1
 */
function llms_get_llms_products_in_wc_order( $order ) {

	$llms_products = array();

	foreach ( $order->get_items() as $item ) {

		if ( ! is_a( $item, 'WC_Order_Item_Product' ) ) {
			continue;
		}

		$llms_products = array_merge( $llms_products, llms_get_llms_products_by_wc_product_id( $item->get_product_id() ) );

	}

	return array_unique( $llms_products );

}

/**
 * Output the [products] shortcode for the associated WC product(s)
 * @return   void
 * @since    1.0.0
 * @version  1.1.0
 */
function llms_wc_output_pricing_table() {

	// if alreay enrolled, dont show the links
	if ( llms_is_user_enrolled( get_current_user_id(), get_the_ID() ) ) {
		return;
	}

	$post = get_post( get_the_ID() );

	// if it's a course, check a few restrictions first
	if ( 'course'=== $post->post_type ) {

		$course = llms_get_post( $post );
		if ( 'yes' === $course->get( 'enrollment_period' ) ) {
			if ( ! $course->has_date_passed( 'enrollment_start_date' ) ) {
				return llms_print_notice( $course->get( 'enrollment_opens_message' ), 'notice' );
			} elseif ( $course->has_date_passed( 'enrollment_end_date' ) ) {
				return llms_print_notice( $course->get( 'enrollment_closed_message' ), 'error' );
			}
		}
		if ( ! $course->has_capacity() ) {
			return llms_print_notice( $course->get( 'capacity_message' ), 'error' );
		}

	}

	// dont output the thumbnail here
	remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );

	$ret = '';
	$ids = llms_product_get_wc_product_ids( $post->ID );

	if ( $ids ) {

		$num = count( $ids );
		// show 1-5 columns, when there's 6 products show two rows of 3 products each
		$cols = 6 === $num ? 3 : $num;

		$sort = get_post_meta( $post->ID, '_llms_wc_product_sorting', true );
		$sort = explode( ',', $sort );
		$orderby = ! empty( $sort[0] ) ? $sort[0] : 'menu_order';
		$order = ! empty( $sort[1] ) ? strtolower( $sort[1] ) : 'asc';

		$ret = sprintf(
			'[products columns="%1$d" ids="%2$s" orderby="%3$s" order="%4$s"]',
			apply_filters( 'llms_wc_products_shortcode_cols', $cols, $post ),
			apply_filters( 'llms_wc_products_shortcode_ids', implode( ',', $ids ), $post ),
			apply_filters( 'llms_wc_products_shortcode_orderby', $orderby, $post ),
			apply_filters( 'llms_wc_products_shortcode_order', $order, $post )
		);

	}

	echo apply_filters( 'llms_wc_product_shortcode', $ret, $post, $ids );

}
