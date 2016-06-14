<?php
if ( ! function_exists( "acf_rmf_create_options" ) ) {
	add_action( "acf/create_field_options/type=relationship", "acf_rmf_create_options", 11, 1);

	function acf_rmf_create_options( $field ) {
		$all_mimes          = get_allowed_mime_types();
		$key = $field['name'];
		$choices = array(
			'all'	=>	__("All",'acf')
		);
		foreach ( $all_mimes as $mime ) {
			$choices[$mime] = __($mime, 'acf');
		}
		?>
		<tr class="field_option field_option_mime_types">
			<td class="label">
				<label><?php _e("MIME types",'acf'); ?></label>
				<p><?php _e("Specify mime type.",'acf') ?></p>
			</td>
			<td>
				<?php
				do_action('acf/create_field', array(
					'type'	=>	'select',
					'name'	=>	'fields['.$key.'][post_mime_type]',
					'value'	=>	$field['post_mime_type'],
					'choices' => $choices,
					'multiple'	=>	1,
				));
				?>
			</td>
		</tr>
		<?php
	}
}

if ( ! function_exists( "acf_rmf_query_post_args" ) ) {
	add_filter( "acf/fields/relationship/query", "acf_rmf_query_post_args", 10, 3 );

	function acf_rmf_query_post_args( $options, $field, $the_post ) {
		if ( $options['post_type'] == "attachment" ) {
			if( ! empty( $field["post_mime_type"] ) ) {
				$mime_type = $field["post_mime_type"];
				if ( $mime_type[0] != "all" ) {
					$options[ 'post_mime_type' ] = $mime_type;
				}
			}
		}
		return $options;
	}
}