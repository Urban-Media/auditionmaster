<?php
/**
* LifterLMS Product MetaBox for WC
*
* @since    1.0.0
* @version  1.1.0
*/

if ( ! defined( 'ABSPATH' ) ) { exit; }

class LLMS_Meta_Box_WC_Product extends LLMS_Admin_Metabox {

	/**
	 * Configure the metabox settings
	 * @return   void
	 * @since    1.0.0
	 * @version  1.0.0
	 */
	public function configure() {

		$this->id = 'lifterlms-product-wc';
		$this->title = __( 'Product Options', 'lifterlms-woocommerce' );
		$this->screens = array(
			'course',
			'llms_membership',
		);
		$this->priority = 'high';

	}

	/**
	 * Return an empty array because the metabox fields here are completely custom
	 * @return   array
	 * @since    1.0.0
	 * @version  1.1.0
	 */
	public function get_fields() {

		$obj = get_post_type_object( $this->post->post_type );

		return apply_filters( 'llms_metabox_wc_product_fields', array(
			array(
				'title' 	=> __( 'General', 'lifterlms-woocommerce' ),
				'fields' 	=> array(
					array(
						'data_attributes' => array(
							'allow-clear' => true,
							'maximum-selection-length' => apply_filters( 'llms_wc_max_products', 6 ),
							'placeholder' => __( 'Select product(s)', 'lifterlms-woocommerce' ),
							'post-type' => 'product',
						),
						'class' 	=> 'llms-select2-post',
						'desc' 		=> sprintf( __( 'When an order for any of the selected WooCommerce products have completed, the customer will be automatically enrolled in this %s', 'lifterlms-woocommerce' ), strtolower( $obj->labels->singular_name ) ),
						'id' 		=> $this->prefix . 'wc_product_id',
						'type'		=> 'select',
						'label'		=> __( 'WooCommerce Product(s)', 'lifterlms-woocommerce' ),
						'multi'     => true,
						'value'     => llms_make_select2_post_array( llms_product_get_wc_product_ids( $this->post->ID ) ),
					),
					array(
						'class' 	=> 'llms-select2',
						'allow_null' => false,
						'desc' 		=> __( 'Determine the order used to list the products in the pricing table', 'lifterlms-woocommerce' ),
						'id' 		=> $this->prefix . 'wc_product_sorting',
						'type'		=> 'select',
						'label'		=> __( 'Sort Order', 'lifterlms-woocommerce' ),
						'value'     => array(
							'menu_order,ASC' => __( 'Menu Order (low to high)', 'lifterlms-woocommerce' ),
							'menu_order,DESC' => __( 'Menu Order (high to low)', 'lifterlms-woocommerce' ),
							'title,ASC' => __( 'Title (A - Z)', 'lifterlms-woocommerce' ),
							'title,DESC' => __( 'Title (Z - A)', 'lifterlms-woocommerce' ),
							'ID,ASC' => __( 'Product ID (low to high)', 'lifterlms-woocommerce' ),
							'ID,DESC' => __( 'Product ID (high to low)', 'lifterlms-woocommerce' ),
						),
					),
				),
			),
		) );
	}

}
return new LLMS_Meta_Box_WC_Product();
