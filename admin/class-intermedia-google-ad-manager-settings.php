<?php

/**
 * The settings of the plugin.
 *
 * @link       https://www.intermedia.com.au/
 * @since      1.0.0
 *
 * @package    Intermedia_Google_Ad_Manager
 * @subpackage Intermedia_Google_Ad_Manager/admin
 */

/**
 * Class WordPress_Plugin_Template_Settings
 *
 */
class IGAM_Admin_Settings {

    private $settings_page_handle = 'intermedia_google_ad_manager';

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
	 * This function introduces the theme options into the 'Appearance' menu and into a top-level
	 * 'IGAM Demo' menu.
	 */
	public function setup_plugin_options_menu() {

		//Add the menu to the Plugins set of menu items
		add_menu_page(
			'Intermedia Google ad manager', 					// The title to be displayed in the browser window for this page.
			'Intermedia Google ad manager',					// The text to be displayed for this menu item
			'manage_options',					// Which type of users can see this menu item
			$this->settings_page_handle,			// The unique ID - that is, the slug - for this menu item
            array( $this, 'render_settings_page_content'),			// The name of the function to call when rendering this menu's page
            plugins_url( 'intermedia-google-ad-manager/admin/assets/images/google_20.png' )
        );

	}

	/**
	 * Provides default values for the General Settings Options.
	 *
	 * @return array
	 */
	public function default_general_settings() {

		$defaults = array(
			'show_skins'	    =>	'',
			'show_mrec'		    =>	'',
            'show_half_page'	=>	'',
            'show_leaderboard'	=>	'',
			'gam_network_code'	=>	'',
		);

		return $defaults;

    }
    
    /**
	 * Provide default values for the MREC Options.
	 *
	 * @return array
	 */
	public function default_mrec_options() {

		$defaults = array(
            'amount_slots'	=>	false,
			'define_slot'	=>	'',
			'define_sizes'	=>	'',
		);

		return  $defaults;

	}
    /**
	 * Provide default values for the Half Page Options.
	 *
	 * @return array
	 */
	public function default_halfpage_options() {

		$defaults = array(
            'amount_slots'	=>	false,
			'define_slot'	=>	'',
			'define_sizes'	=>	'',
		);

		return  $defaults;

	}
	/**
	 * Provide default values for the Skin Options.
	 *
	 * @return array
	 */
	public function default_skin_options() {

		$defaults = array(
            'amount_slots'	=>	'default',
			'define_slot'	=>	'',
			'define_sizes'	=>	'',
			'activate_skin' => 'no-skin',
		);

		return  $defaults;

	}
	/**
	 * Provide default values for the Skin Options.
	 *
	 * @return array
	 */
	public function default_dfp_tags_options() {
		$options = get_option('intermedia_google_ad_manager_dfp_tags_options');
		if( $options['amount_dfp_tags'] === 'default' ) {
			$defaults = array(
				'amount_dfp_tags'	=>	false,
			);
		}

		return  $defaults;

	}
    /**
	 * Provide default values for the Leaderboard Options.
	 *
	 * @return array
	 */
	public function default_leaderboard_options() {

		$defaults = array(
            'amount_slots'	=>	false,
			'define_slot'	=>	'',
			'define_sizes'	=>	'',
		);

		return  $defaults;

	}

