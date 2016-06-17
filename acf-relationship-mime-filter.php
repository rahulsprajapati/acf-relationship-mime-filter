<?php
/**
 * @link              https://profiles.wordpress.org/rahulsprajapati/profile/
 * @since             1.0.0
 * @package           acf_rmf
 *
 * @wordpress-plugin
 * Plugin Name:       Advanced Custom Fields - Relationship MIME type filter
 * Plugin URI:        https://profiles.wordpress.org/rahulsprajapati/profile/
 * Description:       This plugin is an add-on for Advanced Custom Fields. It allows you to use "post_mime_type" filter in "relationship" field.
 * Version:           1.0.0
 * Author:            Rahul Prajapati
 * Author URI:        https://profiles.wordpress.org/rahulsprajapati/profile/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       acf
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}


/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-acf-rmf-activator.php
 */
function activate_acf_rmf() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-acf-rmf-activator.php';
	Acf_Rmf_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-acf-rmf-deactivator.php
 */
function deactivate_acf_rmf() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-acf-rmf-deactivator.php';
	Acf_Rmf_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_acf_rmf' );
register_deactivation_hook( __FILE__, 'deactivate_acf_rmf' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-acf-rmf.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_acf_rmf() {

	$plugin = new Acf_Rmf();
	$plugin->run();

}
run_acf_rmf();
