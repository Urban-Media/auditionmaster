<?php
/**
* Plugin Name: LifterLMS WooCommerce
* Plugin URI: https://lifterlms.com/
* Description: Sell LifterLMS Courses and Memberships using WooCommerce
* Version: 1.3.2
* Author: Thomas Patrick Levy
* Author URI: https://lifterlms.com
* Text Domain: lifterlms-woocommerce
* Domain Path: /languages
* License: GPLv2
* License URI: https://www.gnu.org/licenses/gpl-2.0.html
* Requires at least: 4.2
* Tested up to: 4.5.3
*
* @package 		LifterLMS WooCommerce
* @category 	Core
* @author 		LifterLMS
*/
final class LifterLMS_WooCommerce {

	public $version = '1.3.2';
	protected static $_instance = null;

	/**
	 * Main Instance of LifterLMS_WooCommerce
	 * Ensures only one instance of LifterLMS_WooCommerce is loaded or can be loaded.
	 * @since    1.0.0
	 * @version  1.0.0
	 * @see      LLMS_WooCommerce()
	 * @return   LifterLMS_WooCommerce - Main instance
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	/**
	 * Constructor
	 * @since    1.0.0
	 * @version  1.1.0
	 * @return   void
	 */
	private function __construct() {

		if ( ! defined( 'LLMS_WC_PLUGIN_FILE' ) ) {
			define( 'LLMS_WC_PLUGIN_FILE', __FILE__ );
		}
		if ( ! defined( 'LLMS_WC_PLUGIN_DIR' ) ) {
			define( 'LLMS_WC_PLUGIN_DIR', WP_PLUGIN_DIR . '/' . plugin_basename( dirname( __FILE__ ) ) . '/' );
		}

		add_action( 'init', array( $this, 'load_textdomain' ), 0 );

		register_activation_hook( __FILE__, array( $this, 'install' ) );
		add_action( 'plugins_loaded', array( $this, 'init' ), 10 );

	}

	/**
	 * Initialize, require, add hooks & filters
	 * @since    1.0.0
	 * @version  1.1.0
	 * @return   void
	 */
	public function init() {

		if ( function_exists( 'LLMS' ) ) {

			// includes
			require_once 'includes/functions.llms.integration.woocommerce.php';
			require_once 'includes/class.llms.integration.woocommerce.php';
			require_once 'includes/class.llms.settings.woocommerce.php';

			// register the integration
			add_filter( 'lifterlms_integrations', array( $this, 'register_integration' ), 10, 1 );

		}

	}

	/**
	 * Load Localization files
	 *
	 * The first loaded file takes priority
	 *
	 * Files can be found in the following order:
	 * 		WP_LANG_DIR/lifterlms/lifterlms-woocommerce-LOCALE.mo
	 * 		wp_content/plugins/lifterlms-integration-woocommerce/i18n/lifterlms-woocommerce-LOCALE.mo
	 *
	 * @return   void
	 * @since    1.1.0
	 * @version  1.1.0
	 */
	public function load_textdomain() {

		// load locale
		$locale = apply_filters( 'plugin_locale', get_locale(), 'lifterlms-woocommerce' );

		// load a lifterlms specific locale file if one exists
		load_textdomain( 'lifterlms-woocommerce', WP_LANG_DIR . '/lifterlms/lifterlms-woocommerce-' . $locale . '.mo' );

		// load localization files
		load_plugin_textdomain( 'lifterlms-woocommerce', false, dirname( plugin_basename( __FILE__ ) ) . '/i18n' );

	}

	/**
	 * Called during plugin activation
	 * This is necessary for b/c of the endpoints added to WC Account Page
	 * @return   void
	 * @since    1.0.0
	 * @version  1.0.0
	 */
	public function install() {
		flush_rewrite_rules();
	}

	/**
	 * Register the integration with LifterLMS
	 * @param    array     $integrations  array of LifterLMS Integration Classes
	 * @return   array
	 * @since    1.0.0
	 * @version  1.0.0
	 */
	public function register_integration( $integrations ) {
		$integrations[] = 'LLMS_Integration_WooCommerce';
		return $integrations;
	}

}
/**
 * Returns the main instance of LLMS
 * @since  1.0.0
 * @version  1.0.0
 * @return LifterLMS
 */
function LLMS_WooCommerce() {
	return LifterLMS_WooCommerce::instance();
}
return LLMS_WooCommerce();