	/**
	 * Renders a simple page to display for the theme menu defined above.
	 */
	public function render_settings_page_content( $active_tab = '' ) {
        $show_options = get_option('intermedia_google_ad_manager_general_settings');
		?>
		<!-- Create a header in the default WordPress 'wrap' container -->
		<div class="wrap">

			<h2><?php _e( 'Intermedia Google Ad Manager', 'intermedia-google-ad-manager' ); ?></h2>

			<?php settings_errors(); ?>

			<?php if( isset( $_GET[ 'tab' ] ) ) {
                $active_tab = $_GET[ 'tab' ];
            } else if( $active_tab == 'mrec_options' ) {
				$active_tab = 'mrec_options';
			} else if( $active_tab == 'halfpage_options' ) {
				$active_tab = 'halfpage_options';
			} else if( $active_tab == 'leaderboard_options' ) {
				$active_tab = 'leaderboard_options';
			} else if( $active_tab == 'skin_options' ) {
				$active_tab = 'skin_options';
			} else if( $active_tab == 'dfp_tags_options' ) {
				$active_tab = 'dfp_tags_options';
			} else {
				$active_tab = 'general_settings';
			} // end if/else ?>

			<h2 class="nav-tab-wrapper">
				<a href="?page=<?php echo $this->settings_page_handle; ?>&tab=general_settings" class="nav-tab <?php echo $active_tab == 'general_settings' ? 'nav-tab-active' : ''; ?>"><?php _e( 'General settings', 'intermedia-google-ad-manager' ); ?></a>
                <?php if ( isset( $show_options[ 'show_mrec'] ) ): ?>
                <a href="?page=<?php echo $this->settings_page_handle; ?>&tab=mrec_options" class="nav-tab <?php echo $active_tab == 'mrec_options' ? 'nav-tab-active' : ''; ?>"><?php _e( 'MREC Options', 'intermedia-google-ad-manager' ); ?></a>
				<?php endif; ?>
				<?php if ( isset( $show_options[ 'show_half_page'] ) ): ?>
                <a href="?page=<?php echo $this->settings_page_handle; ?>&tab=halfpage_options" class="nav-tab <?php echo $active_tab == 'halfpage_options' ? 'nav-tab-active' : ''; ?>"><?php _e( 'Half Page Options', 'intermedia-google-ad-manager' ); ?></a>
				<?php endif; ?>
				<?php if ( isset( $show_options[ 'show_leaderboard'] ) ): ?>
                <a href="?page=<?php echo $this->settings_page_handle; ?>&tab=leaderboard_options" class="nav-tab <?php echo $active_tab == 'leaderboard_options' ? 'nav-tab-active' : ''; ?>"><?php _e( 'Leaderboard Options', 'intermedia-google-ad-manager' ); ?></a>
                <?php endif; ?>
				<?php if ( isset( $show_options[ 'show_skins'] ) ): ?>
                <a href="?page=<?php echo $this->settings_page_handle; ?>&tab=skin_options" class="nav-tab <?php echo $active_tab == 'skin_options' ? 'nav-tab-active' : ''; ?>"><?php _e( 'Skin Options', 'intermedia-google-ad-manager' ); ?></a>
                <?php endif; ?>
				<?php if ( isset( $show_options[ 'show_dfp_tags'] ) ): ?>
                <a href="?page=<?php echo $this->settings_page_handle; ?>&tab=dfp_tags_options" class="nav-tab <?php echo $active_tab == 'dfp_tags_options' ? 'nav-tab-active' : ''; ?>"><?php _e( 'DFP Tags', 'intermedia-google-ad-manager' ); ?></a>
                <?php endif; ?>
			</h2>

			<form method="post" action="options.php">
				<?php

				if( $active_tab == 'general_settings' ) {

					settings_fields( 'intermedia_google_ad_manager_general_settings' );
                    do_settings_sections( 'intermedia_google_ad_manager_general_settings' );
                    
                } elseif( $active_tab == 'mrec_options' ) {

					settings_fields( 'intermedia_google_ad_manager_mrec_options' );
					do_settings_sections( 'intermedia_google_ad_manager_mrec_options' );

				} elseif( $active_tab == 'halfpage_options' ) {

					settings_fields( 'intermedia_google_ad_manager_halfpage_options' );
					do_settings_sections( 'intermedia_google_ad_manager_halfpage_options' );

				} elseif( $active_tab == 'leaderboard_options' ) {

					settings_fields( 'intermedia_google_ad_manager_leaderboard_options' );
					do_settings_sections( 'intermedia_google_ad_manager_leaderboard_options' );

				} elseif( $active_tab == 'skin_options' ) {

					settings_fields( 'intermedia_google_ad_manager_skin_options' );
					do_settings_sections( 'intermedia_google_ad_manager_skin_options' );

				} elseif( $active_tab == 'dfp_tags_options' ) {

					settings_fields( 'intermedia_google_ad_manager_dfp_tags_options' );
					do_settings_sections( 'intermedia_google_ad_manager_dfp_tags_options' );

				} else {

					settings_fields( 'intermedia_google_ad_manager_input_examples' );
					do_settings_sections( 'intermedia_google_ad_manager_input_examples' );

				} // end if/else

				submit_button();

				?>
			</form>

		</div><!-- /.wrap -->
	<?php
	}

	/**
	 * This function provides a simple description for the General Options page.
	 *
	 * It's called from the 'initialize_general_settings' function by being passed as a parameter
	 * in the add_settings_section function.
	 */
	public function general_settings_callback() {
		$options = get_option('intermedia_google_ad_manager_general_settings');
		highlight_string("General Options [intermedia_google_ad_manager_general_settings]:\n" . var_export( $options, true ) );
		echo '<p>' . __( 'Select which ads of GPT you wish to display on the site.', $this->plugin_name ) . '</p>';
    } // end general_settings_callback
    
