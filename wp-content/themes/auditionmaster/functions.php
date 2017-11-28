<?php
/**
 * Understrap functions and definitions
 *
 * @package understrap
 */

/**
 * Theme setup and custom theme supports.
 */
require get_template_directory() . '/inc/setup.php';

/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
require get_template_directory() . '/inc/widgets.php';

/**
 * Load functions to secure your WP install.
 */
require get_template_directory() . '/inc/security.php';

/**
 * Enqueue scripts and styles.
 */
require get_template_directory() . '/inc/enqueue.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/pagination.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/custom-comments.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

/**
 * Load custom WordPress nav walker.
 */
//require get_template_directory() . '/inc/bootstrap-wp-navwalker.php';
require get_template_directory() . '/inc/bootstrapNavWalker.php';

/**
 * Load WooCommerce functions.
 */
require get_template_directory() . '/inc/woocommerce.php';

/**
 * Load Editor functions.
 */
require get_template_directory() . '/inc/editor.php';

/*
 * Begin custom UM modifications
 *
 */

add_theme_support( 'post-thumbnails' );

function my_llms_theme_support(){
	add_theme_support( 'lifterlms-sidebars' );
}
add_action( 'after_setup_theme', 'my_llms_theme_support' );

/*
* Header menu nav walker
*/
register_nav_menus( array(
    'header-menu'       => 'Header Menu',
    'company-menu'      => 'Company Menu',
    'membership-menu'   => 'Membership Menu',
    'useful-links-menu' => 'Useful Links Menu',
    'social-links-menu' => 'Social Links Menu',
    'legal-links-menu'  => 'Legal Links Menu',
    'logged-in-menu'    => 'Logged In Menu'
) );

class Social_Links_Navwalker extends Walker_Nav_Menu {
  public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
      $url = '';
      if( !empty( $item->url ) ) {
          $url = $item->url;
      }

      $socialImage = get_template_directory_uri() . "/img/" . $item->title ."_icon.png";
      $output .= '<li class="social_link"><a href="' . $url . '"><img src="' . $socialImage .'" class="social_button_footer" data-platform="' . $item->title .'" data-original="' . $socialImage .'"></span>';
  }

  public function end_el( &$output, $item, $depth = 0, $args = array() ) {
      $output .= '</a></li>';
  }
}

class Mobile_Menu_Navwalker extends Walker_Nav_Menu {
  public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
      $url = '';
      if( !empty( $item->url ) ) {
          $url = $item->url;
      }

      $output .= '<li><a href="' . $url . '">' . $item->title;
  }

  public function end_el( &$output, $item, $depth = 0, $args = array() ) {
      $output .= '</a></li>';
  }
}

/*
 * Add an active class to the current page menu option
 */
 add_filter('nav_menu_css_class' , 'special_nav_class' , 10 , 2);

 function special_nav_class ($classes, $item) {
     if (in_array('current-menu-item', $classes) ){
         $classes[] = 'current_page ';
     }
     return $classes;
 }

/*
 * Load page dependent scripts
 */
