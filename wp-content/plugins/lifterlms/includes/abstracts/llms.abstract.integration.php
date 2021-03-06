<?php
/**
* LifterLMS Integration Abstract
*
* @since   3.0.0
* @version 3.8.0
*/

if ( ! defined( 'ABSPATH' ) ) { exit; }

abstract class LLMS_Abstract_Integration extends LLMS_Abstract_Options_Data {

	/**
	 * Integration ID
	 * Defined by extending class as a variable
	 * @var  string
	 */
	public $id = '';

	/**
	 * Integration Title
	 * Should be defined by extending class in configure() function (so it can be i18n)
	 * @var  string
	 */
	public $title = '';

	/**
	 * Integration Description
	 * Should be defined by extending class in configure() function (so it can be i18n)
	 * @var  string
	 */
	public $description = '';

	/**
	 * Integration Priority
	 * Detemines the order of the settings on the Integrations settings table
	 * Don't be arrogant developers, your integration may not be the most important to the user
	 * even if it is the most important to you
	 *
	 * Core integrations fire at 5
	 *
	 * @var  integer
	 */
	protected $priority = 20;

	/**
	 * Constructor
	 * @return   void
	 * @since    3.8.0
	 * @version  3.12.0
	 */
	public function __construct() {

		$this->configure();
		add_filter( 'lifterlms_integrations_settings', array( $this, 'add_settings' ), $this->priority, 1 );

	}

	/**
	 * Configure the integration
	 * Do things like configure ID and title here
	 * @return   void
	 * @since    3.8.0
	 * @version  3.8.0
	 */
	abstract protected function configure();

	public function add_settings( $settings ) {
		return array_merge( $settings, $this->get_settings() );
	}

	/**
	 * Get additional settings specific to the integration
	 * extending classes should override this with the settings
	 * specific to the integration
	 * @return   array
	 * @since    3.8.0
	 * @version  3.8.0
	 */
	protected function get_integration_settings() {
		return array();
	}

	/**
	 * Retrieve an array of integration related settings
	 * @return   array
	 * @since    3.8.0
	 * @version  3.8.0
	 */
	protected function get_settings() {

		$settings[] = array(
			'type' => 'sectionstart',
			'id' => 'llms_integration_' . $this->id . '_start',
			'class' => 'top',
		);
		$settings[] = array(
			'desc' => $this->description,
			'id' => 'llms_integration_' . $this->id . '_title',
			'title' => $this->title,
			'type' => 'title',
		);
		$settings[] = array(
			'desc' 		=> __( 'Check to enable this integration.', 'lifterlms' ),
			'default'	=> 'no',
			'id' 		=> $this->get_option_name( 'enabled' ),
			'type' 		=> 'checkbox',
			'title'     => __( 'Enable / Disable', 'lifterlms' ),
		);
		$settings = array_merge( $settings, $this->get_integration_settings() );
		$settings[] = array(
			'type' => 'sectionend',
			'id' => 'llms_integration_' . $this->id . '_end',
		);

		return apply_filters( 'llms_integration_' . $this->id . '_get_settings', $settings, $this );
	}

	/**
	 * @return   string
	 * @since    3.8.0
	 * @version  3.8.0
	 */
	protected function get_option_prefix() {
		return $this->option_prefix . 'integration_' . $this->id . '_';
	}

	/**
	 * Determine if the integration is enabled via the checkbox on the admin panel
	 * and the necessary plugin (if any) is installed and activated
	 * @return   boolean
	 * @since    3.0.0
	 * @version  3.8.0
	 */
	public function is_available() {
		return ( $this->is_enabled() && $this->is_installed() );
	}

	/**
	 * Detemine if the integration had been enabled via checkbox
	 * @return   boolean
	 * @since    3.0.0
	 * @version  3.8.0
	 */
	public function is_enabled() {
		return ( 'yes' === $this->get_option( 'enabled', 'no' ) );
	}

	/**
	 * Determine if the related plugin, theme, 3rd party is
	 * installed and activated
	 * extending classes should override this to perform dependency checks
	 * @return   boolean
	 * @since    3.0.0
	 * @version  3.8.0
	 */
	public function is_installed() {
		return true;
	}

}