	/**
	 * This function provides a simple description for the MREC Options page.
	 *
	 * It's called from the '' function by being passed as a parameter
	 * in the add_settings_section function.
	 */
	public function mrec_options_callback() {
		$options = get_option('intermedia_google_ad_manager_mrec_options');
		highlight_string("MREC Options [intermedia_google_ad_manager_mrec_options]:\n" . var_export( $options, true ) );
		echo '<p>' . __( 'MREC you\'d like to display.', $this->plugin_name ) . '</p>';
    } // end general_settings_callback
    /**
	 * This function provides a simple description for the MREC Options page.
	 *
	 * It's called from the '' function by being passed as a parameter
	 * in the add_settings_section function.
	 */
	public function halfpage_options_callback() {
		$options = get_option('intermedia_google_ad_manager_halfpage_options');
		highlight_string("Half Page Options [intermedia_google_ad_manager_halfpage_options]:\n" . var_export( $options, true ) );
		echo '<p>' . __( 'Half Page you\'d like to display.', $this->plugin_name ) . '</p>';
	} // end general_settings_callback
	/**
	 * This function provides a simple description for the MREC Options page.
	 *
	 * It's called from the '' function by being passed as a parameter
	 * in the add_settings_section function.
	 */
	public function leaderboard_options_callback() {
		$options = get_option('intermedia_google_ad_manager_leaderboard_options');
		highlight_string("Leaderboard Options [intermedia_google_ad_manager_leaderboard_options]:\n" . var_export( $options, true ) );
		echo '<p>' . __( 'Leaderboard you\'d like to display.', $this->plugin_name ) . '</p>';
    } // end general_settings_callback
	/**
	 * This function provides a simple description for the Skins Options page.
	 *
	 * It's called from the 'igam-demo_theme_initialize_social_options' function by being passed as a parameter
	 * in the add_settings_section function.
	 */
	public function skin_options_callback() {
		$options = get_option('intermedia_google_ad_manager_skin_options');
		highlight_string("Skin Options [intermedia_google_ad_manager_skin_options]:\n" . var_export( $options, true ) );
		echo '<p>' . __( 'Skin you\'d like to display.', $this->plugin_name ) . '</p>';
	} // end general_settings_callback
	/**
	 * This function provides a simple description for the DFP Tgas Options page.
	 *
	 * It's called from the 'igam-demo_theme_initialize_social_options' function by being passed as a parameter
	 * in the add_settings_section function.
	 */
	public function dfp_tags_options_callback() {
		$options = get_option('intermedia_google_ad_manager_dfp_tags_options');
		highlight_string("DFP Options [intermedia_google_ad_manager_dfp_tags_options]:\n" . var_export( $options, true ) );
		echo '<p>' . __( 'DFP Tags you\'d like to display.', $this->plugin_name ) . '</p>';
	} // end general_settings_callback
	/**
	 * Initializes the theme's display options page by registering the Sections,
	 * Fields, and Settings.
	 *
	 * This function is registered with the 'admin_init' hook.
	 */
	public function initialize_general_settings() {

		$option_name = 'intermedia_google_ad_manager_general_settings';
		$section_name = 'general_settings_section';

		// If the theme options don't exist, create them.
		if( false == get_option( 'intermedia_google_ad_manager_general_settings' ) ) {
			$default_array = $this->default_general_settings();
			add_option( $option_name, $default_array );
		}

		$values = get_option( $option_name );

		add_settings_section(
			$section_name,			                        	// ID used to identify this section and with which to register options
			__( 'General settings', $this->plugin_name ),   	// Title to be displayed on the administration page
			array( $this, 'general_settings_callback'),	    	// Callback used to render the description of the section
			'intermedia_google_ad_manager_general_settings'		// Page on which to add this section of options
		);

		add_settings_field(
			'GAM Network Code',
			__( 'GAM Network Code', $this->plugin_name ),
			array( $this, 'input_render_callback'),
			$option_name,  										// menu slug, see t5_sae_add_options_page()
			$section_name,
			array (
				'label_for'   => 'label1', 						// makes the field name clickable,
				'name'        => 'gam_network_code', 				// value for 'name' attribute
				'value'       => esc_attr( $values['gam_network_code'] ),
				'option_name' => $option_name,
				'type' 		  => 'text',
			)
		);

        // The fields for toggling the visibility of content elements.
		add_settings_field(
			'show_skins',						                // ID used to identify the field throughout the theme
			__( 'Skins', $this->plugin_name ),	    			// The label to the left of the option interface element
			array( $this, 'checkbox_render_callback'),	        // The name of the function responsible for rendering the option interface
			$option_name,    									// The page on which this option will be displayed
			$section_name,			                			// The name of the section to which this field belongs
			array (
				'label_for'   => __( 'Activate this setting to display skins.', $this->plugin_name ),
				'name'        => 'show_skins', 					// value for 'name' attribute
				'value'       => esc_attr( isset( $values['show_skins'] ) ),
				'option_name' => $option_name,
				'checked' => !isset( $values['show_skins'] ) ? : 'checked="checked'
			)
		);

		add_settings_field(
			'show_mrec',						                // ID used to identify the field throughout the theme
			__( 'MREC', $this->plugin_name ),	    			// The label to the left of the option interface element
			array( $this, 'checkbox_render_callback'),	        // The name of the function responsible for rendering the option interface
			$option_name,    									// The page on which this option will be displayed
			$section_name,			                			// The name of the section to which this field belongs
			array (
				'label_for'   => __( 'Activate this setting to display MREC ads.', $this->plugin_name ),
				'name'        => 'show_mrec', 					// value for 'name' attribute
				'value'       => esc_attr( isset( $values['show_mrec'] ) ),
				'option_name' => $option_name,
				'checked' => !isset( $values['show_mrec'] ) ? : 'checked="checked'
			)
		);
		
		add_settings_field(
			'show_half_page',						             // ID used to identify the field throughout the theme
			__( 'Half Page', $this->plugin_name ),	    	     // The label to the left of the option interface element
			array( $this, 'checkbox_render_callback'),	         // The name of the function responsible for rendering the option interface
			$option_name,    									 // The page on which this option will be displayed
			$section_name,			                			 // The name of the section to which this field belongs
			array (
				'label_for'   => __( 'Activate this setting to display Half Page ads.', $this->plugin_name ),
				'name'        => 'show_half_page', 					// value for 'name' attribute
				'value'       => esc_attr( isset( $values['show_half_page'] ) ),
				'option_name' => $option_name,
				'checked' => !isset( $values['show_half_page'] ) ? : 'checked="checked'
			)
		);

		add_settings_field(
			'show_leaderboard',						                // ID used to identify the field throughout the theme
			__( 'Leaderboard', $this->plugin_name ),	    		// The label to the left of the option interface element
			array( $this, 'checkbox_render_callback'),	        	// The name of the function responsible for rendering the option interface
			$option_name,    										// The page on which this option will be displayed
			$section_name,			                				// The name of the section to which this field belongs
			array (
				'label_for'   => __( 'Activate this setting to display Leaderboard and Billboard ads.', $this->plugin_name ),
				'name'        => 'show_leaderboard', 				// value for 'name' attribute
				'value'       => esc_attr( isset( $values['show_leaderboard'] ) ),
				'option_name' => $option_name,
				'checked' => !isset( $values['show_leaderboard'] ) ? : 'checked="checked'
			)
		);

		// The fields for toggling the visibility of content elements.
		add_settings_field(
			'show_dfp_tags',						                // ID used to identify the field throughout the theme
			__( 'DFP Tags', $this->plugin_name ),	    			// The label to the left of the option interface element
			array( $this, 'checkbox_render_callback'),	        // The name of the function responsible for rendering the option interface
			$option_name,    									// The page on which this option will be displayed
			$section_name,			                			// The name of the section to which this field belongs
			array (
				'label_for'   => __( 'Activate this setting to create DFP Tags.', $this->plugin_name ),
				'name'        => 'show_dfp_tags', 					// value for 'name' attribute
				'value'       => esc_attr( isset( $values['show_dfp_tags'] ) ),
				'option_name' => $option_name,
				'checked' => !isset( $values['show_dfp_tags'] ) ? : 'checked="checked'
			)
		);

		// Finally, we register the fields with WordPress
		register_setting(
			'intermedia_google_ad_manager_general_settings',
			'intermedia_google_ad_manager_general_settings'
		);

	} // end initialize_general_settings

