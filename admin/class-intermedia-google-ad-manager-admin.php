<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://www.intermedia.com.au/
 * @since      1.0.0
 *
 * @package    Intermedia_Google_Ad_Manager
 * @subpackage Intermedia_Google_Ad_Manager/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Intermedia_Google_Ad_Manager
 * @subpackage Intermedia_Google_Ad_Manager/admin
 * @author     Jose Anton <janton@intermedia.com.au>
 */
class Intermedia_Google_Ad_Manager_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	private $settings_page_handle = 'intermedia-google-ad-manager';

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

		$this->load_dependencies();

	}
	/**
	 * Load the required dependencies for the Admin facing functionality.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Wppb_Demo_Plugin_Admin_Settings. Registers the admin settings and page.
	 *
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin for the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) .  'admin/class-intermedia-google-ad-manager-settings.php';
		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) .  'admin/class-intermedia-google-ad-manager-dfp.php';
		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * event tracking.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) .  'admin/classs-intermedia-google-ad-manager-event-tracking.php';

		require_once plugin_dir_path( dirname( __FILE__ ) ) .  'admin/class-intermedia-google-ad-manager-block.php';

	}
	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Intermedia_Google_Ad_Manager_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Intermedia_Google_Ad_Manager_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/intermedia-google-ad-manager-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Intermedia_Google_Ad_Manager_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Intermedia_Google_Ad_Manager_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/intermedia-google-ad-manager-admin.js', array( 'jquery' ), $this->version, false );

	}

}
