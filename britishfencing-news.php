<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://dankew.me
 * @since             1.0.0
 * @package           Britishfencing_News
 *
 * @wordpress-plugin
 * Plugin Name:       British Fencing News
 * Plugin URI:        http://example.com/plugin-name-uri/
 * Description:       Using WP JSON this plugin allows the latest news from British Fencing to be displayed on any web site
 * Version:           1.0.0
 * Author:            Dan kew
 * Author URI:        http://dankew.me
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       britishfencing-news
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
define( 'BRITISHFENCING_NEWS_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-plugin-name-activator.php
 */
function activate_britishfencing_news() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-britishfencing-news-activator.php';
	Britishfencing_News_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-plugin-name-deactivator.php
 */
function deactivate_britishfencing_news() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-britishfencing-news-deactivator.php';
	Britishfencing_News_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_britishfencing_news' );
register_deactivation_hook( __FILE__, 'deactivate_britishfencing_news' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-britishfencing-news.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_britishfencing_news() {

	$plugin = new Britishfencing_News();
	$plugin->run();

}
run_britishfencing_news();