	/**
	 * Initializes the theme's input example by registering the Sections,
	 * Fields, and Settings. This particular group of options is used to
	 * validation and sanitization.
	 *
	 * This function is registered with the 'admin_init' hook.
	 */
	public function initialize_mrec_options() {

		$option_name = 'intermedia_google_ad_manager_mrec_options';
		$section_name = 'input_mrec_section';

		//delete_option('intermedia_google_ad_manager_leaderboard_options');
		$values = get_option( $option_name );
		$amount_mrec = (int) $values[ 'amount_slots' ];

		if( 'default' === $values[ 'amount_slots' ] ) {
			$default_array = $this->default_dfp_tags_options();
			update_option( $option_name, $default_array );
		} // end if

		add_settings_section(
			$section_name,
			__( 'MREC Options', $this->plugin_name ),
			array( $this, 'mrec_options_callback'),
			$option_name
		);

		add_settings_field(
			'Select the amount of slots',
			__( 'Select the amount of slots.', $this->plugin_name ),
			array( $this, 'select_render_callback'),
			$option_name,  // menu slug, see t5_sae_add_options_page()
			$section_name,
			array (
				'label_for'   => 'amount_slots', // makes the field name clickable,
				'name'        => 'amount_slots', // value for 'name' attribute
				'value'       => esc_attr( $values['amount_slots'] ),
				'options'     => array (
					'default' => 'Select a slot amount...',
					1 => 1,
					2 => 2,
					3 => 3,
					4 => 4,
					6 => 6,
					7 => 7,
					8 => 8,
					9 => 9,
					10 => 10
				),
				'option_name' => $option_name
			)
		);

		for ($i=0; $i < $amount_mrec; $i++) {

			add_settings_field(
				'MREC Slot '.$i,
				__( 'MREC Slot '.$i, $this->plugin_name ),
				array( $this, 'input_render_callback'),
				$option_name,  // menu slug, see t5_sae_add_options_page()
				$section_name,
				array (
					'label_for'   => 'label_slot_'.$i, // makes the field name clickable,
					'name'        => 'define_slot_'.$i, // value for 'name' attribute
					'value'       => esc_attr( isset($values['define_slot_'.$i])? $values['define_slot_'.$i]: ''),
					'option_name' => $option_name,
					'type' 		  => 'text',
				)
			);
			add_settings_field(
				'MREC Sizes '.$i,
				__( 'MREC Sizes '.$i, $this->plugin_name ),
				array( $this, 'input_render_callback'),
				$option_name,  // menu slug, see t5_sae_add_options_page()
				$section_name,
				array (
					'label_for'   => 'label_size_'.$i, // makes the field name clickable,
					'name'        => 'define_sizes_'.$i, // value for 'name' attribute
					'value'       => esc_attr( isset($values['define_sizes_'.$i])? $values['define_sizes_'.$i]: ''),
					'option_name' => $option_name,
					'type' 		  => 'text',
				)
			);
		}

		register_setting(
			'intermedia_google_ad_manager_mrec_options',
			'intermedia_google_ad_manager_mrec_options',
			array( $this, 'validate_input_data')
		);

	}
	/**
	 * Initializes the theme's input example by registering the Sections,
	 * Fields, and Settings. This particular group of options is used to
	 * validation and sanitization.
	 *
	 * This function is registered with the 'admin_init' hook.
	 */
	public function initialize_halfpage_options() {

		$option_name = 'intermedia_google_ad_manager_halfpage_options';
		$section_name = 'input_halfpage_section';

		//delete_option('intermedia_google_ad_manager_leaderboard_options');
		$values = get_option( $option_name );
		$amount_halfpage = (int) $values[ 'amount_slots' ];

		if( 'default' === $values[ 'amount_slots' ] ) {
			$default_array = $this->default_dfp_tags_options();
			update_option( $option_name, $default_array );
		} // end if

		add_settings_section(
			$section_name,
			__( 'Half Page Options', 'intermedia-google-ad-manager' ),
			array( $this, 'halfpage_options_callback'),
			$option_name
		);

		add_settings_field(
			'Select the amount of slots',
			__( 'Select the amount of slots.', $this->plugin_name ),
			array( $this, 'select_render_callback'),
			$option_name,  // menu slug, see t5_sae_add_options_page()
			$section_name,
			array (
				'label_for'   => 'label22', // makes the field name clickable,
				'name'        => 'amount_slots', // value for 'name' attribute
				'value'       => esc_attr( $values['amount_slots'] ),
				'options'     => array (
					'default' => 'Select a slot amount...',
					1 => 1,
					2 => 2,
					3 => 3,
					4 => 4,
					6 => 6,
					7 => 7,
					8 => 8,
					9 => 9,
					10 => 10
				),
				'option_name' => $option_name
			)
		);

		for ($i=0; $i < $amount_halfpage; $i++) {

			add_settings_field(
				'Half Page Slot '.$i,
				__( 'Half Page Slot '.$i, $this->plugin_name ),
				array( $this, 'input_render_callback'),
				$option_name,  // menu slug, see t5_sae_add_options_page()
				$section_name,
				array (
					'label_for'   => 'label_slot_'.$i, // makes the field name clickable,
					'name'        => 'define_slot_'.$i, // value for 'name' attribute
					'value'       => esc_attr( isset($values['define_slot_'.$i])? $values['define_slot_'.$i]: ''),
					'option_name' => $option_name,
					'type' 		  => 'text',
				)
			);
			add_settings_field(
				'Half Page Sizes '.$i,
				__( 'Half Page Sizes '.$i, $this->plugin_name ),
				array( $this, 'input_render_callback'),
				$option_name,  // menu slug, see t5_sae_add_options_page()
				$section_name,
				array (
					'label_for'   => 'label_size_'.$i, // makes the field name clickable,
					'name'        => 'define_sizes_'.$i, // value for 'name' attribute
					'value'       => esc_attr( isset($values['define_sizes_'.$i])? $values['define_sizes_'.$i]: ''),
					'option_name' => $option_name,
					'type' 		  => 'text',
				)
			);
		}

		register_setting(
			'intermedia_google_ad_manager_halfpage_options',
			'intermedia_google_ad_manager_halfpage_options',
			array( $this, 'validate_input_data')
		);

	}
	/**
	 * Initializes the theme's input example by registering the Sections,
	 * Fields, and Settings. This particular group of options is used to
	 * validation and sanitization.
	 *
	 * This function is registered with the 'admin_init' hook.
	 */
	public function initialize_skin_options() {

		$option_name = 'intermedia_google_ad_manager_skin_options';
		$section_name = 'input_skin_section';

		//delete_option('intermedia_google_ad_manager_leaderboard_options');
		$values = get_option( $option_name );
		$amount_skin = (int) $values[ 'amount_slots' ];

		if( 'default' === $values[ 'amount_slots' ] ) {
			$default_array = $this->default_skin_options();
			update_option( $option_name, $default_array );
		} // end if

		add_settings_section(
			$section_name,
			__( 'Skin Options', 'intermedia-google-ad-manager' ),
			array( $this, 'skin_options_callback'),
			$option_name
		);

		add_settings_field(
			'Select the amount of slots',
			__( 'Select the amount of slots.', $this->plugin_name ),
			array( $this, 'select_render_callback'),
			$option_name,  // menu slug, see t5_sae_add_options_page()
			$section_name,
			array (
				'label_for'   => 'label23', // makes the field name clickable,
				'name'        => 'amount_slots', // value for 'name' attribute
				'value'       => esc_attr( $values['amount_slots'] ),
				'options'     => array (
					'default' => 'Select a slot amount...',
					1 => 1,
					2 => 2,
					3 => 3,
				),
				'option_name' => $option_name
			)
		);

		for ($i=0; $i < $amount_skin; $i++) {

			add_settings_field(
				'Skin Slot '.$i,
				__( 'Skin Slot '.$i, $this->plugin_name ),
				array( $this, 'input_render_callback'),
				$option_name,  // menu slug, see t5_sae_add_options_page()
				$section_name,
				array (
					'label_for'   => 'label_slot_'.$i, // makes the field name clickable,
					'name'        => 'define_slot_'.$i, // value for 'name' attribute
					'value'       => esc_attr( isset($values['define_slot_'.$i])? $values['define_slot_'.$i]: ''),
					'option_name' => $option_name,
					'type' 		  => 'text',
				)
			);
			add_settings_field(
				'Skin Sizes '.$i,
				__( 'Skin Sizes '.$i, $this->plugin_name ),
				array( $this, 'input_render_callback'),
				$option_name,  // menu slug, see t5_sae_add_options_page()
				$section_name,
				array (
					'label_for'   => 'label_size_'.$i, // makes the field name clickable,
					'name'        => 'define_sizes_'.$i, // value for 'name' attribute
					'value'       => esc_attr( isset($values['define_sizes_'.$i])? $values['define_sizes_'.$i]: ''),
					'option_name' => $option_name,
					'type' 		  => 'text',
				)
			);

		}
		if( $amount_skin ) {
			add_settings_field(
				'Activate Skins',
				__( 'Activate skins', $this->plugin_name ),
				array( $this, 'radio_element_callback'),
				$option_name,
				$section_name
			);
		} else {
			if( isset($values['activate_skin'] ) ) {
				$values['activate_skin'] = 'no-skin';
				update_option( $option_name, $values );
				var_dump('no skin: '.$values['activate_skin']);
			}
			
		}
		register_setting(
			'intermedia_google_ad_manager_skin_options',
			'intermedia_google_ad_manager_skin_options',
			array( $this, 'validate_input_data')
		);

	}
		/**
	 * Initializes the theme's input example by registering the Sections,
	 * Fields, and Settings. This particular group of options is used to
	 * validation and sanitization.
	 *
	 * This function is registered with the 'admin_init' hook.
	 */
	public function initialize_leaderboard_options() {

		$option_name = 'intermedia_google_ad_manager_leaderboard_options';
		$section_name = 'input_leaderboard_section';

		//delete_option('intermedia_google_ad_manager_leaderboard_options');
		$values = get_option( $option_name );
		$amount_leaderboard = (int) $values[ 'amount_slots' ];

		if( 'default' === $values[ 'amount_slots' ] ) {
			$default_array = $this->default_dfp_tags_options();
			update_option( $option_name, $default_array );
		} // end if

		add_settings_section(
			$section_name,
			__( 'Leaderboard Options', 'intermedia-google-ad-manager' ),
			array( $this, 'leaderboard_options_callback'),
			$option_name
		);

		add_settings_field(
			'Select the amount of slots',
			__( 'Select the amount of slots.', $this->plugin_name ),
			array( $this, 'select_render_callback'),
			$option_name,  // menu slug, see t5_sae_add_options_page()
			$section_name,
			array (
				'label_for'   => 'label22', // makes the field name clickable,
				'name'        => 'amount_slots', // value for 'name' attribute
				'value'       => esc_attr( $values['amount_slots'] ),
				'options'     => array (
					'default' => 'Select a slot amount...',
					1 => 1,
					2 => 2,
					3 => 3,
					4 => 4,
					6 => 6,
					7 => 7,
					8 => 8,
					9 => 9,
					10 => 10
				),
				'option_name' => $option_name
			)
		);

		for ($i=0; $i < $amount_leaderboard; $i++) {

			add_settings_field(
				'Leaderboard Slot '.$i,
				__( 'Leaderboard Slot '.$i, $this->plugin_name ),
				array( $this, 'input_render_callback'),
				$option_name,  // menu slug, see t5_sae_add_options_page()
				$section_name,
				array (
					'label_for'   => 'label_slot_'.$i, // makes the field name clickable,
					'name'        => 'define_slot_'.$i, // value for 'name' attribute
					'value'       => esc_attr( isset($values['define_slot_'.$i])? $values['define_slot_'.$i]: ''),
					'option_name' => $option_name,
					'type' 		  => 'text',
				)
			);
			add_settings_field(
				'Leaderboard Sizes '.$i,
				__( 'Leaderboard Sizes '.$i, $this->plugin_name ),
				array( $this, 'input_render_callback'),
				$option_name,  // menu slug, see t5_sae_add_options_page()
				$section_name,
				array (
					'label_for'   => 'label_size_'.$i, // makes the field name clickable,
					'name'        => 'define_sizes_'.$i, // value for 'name' attribute
					'value'       => esc_attr( isset($values['define_sizes_'.$i])? $values['define_sizes_'.$i]: ''),
					'option_name' => $option_name,
					'type' 		  => 'text',
				)
			);
			add_settings_field(
				'Leaderboard Size Mapping '.$i,
				__( 'Leaderboard Size Mapping '.$i, $this->plugin_name ),
				array( $this, 'input_render_callback'),
				$option_name,  // menu slug, see t5_sae_add_options_page()
				$section_name,
				array (
					'label_for'   => 'label_size_mapping_'.$i, // makes the field name clickable,
					'name'        => 'define_size_mapping_'.$i, // value for 'name' attribute
					'value'       => esc_attr( isset($values['define_size_mapping_'.$i])? $values['define_size_mapping_'.$i]: ''),
					'option_name' => $option_name,
					'type' 		  => 'text',
				)
			);

		}

		register_setting(
			'intermedia_google_ad_manager_leaderboard_options',
			'intermedia_google_ad_manager_leaderboard_options',
			array( $this, 'validate_input_data')
		);

	}


