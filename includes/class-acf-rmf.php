<?php

/**
 * This file defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://profiles.wordpress.org/rahulsprajapati/profile/
 * @since      1.0.0
 *
 * @package    acf_rmf
 * @subpackage acf_rmf/includes
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
 * @package    acf_rmf
 * @subpackage acf_rmf/includes
 * @author     Rahul Prajapati <rahul.prajapati@live.in>
 */
class Acf_Rmf {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Acf_Rmf_Loader    $loader    Maintains and registers all hooks for the plugin.
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

		$this->plugin_name = 'advanced-custom-fields-relationship-mime-filter';
		$this->version = '1.0.0';

		$this->load_dependencies();
		$this->define_admin_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Acf_Rmf_Loader. Orchestrates the hooks of the plugin.
	 * - Acf_Rmf_i18n. Defines internationalization functionality.
	 * - Acf_Rmf_Admin. Defines all hooks for the admin area.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		add_action( 'admin_init', array( $this, 'acf_rmf_plugin_has_parent_plugin' ) );
		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-acf-rmf-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-acf-rmf-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-acf-rmf-admin.php';

		$this->loader = new Acf_Rmf_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Plugin_Name_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Acf_Rmf_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Check If parent ACF plugin is installed or not.
	 * And do not activate our plugin if ACF is not active.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	public function acf_rmf_plugin_has_parent_plugin() {
		if ( is_admin() && current_user_can( 'activate_plugins' ) && ! is_plugin_active( 'advanced-custom-fields/acf.php' ) ) {

			add_action( 'admin_notices', array( $this, 'acf_rmf_plugin_notice' ) );

			deactivate_plugins( plugin_dir_path( dirname( __FILE__ ) ) . 'acf-rmf.php' );

			if ( isset( $_GET['activate'] ) ) {
				unset( $_GET['activate'] );
			}
		}
	}


	/**
	 * admin_notices callback function for parent plugin required notice.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	public function acf_rmf_plugin_notice() {
		echo '<div class="error"><p>' . __( 'Sorry, "Advanced Custom Fields - Relationship MIME type filter" plugin requires the ', 'acf-rmf' ) . '<a href="https://wordpress.org/plugins/advanced-custom-fields/" target="_blank" title="Advance Custom Field">' . __( 'ACF Plugin', 'acf-rmf' ) . '</a>' . __( ' to be installed and active.', 'acf-rmf' ) . '<br><a href="' . admin_url( 'plugin-install.php?tab=search&s=Advanced+Custom+Fields' ) . '">' . __( 'Install ACF Plugin', 'acf-rmf' ) . '</a></p></div>';
	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Acf_Rmf_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

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
	 * @return    Acf_Rmf_Loader    Orchestrates the hooks of the plugin.
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
