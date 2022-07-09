<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://www.intermedia.com.au/
 * @since             1.0.0
 * @package           Intermedia_Google_Ad_Manager
 *
 * @wordpress-plugin
 * Plugin Name:       Intermedia Google Ad Manager
 * Plugin URI:        https://www.intermedia.com.au/
 * Description:       An advanced open-source publishing and revenue-generating platform for The Google Publisher Tag (GPT), an ad tagging library for Google Ad Manager.
 * Version:           1.0.0
 * Author:            Jose Anton
 * Author URI:        https://www.intermedia.com.au/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       intermedia-google-ad-manager
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'INTERMEDIA_GOOGLE_AD_MANAGER_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-intermedia-google-ad-manager-activator.php
 */
function activate_intermedia_google_ad_manager() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-intermedia-google-ad-manager-activator.php';
	Intermedia_Google_Ad_Manager_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-intermedia-google-ad-manager-deactivator.php
 */
function deactivate_intermedia_google_ad_manager() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-intermedia-google-ad-manager-deactivator.php';
	Intermedia_Google_Ad_Manager_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_intermedia_google_ad_manager' );
register_deactivation_hook( __FILE__, 'deactivate_intermedia_google_ad_manager' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-intermedia-google-ad-manager.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_intermedia_google_ad_manager() {

	$plugin = new Intermedia_Google_Ad_Manager();
	$plugin->run();

}
run_intermedia_google_ad_manager();