	/**
	 * Initializes the theme's input example by registering the Sections,
	 * Fields, and Settings. This particular group of options is used to
	 * validation and sanitization.
	 *
	 * This function is registered with the 'admin_init' hook.
	 */
	public function initialize_dfp_tags_options() {

		$option_name = 'intermedia_google_ad_manager_dfp_tags_options';
		$section_name = 'input_dfp_tags_section';

		//delete_option('intermedia_google_ad_manager_dfp_tags_options');
		$values = get_option( $option_name );
		$amount_dfp_tags = (int) $values[ 'amount_dfp_tags' ];

		if( 'default' === $values[ 'amount_dfp_tags' ] ) {
			$default_array = $this->default_dfp_tags_options();
			update_option( $option_name, $default_array );
		} // end if

		add_settings_section(
			$section_name,
			__( 'DFP Tags Options', 'intermedia-google-ad-manager' ),
			array( $this, 'dfp_tags_options_callback'),
			$option_name
		);

		add_settings_field(
			'Select the amount of DFP Tags',
			__( 'Select the amount of DFP Tags.', $this->plugin_name ),
			array( $this, 'select_render_callback'),
			$option_name,  // menu slug
			$section_name,
			array (
				'label_for'   => 'label24', // makes the field name clickable,
				'name'        => 'amount_dfp_tags', // value for 'name' attribute
				'value'       => esc_attr( $values['amount_dfp_tags'] ),
				'options'     => array (
					'default' => 'Select a DFP Tag amount...',
					1 => 1,
					2 => 2,
					3 => 3,
					4 => 4,
					5 => 5,
					6 => 6,
					7 => 7,
					8 => 8,
					9 => 9,
					10 => 10,
					11 => 11,
					12 => 12,
				),
				'option_name' => $option_name
			)
		);

		for ($i=0; $i < $amount_dfp_tags; $i++) {
			if ( $i % 2 == 0 ) {
				$class = 'stripe-one';
			} else {
				$class = 'stripe-two';
			}
			add_settings_field(
				'DFP Tag Name'.$i,
				__( 'DFP Tag Name'.$i, $this->plugin_name ),
				array( $this, 'input_render_callback'),
				$option_name,  // menu slug
				$section_name,
				array (
					'label_for'   => 'label_dfp_tag_'.$i, // makes the field name clickable,
					'name'        => 'define_dfp_tag_name_'.$i, // value for 'name' attribute
					'value'       => esc_attr( isset($values['define_dfp_tag_name_'.$i])? $values['define_dfp_tag_name_'.$i]: ''),
					'option_name' => $option_name,
					'type' 		  => 'text',
					'class' 	  => $class,
				)
			);
			add_settings_field(
				'DFP Description '.$i,
				__( 'DFP Description '.$i, $this->plugin_name ),
				array( $this, 'textarea_render_callback'),
				$option_name,  // menu slug
				$section_name,
				array (
					'label_for'   => 'label_dfp_tag_description_'.$i, // makes the field name clickable,
					'name'        => 'define_dfp_tag_description_'.$i, // value for 'name' attribute
					'value'       => esc_attr( isset($values['define_dfp_tag_description_'.$i])? $values['define_dfp_tag_description_'.$i]: ''),
					'option_name' => $option_name,
					'type' 		  => 'text',
					'class' 	  => $class,
					'maxlength'   => 150,
				)
			);
			if ( isset($values['define_dfp_tag_name_'.$i]) && $values['define_dfp_tag_name_'.$i] !== '' ) {
				//$url_value = site_url().'/section/'.strtolower(str_replace(' ', '-', str_replace('&', '-', $values['define_dfp_tag_name_'.$i])));
				$url_value = site_url().'/section/'.sanitize_title( $values['define_dfp_tag_name_'.$i] );
				$page_id = $this->dfp_section_page_id( $values['define_dfp_tag_name_'.$i] );
				add_settings_field(
					'DFP Tag URL '.$i,
					__( 'DFP URL '.$i, $this->plugin_name ),
					array( $this, 'input_render_callback_extended'),
					$option_name,  // menu slug
					$section_name,
					array (
						'label_for'   => 'label_dfp_tag_url_'.$i, // makes the field name clickable,
						'name'        => 'define_dfp_tag_url_'.$i, // value for 'name' attribute
						'value'       => esc_attr( $url_value ),
						'option_name' => $option_name,
						'type' 		  => 'hidden',
						'class' 	  => $class,
						'url'  => '<a href="'.$url_value.'" target="_blank">'.$url_value.'</a>'
					)
				);
				update_option( 'define_dfp_tag_url_'.$i, $url_value );
				add_settings_field(
					'DFP Tag Page ID '.$i,
					__( 'DFP Tag Page ID  '.$i, $this->plugin_name ),
					array( $this, 'input_render_callback_extended'),
					$option_name,  // menu slug
					$section_name,
					array (
						'label_for'   => 'label_dfp_tag_page_id_'.$i, // makes the field name clickable,
						'name'        => 'define_dfp_tag_page_id_'.$i, // value for 'name' attribute
						'value'       => esc_attr( $page_id ),
						'option_name' => $option_name,
						'type' 		  => 'hidden',
						'class' 	  => $class,
						'url'  		  => $page_id
					)
				);
				update_option( 'define_dfp_tag_page_id_'.$i, $page_id );
			}

		}

		register_setting(
			'intermedia_google_ad_manager_dfp_tags_options',
			'intermedia_google_ad_manager_dfp_tags_options',
			array( $this, 'validate_input_data')
		);

	}	
	/**
	 * This function renders the interface elements for toggling the visibility of the header element.
	 *
	 * It accepts an array or arguments and expects the first element in the array to be the description
	 * to be displayed next to the checkbox.
	 */
	public function input_render_callback ( $args ) {

		printf(
			'<input type="%5$s" name="%1$s[%2$s]" id="%3$s" value="%4$s" class="regular-text">',
			$args['option_name'],
			$args['name'],
			$args['label_for'],
			$args['value'],
			$args['type'],
		);

	}// end input_element_callback
	public function input_render_callback_extended ( $args ) {

		printf(
			'<input type="%5$s" name="%1$s[%2$s]" id="%3$s" value="%4$s" class="regular-text">%6$s',
			$args['option_name'],
			$args['name'],
			$args['label_for'],
			$args['value'],
			$args['type'],
			$args['url'],
		);

	}// end input_element_callback
	public function textarea_render_callback( $args ) {

		printf(
			'<textarea maxlength="%6$s" type="%5$s" id="%3$s" name="%1$s[%2$s]" class="regular-text" rows="3" cols="50">%4$s</textarea>',
			$args['option_name'],
			$args['name'],
			$args['label_for'],
			$args['value'],
			$args['type'],
			$args['maxlength']
		);

	} // end textarea_element_callback
	public function checkbox_render_callback ( $args ) {

		printf(
			'<input type="checkbox" name="%1$s[%2$s]" id="%2$s" value="1" %5$s  class="regular-text"><label for="%2$s">&nbsp; %3$s</label>',
			$args['option_name'],
			$args['name'],
			$args['label_for'],
			$args['value'],
			$args['checked'],
		);

	}// end checkbox_render_callback
	public function select_render_callback( $args ) {

		printf(
			'<select name="%1$s[%2$s]" id="%3$s">',
			$args['option_name'],
			$args['name'],
			$args['label_for']
		);

		foreach ( $args['options'] as $val => $title ) {
			printf(
				'<option value="%1$s" %2$s>%3$s</option>',
				$val,
				selected( $val, $args['value'], FALSE ),
				$title
			);
		}

		print '</select>';

	}// end select_render_callback
	/* 	OPTIONS TAB */
	public function toggle_skins_callback($args) {

		// First, we read the options collection
		$options = get_option('intermedia_google_ad_manager_general_settings');

		// Next, we update the name attribute to access this element's ID in the context of the display options array
		// We also access the show_skins element of the options collection in the call to the checked() helper function
		$html = '<input type="checkbox" id="show_skins" name="intermedia_google_ad_manager_general_settings[show_skins]" value="1" ' . checked( 1, isset( $options['show_skins'] ) ? $options['show_skins'] : 0, false ) . '/>';

		// Here, we'll take the first argument of the array and add it to a label next to the checkbox
		$html .= '<label for="show_skins">&nbsp;'  . $args[0] . '</label>';

		echo $html;

	} // end toggle_skins_callback

