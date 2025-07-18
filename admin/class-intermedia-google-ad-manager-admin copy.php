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

	/**
	 * Create a custom top-level menu page
	 *
	 * @since    1.0.0
	 */
	public function create_menu_admin() {

		//create new top-level menu
		add_menu_page (
			'Intermedia Google ad manager', 
			'Intermedia Google ad manager', 
			'administrator', 
			$this->settings_page_handle, 
			array( $this, 'render_admin' ),
			plugins_url( 'intermedia-google-ad-manager/admin/assets/images/google_20.png' )
		);
		
	}

	/**
	 * Load the plugin admin page template/partial.
	 *
	 * @since    1.0.0
	 */
	public function render_admin() {
	
		require_once plugin_dir_path( __FILE__ ). 'partials/intermedia-google-ad-manager-admin-display.php';
		
	}


    public function render_tab( $tab ) {
		
        /* BEGIN HTML OUTPUT */
        ob_start(); // Turn on output buffering

		require_once plugin_dir_path( __FILE__ ). 'partials/'.$tab.'-tab.php';

        /* END HTML OUTPUT */
        $output = ob_get_contents(); // collect output

        ob_end_clean(); // Turn off ouput buffer

        return $output; // Print output

	}
	public function dfp_register_setting(){

		//Get the active tab from the $_GET param
		$default_tab = null;
		$tab = isset($_GET['tab']) ? $_GET['tab'] : $default_tab;
	 
		add_settings_section(
			'my_section_id_1', // section ID
			'This is the '.$tab.' tab.', // title (if needed)
			'', // callback function (if needed)
			'intermedia-google-ad-manager', // page slug
		);

		register_setting(
			'default_settings', // settings group name
			'my_option', // option name
			'sanitize_text_field' // sanitization function
		);
			
		add_settings_field(
			'my_option',
			'My default option',
			$this->dfp_text_field_html(), // function which prints the field
			'intermedia-google-ad-manager', // page slug
			'my_section_id_1', // section ID
			array( 
				'label_for' => 'my_option',
				'class' => 'dfp-class', // for <tr> element
			)
		);

	 
	}
	 
	public function dfp_text_field_html(){
 
		$text = get_option( 'my_option' );
 
		printf(
			'<input type="text" id="my_option" name="my_option" value="%s" />',
			esc_attr( $text )
		);
	}

}
