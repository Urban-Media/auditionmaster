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

/*
* Header menu nav walker
*/
register_nav_menus( array(
    'header-menu'       => 'Header Menu',
    'company-menu'      => 'Company Menu',
    'membership-menu'   => 'Membership Menu',
    'useful-links-menu' => 'Useful Links Menu',
    'social-links-menu' => 'Social Links Menu',
    'legal-links-menu'  => 'Legal Links Menu'
) );

class Social_Links_Navwalker extends Walker_Nav_Menu {
  public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
      $url = '';
      if( !empty( $item->url ) ) {
          $url = $item->url;
      }

      $socialImage = get_template_directory_uri() . "/img/" . $item->title ."_icon.png";
      $output .= '<li class="social_link"><a href="' . $url . '"><img src="' . $socialImage .'"></span>';
  }

  public function end_el( &$output, $item, $depth = 0, $args = array() ) {
      $output .= '</a></li>';
  }
}

/*
 * Load page dependent scripts
 */
function load_custom_scripts() {
    wp_register_script('bxSlider', '//cdn.jsdelivr.net/bxslider/4.2.12/jquery.bxslider.min.js', array('jquery'), false);
    wp_register_script( 'bxSlider-config', get_template_directory_uri() . '/js/bxSlider-config.js', array('jquery', 'bxSlider'), false);
    wp_register_script('locationAwareHover', get_template_directory_uri() . '/js/button_hover_effect.js', array('jquery'), false);

    wp_enqueue_script('bxSlider', '//cdn.jsdelivr.net/bxslider/4.2.12/jquery.bxslider.min.js', array('jquery'), false);
    wp_enqueue_script( 'bxSlider-config', get_template_directory_uri() . '/js/bxSlider-config.js', array('jquery', 'bxSlider'), false);
    wp_enqueue_script('locationAwareHover', get_template_directory_uri() . '/js/button_hover_effect.js', array('jquery'), false);

    $wnm_custom = array( 'template_directory_uri' => get_template_directory_uri() );
    wp_localize_script( 'bxSlider-config', 'local_vars', $wnm_custom );

    wp_register_style('bxSlider-css', '//cdn.jsdelivr.net/bxslider/4.2.12/jquery.bxslider.css');
    wp_enqueue_style('bxSlider-css', '//cdn.jsdelivr.net/bxslider/4.2.12/jquery.bxslider.css');

}

add_action('wp_enqueue_scripts', 'load_custom_scripts');

/*
 * Custom image thumbnail sizes
 */
add_image_size('slider_background', 1440, 660);