	public function toggle_mrec_callback($args) {

		$options = get_option('intermedia_google_ad_manager_general_settings');

		$html = '<input type="checkbox" id="show_mrec" name="intermedia_google_ad_manager_general_settings[show_mrec]" value="1" ' . checked( 1, isset( $options['show_mrec'] ) ? $options['show_mrec'] : 0, false ) . '/>';
		$html .= '<label for="show_mrec">&nbsp;'  . $args[0] . '</label>';

		echo $html;

	} // end toggle_mrec_callback

	public function toggle_half_page_callback($args) {

		$options = get_option('intermedia_google_ad_manager_general_settings');

		$html = '<input type="checkbox" id="show_half_page" name="intermedia_google_ad_manager_general_settings[show_half_page]" value="1" ' . checked( 1, isset( $options['show_half_page'] ) ? $options['show_half_page'] : 0, false ) . '/>';
		$html .= '<label for="show_half_page">&nbsp;'  . $args[0] . '</label>';

		echo $html;

    } // end toggle_half_page_callback
    
    public function toggle_leaderboard_callback($args) {

		$options = get_option('intermedia_google_ad_manager_general_settings');

		$html = '<input type="checkbox" id="show_leaderboard" name="intermedia_google_ad_manager_general_settings[show_leaderboard]" value="1" ' . checked( 1, isset( $options['show_leaderboard'] ) ? $options['show_leaderboard'] : 0, false ) . '/>';
		$html .= '<label for="show_leaderboard">&nbsp;'  . $args[0] . '</label>';

		echo $html;

	} // end toggle_leaderboard_callback
	public function radio_element_callback() {

		$options = get_option( 'intermedia_google_ad_manager_skin_options' );
		if( !isset($options['activate_skin'] ) ) {
			$options['activate_skin'] = 'no-skin';
		}

		$html = '<input checked type="radio" id="radio_example_one" name="intermedia_google_ad_manager_skin_options[activate_skin]" value="no-skin"' . checked( 'no-skin', $options['activate_skin'], false ) . '/>';
		$html .= '&nbsp;';
		$html .= '<label for="radio_example_one">Deactivated Skin</label>';
		$html .= '&nbsp;';
		$html .= '<input type="radio" id="radio_example_two" name="intermedia_google_ad_manager_skin_options[activate_skin]" value="is-skin"' . checked( 'is-skin', $options['activate_skin'], false ) . '/>';
		$html .= '&nbsp;';
		$html .= '<label for="radio_example_two">Activated Skin</label>';

		echo $html;

	} // end radio_element_callback

