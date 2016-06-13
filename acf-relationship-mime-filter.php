<?php
/**
 * Plugin Name: Advanced Custom Fields - Relationship Attachment Post type MIME type filter
 * Plugin URI: http://rahulprajapti.me
 * Description: This plugin is an add-on for Advanced Custom Fields. It allows you to use an ACF "relationship" field to filter attachment mime type filter.
 * Version: 1.0.0
 * Author: Rahul Prajapati
 * Author URI: http://rahulprajapti.me
 * Text Domain: rp-acf
 * License: GPL2
 */
/*
 * Copyright 2016 Rahul Prajapati (email : com.developer.rahul@gmail.com)
 */

defined ( 'ABSPATH' ) or die ( "No script kiddies please!" );

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


add_action('acf/register_fields', 'acf_field_rmf');

function acf_field_rmf(){
	include_once('acf_Mime.php');
}