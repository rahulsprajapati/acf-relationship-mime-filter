<?php
/**
 * @link              http://rahulprajapati.me
 * @since             1.0.0
 * @package           acf_rmf
 *
 * @wordpress-plugin
 * Plugin Name:       Advanced Custom Fields - Relationship MIME type filter
 * Plugin URI:        http://rahulprajapati.me
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
 * This action is documented in includes/class-plugin-name-activator.php
 */
function activate_acf_rmf() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-acf-rmf-activator.php';
	Acf_Rmf_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-plugin-name-deactivator.php
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

add_action( 'admin_init', 'acf_rmf_plugin_has_parent_plugin' );
function acf_rmf_plugin_has_parent_plugin() {
	if ( is_admin() && current_user_can( 'activate_plugins' ) &&  !is_plugin_active( 'advanced-custom-fields/acf.php' ) ) {
		add_action( 'admin_notices', 'acf_rmf_plugin_notice' );

		deactivate_plugins( plugin_basename( __FILE__ ) );

		if ( isset( $_GET['activate'] ) ) {
			unset( $_GET['activate'] );
		}
	}
}

function acf_rmf_plugin_notice(){
	echo '<div class="error"><p>Sorry, but this plugin requires the <a href="https://wordpress.org/plugins/advanced-custom-fields/" target="_blank" title="Advance Custom Field">ACF Plugin</a> to be installed and active. <br><a href="' . admin_url( 'plugin-install.php?tab=search&s=Advanced+Custom+Fields' ) . '">Install ACF Plugin</a></p></div>';
}

//add_filter( 'plugin_action_links', 'disable_acf_rmf_link', 10, 2 );
//function disable_acf_rmf_link( $links, $file ) {
//
//	if ( 'advanced-custom-fields-relationship-attachment-mime-type/acf-relationship-mime-filter.php' == $file and isset($links['activate']) )
//		$links['activate'] = '<span>Activate</span>';
//
//	return $links;
//}
//
