<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://rahulprajapati.me
 * @since      1.0.0
 *
 * @package    acf_rmf
 * @subpackage acf_rmf/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    acf_rmf
 * @subpackage acf_rmf/admin
 * @author     Rahul Prajapati <rahul.prajapati@live.in>
 */
class Acf_Rmf_Admin {

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

		add_action( 'acf/create_field_options/type=relationship', array( $this, 'acf_rmf_create_options' ), 11, 1 );

		add_filter( 'acf/fields/relationship/query', array( $this, 'acf_rmf_query_post_args' ), 10, 3 );
	}

	/**
	 * Adding mime type filter option in ACF relationship field
	 *
	 * @since    1.0.0
	 */
	public function acf_rmf_create_options( $field ) {
		$all_mimes          = get_allowed_mime_types();
		$key = $field['name'];
		$choices = array(
			'all'	=> __( 'All','acf' ),
		);
		foreach ( $all_mimes as $mime ) {
			$choices[ $mime ] = __( $mime, 'acf' );
		}
		?>
		<tr class="field_option field_option_mime_types">
			<td class="label">
				<label><?php _e( 'MIME types','acf' ); ?></label>
				<p><?php _e( 'Specify mime type.','acf' ) ?></p>
			</td>
			<td>
				<?php
				do_action('acf/create_field', array(
					'type'	=> 'select',
					'name'	=> 'fields[' . $key . '][post_mime_type]',
					'value'	=> $field['post_mime_type'],
					'choices' => $choices,
					'multiple'	=> 1,
				));
				?>
			</td>
		</tr>
		<?php
	}

	/**
	 * Add "post_mime_type" property in WP_Query args if mime types are selected.
	 *
	 * @since    1.0.0
	 */
	public function acf_rmf_query_post_args( $options, $field, $the_post ) {
		if ( $options['post_type'] == 'attachment' ) {
			if ( ! empty( $field['post_mime_type'] ) ) {
				$mime_type = $field['post_mime_type'];
				if ( $mime_type[0] != 'all' ) {
					$options['post_mime_type'] = $mime_type;
				}
			}
		}
		return $options;
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

	}
}