	public function validate_input_data( $input ) {

		// Create our array for storing the validated options
		$output = array();

		// Loop through each of the incoming options
		foreach( $input as $key => $value ) {

			// Check to see if the current option has a value. If so, process it.
			if( isset( $input[$key] ) ) {

				// Strip all HTML and PHP tags and properly handle quoted strings
				$output[$key] = strip_tags( stripslashes( $input[ $key ] ) );

			} // end if

		} // end foreach

		// Return the array processing any additional functions filtered by this action
		return apply_filters( 'validate_input_data', $output, $input );

	} // end validate_input_data
	
	/**
	 * Metaboxes
	 * 
	 *
	 * @params	
	 *
	 * @returnsThe collection of Metaboxes
	 */
	public function register_meta_dfp_tag() {

		register_meta( 'post', 'post_dfp_tag', [
			'show_in_rest' => true,
			'single' => true,
		]);
	
	}
	  
	public function define_dfp_metabox(){
	
		add_meta_box( 
			'dfp-tags-metabox',
			'DFP Tags',
			array( $this, 'dfp_metabox_callback' ),
			'post',
			'normal'
		);

	}

	public function dfp_metabox_callback(){
	
		global $post;
        $options = get_option('intermedia_google_ad_manager_dfp_tags_options');
        //var_dump($options);
        $output[] = array(
            'value' => '',
            'label' => 'Select the DFP tag...',
        );
        foreach ($options as $key => $value) {

            if( $value !== '' && strpos( $key, 'tag_name_' ) ) {

                $output[] = array(
                    'value' => $value,
                    'label' => $value,
				);
				
            } 

        }
	    /* BEGIN HTML OUTPUT */
		ob_start(); // Turn on output buffering

		?>

		<div class="row">
			<div class="label">Post DFP Tag</div>
			<div class="fields">
				<select name="_post_dfp_tag" > 
				<?php foreach($output as $key => $value){ ?>
					<option value="<?php echo $value['value'];?>" <?php selected( get_post_meta( $post->ID, 'post_dfp_tag', true ), $value['value'] ); ?>><?php echo $value['label'];?></option> 
				<?php } ?>
    			</select>
			</div>
		</div>

		<?php

		/* END HTML OUTPUT */
		$output = ob_get_contents(); // collect output

		ob_end_clean(); // Turn off ouput buffer
			
		echo $output; // Print output

	}

	public function save_dfp_metabox(){

		global $post;

		if( isset($_POST['_post_dfp_tag'])):
			
			update_post_meta( $post->ID, 'post_dfp_tag', $_POST['_post_dfp_tag']);
		
		endif;

	}

	public function dfp_section_page_id($dfp_tag) {
		$check_page_exist = get_page_by_title($dfp_tag, 'OBJECT', 'page');
		//var_dump($check_page_exist);
		// Check if the page already exists
		if(empty($check_page_exist)) {
			$page = wp_insert_post(
				array(
				'comment_status' => 'close',
				'ping_status'    => 'close',
				'post_author'    => 1,
				'post_title'     => ucwords($dfp_tag),
				'post_name'      => sanitize_title($dfp_tag),
				'post_status'    => 'publish',
				'post_type'      => 'page',
				)
			);
			return $page->ID;
		}
		return $check_page_exist->ID;
	}

}