function load_custom_scripts() {
    wp_register_script('bxSlider', '//cdn.jsdelivr.net/bxslider/4.2.12/jquery.bxslider.min.js', array('jquery'), false);
    wp_register_script('bxSlider-config', get_template_directory_uri() . '/js/bxSlider-config.js', array('jquery', 'bxSlider'), false);
    wp_register_script('locationAwareHover', get_template_directory_uri() . '/js/button_hover_effect.js', array('jquery'), false);
    wp_register_script('global', get_template_directory_uri() . '/js/global.js', array('jquery', 'scrollMagic', 'addIndicators'), false);
    wp_register_script('scrollMagic', '//cdnjs.cloudflare.com/ajax/libs/ScrollMagic/2.0.5/ScrollMagic.min.js', array('jquery'), false);
    wp_register_script( 'gsap-animation', '//cdnjs.cloudflare.com/ajax/libs/ScrollMagic/2.0.5/plugins/animation.gsap.js', array('jquery', 'scrollMagic', 'tweenMax'), false);
    wp_register_script( 'tweenMax', '//cdnjs.cloudflare.com/ajax/libs/gsap/1.20.2/TweenMax.min.js', array('jquery'), false);
    wp_register_script('matchHeight', get_template_directory_uri() . '/js/jquery.matchHeight-min.js', array('jquery'), false);

    // The script below is for dev purposes only and not needed on live
    wp_register_script('addIndicators', '//cdnjs.cloudflare.com/ajax/libs/ScrollMagic/2.0.5/plugins/debug.addIndicators.min.js', array('jquery', 'scrollMagic'), false);

    wp_enqueue_script('bxSlider', '//cdn.jsdelivr.net/bxslider/4.2.12/jquery.bxslider.min.js', array('jquery'), false);
    wp_enqueue_script('bxSlider-config', get_template_directory_uri() . '/js/bxSlider-config.js', array('jquery', 'bxSlider'), false);
    wp_enqueue_script('locationAwareHover', get_template_directory_uri() . '/js/button_hover_effect.js', array('jquery'), false);
    wp_enqueue_script('global', get_template_directory_uri() . '/js/global.js', array('jquery', 'scrollMagic', 'addIndicators'), false);
    wp_enqueue_script('scrollMagic', '//cdnjs.cloudflare.com/ajax/libs/ScrollMagic/2.0.5/ScrollMagic.min.js', array('jquery'), false);
    wp_enqueue_script( 'gsap-animation', '//cdnjs.cloudflare.com/ajax/libs/ScrollMagic/2.0.5/plugins/animation.gsap.js', array('jquery', 'scrollMagic', 'tweenMax'), false);
    wp_enqueue_script( 'tweenMax', '//cdnjs.cloudflare.com/ajax/libs/gsap/1.20.2/TweenMax.min.js', array('jquery'), false);

    // The script below is for dev purposes only and not needed on live
    wp_enqueue_script('addIndicators', '//cdnjs.cloudflare.com/ajax/libs/ScrollMagic/2.0.5/plugins/debug.addIndicators.min.js', array('jquery', 'scrollMagic'), false);

    $wnm_custom = array( 'template_directory_uri' => get_template_directory_uri() );
    wp_localize_script( 'bxSlider-config', 'local_vars', $wnm_custom );

    wp_register_style('bxSlider-css', '//cdn.jsdelivr.net/bxslider/4.2.12/jquery.bxslider.css');

    wp_enqueue_style('bxSlider-css', '//cdn.jsdelivr.net/bxslider/4.2.12/jquery.bxslider.css');

    /*
     * Some page specific scripts that don't require loading on every page
     */

    // Woocommerce - Used to make sure every item in the shop has the same height
    if (is_shop()) {
      wp_enqueue_script('matchHeight', get_template_directory_uri() . '/js/jquery.matchHeight-min.js', array('jquery'), false);
    }

}

add_action('wp_enqueue_scripts', 'load_custom_scripts');

/*
 * Custom image thumbnail sizes
 */
add_image_size('slider_background', 1440, 660);
add_image_size('shop_album_cover', 250, 250);
add_image_size('course_cover', 250, 250);

/*
 * bbPress customisation
 */
function trim_forum_pagination_count($content) {
   // Remove everything after the )
   $result = explode("-", $content, 2);
   return $result[0];
}
apply_filters('bbp_get_forum_pagination_count', 'trim_forum_pagination_count');

/*
 * End bbPress customisation
 */

/*
 * Woocommerce customisations
 */

// Change number or products per row to 3
add_filter('loop_shop_columns', 'loop_columns');
if (!function_exists('loop_columns')) {
 function loop_columns() {
   return 3; // 3 products per row
 }
}

// Remove the 'view basket' option from the mini-cart.php section
remove_action( 'woocommerce_widget_shopping_cart_buttons', 'woocommerce_widget_shopping_cart_button_view_cart', 10 );

// Change the wording of the 'Checkout' button
remove_action( 'woocommerce_widget_shopping_cart_buttons', 'woocommerce_widget_shopping_cart_proceed_to_checkout', 20 );

function my_woocommerce_widget_shopping_cart_proceed_to_checkout() {
    echo '<button class="block_slider_button header_slider_button_colour block_slider_button_hover locationAware locationAwareHoverPurple" style="width:100%;"><a href="' . esc_url( wc_get_checkout_url() ) . '" class="checkout_link">' . esc_html__( 'Go To Checkout', 'woocommerce' ) . '<span></span></a></button>';
}

add_action( 'woocommerce_widget_shopping_cart_buttons', 'my_woocommerce_widget_shopping_cart_proceed_to_checkout', 20 );

add_filter( 'loop_shop_per_page', 'new_loop_shop_per_page', 20 );

function new_loop_shop_per_page( $cols ) {
  // $cols contains the current number of products per page based on the value stored on Options -> Reading
  // Return the number of products you wanna show per page.
  $cols = 6;
  return $cols;
}

/*
 * End Woocommerce customisations
 */

/*
 * LifterLMS customisations
 */

// Remove estimated course length
add_action( 'after_setup_theme', 'remove_lms_estimated_length' );
function remove_lms_estimated_length(){
	remove_action( 'lifterlms_after_loop_item_title', 'lifterlms_template_loop_length', 15 );
}

// Add a custom sidebar for the course catalogue
function lifter_course_catalogue_sidebar() {

	$args = array(
		'id'            => 'lifter_course_catalogue',
		'name'          => __( 'LifterLMS Course Catalogue', 'text_domain' ),
	);
	register_sidebar( $args );

}
add_action( 'widgets_init', 'lifter_course_catalogue_sidebar' );


/*
 * End LifterLMS customisations
 */
