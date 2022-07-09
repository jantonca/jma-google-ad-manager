<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://www.intermedia.com.au/
 * @since      1.0.0
 *
 * @package    Intermedia_Google_Ad_Manager
 * @subpackage Intermedia_Google_Ad_Manager/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Intermedia_Google_Ad_Manager
 * @subpackage Intermedia_Google_Ad_Manager/includes
 * @author     Jose Anton <janton@intermedia.com.au>
 */
class Intermedia_Google_Ad_Manager {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Intermedia_Google_Ad_Manager_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'INTERMEDIA_GOOGLE_AD_MANAGER_VERSION' ) ) {
			$this->version = INTERMEDIA_GOOGLE_AD_MANAGER_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'intermedia-google-ad-manager';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Intermedia_Google_Ad_Manager_Loader. Orchestrates the hooks of the plugin.
	 * - Intermedia_Google_Ad_Manager_i18n. Defines internationalization functionality.
	 * - Intermedia_Google_Ad_Manager_Admin. Defines all hooks for the admin area.
	 * - Intermedia_Google_Ad_Manager_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-intermedia-google-ad-manager-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-intermedia-google-ad-manager-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-intermedia-google-ad-manager-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-intermedia-google-ad-manager-public.php';

		$this->loader = new Intermedia_Google_Ad_Manager_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Intermedia_Google_Ad_Manager_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Intermedia_Google_Ad_Manager_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Intermedia_Google_Ad_Manager_Admin( $this->get_plugin_name(), $this->get_version() );
		$igam_settings = new IGAM_Admin_Settings( $this->get_plugin_name(), $this->get_version() );
		$igam_dfp = new IGAM_DFP( $this->get_plugin_name(), $this->get_version() );
		//$igam_event_tracking = new IGAM_Event_Tracking ($this->get_plugin_name(), $this->get_version());
		$igam_block = new IGAM_Block( $this->get_plugin_name(), $this->get_version() );


		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

		// Hooks into admin_menu hook to add custom page
		$this->loader->add_action( 'admin_menu', $igam_settings, 'setup_plugin_options_menu' );
		$this->loader->add_action( 'admin_init', $igam_settings, 'initialize_general_settings' );
		$this->loader->add_action( 'admin_init', $igam_settings, 'initialize_mrec_options' );
		$this->loader->add_action( 'admin_init', $igam_settings, 'initialize_halfpage_options' );
		$this->loader->add_action( 'admin_init', $igam_settings, 'initialize_leaderboard_options' );
		$this->loader->add_action( 'admin_init', $igam_settings, 'initialize_skin_options' );
		$this->loader->add_action( 'admin_init', $igam_settings, 'initialize_dfp_tags_options' );
		// Hook: Block assets.
		$this->loader->add_action( 'init', $igam_block, 'intermedia_google_ad_manager_blocks_cgb_block_assets' );
		//metaboxes
		$this->loader->add_action( 'init', $igam_settings, 'register_meta_dfp_tag' );
		$this->loader->add_action( 'add_meta_boxes', $igam_settings, 'define_dfp_metabox' );
		$this->loader->add_action( 'save_post', $igam_settings, 'save_dfp_metabox' );
		//DFP JS
		$this->loader->add_action( 'wp_head', $igam_dfp, 'render_gam_head' );
		$this->loader->add_action( 'body_class', $igam_dfp, 'add_body_skin_class' );
		$this->loader->add_action( 'wp_body_open', $igam_dfp, 'render_skins' );
		//event tracker
		//tracking DIVI sites add_footer_tracking_code
		// if( class_exists( 'ET_Dashboard' ) ) {
		// 	$this->loader->add_action( 'wp_head', $igam_event_tracking, 'track_bloom_form_submit' );
		// }
		// $this->loader->add_action( 'wp_footer', $igam_event_tracking, 'add_footer_tracking_code' );
		
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Intermedia_Google_Ad_Manager_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Intermedia_Google_Ad_Manager_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
