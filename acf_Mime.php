<?php

/**
 * Created by PhpStorm.
 * User: rahul
 * Date: 14/6/16
 * Time: 12:56 AM
 */

if ( ! class_exists( 'acf_Mime' ) && class_exists( 'acf_field_relationships' ) ) {
	class acf_Mime extends acf_field_relationship {

		function __construct() {

			parent::__construct();

			$this->name = 'relationship-mime';
			$this->label = __("Relationship With Mime",'acf');
			$this->category = __("Relational",'acf');
			$this->defaults = array(
				'post_type'			=>	array('all'),
				'max' 				=>	'',
				'taxonomy' 			=>	array('all'),
				'filters'			=>	array('search'),
				'result_elements' 	=>	array('post_title', 'post_type'),
				'return_format'		=>	'object'
			);
			$this->l10n = array(
				'max'		=> __("Maximum values reached ( {max} values )",'acf')
			);


		}

		function create_options( $field )
		{
			parent::create_options( $field );
			$key = $field['name'];
			?>
			<tr class="field_option field_option_<?php echo $this->name; ?>">
				<td class="label">
					<label><?php _e("Filter from mime",'acf'); ?></label>
				</td>
				<td>
					<?php
					$choices = array(
						'' => array(
							'all' => __("All",'acf')
						)
					);
					$simple_value = false;
					$choices = apply_filters('acf/get_taxonomies_for_select', $choices, $simple_value);


					do_action('acf/create_field', array(
						'type'	=>	'select',
						'name'	=>	'fields['.$key.'][taxonomy]',
						'value'	=>	$field['taxonomy'],
						'choices' => $choices,
						'multiple'	=>	1,
					));
					?>
				</td>
			</tr>
			<?php
		}

	}
}