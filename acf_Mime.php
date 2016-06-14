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

function rmf_get_all_mime_types() {
	return array(
		'Image'            => array(
			'jpg|jpeg|jpe' => 'image/jpeg',
			'gif'          => 'image/gif',
			'png'          => 'image/png',
			'bmp'          => 'image/bmp',
			'tif|tiff'     => 'image/tiff',
			'ico'          => 'image/x-icon',
		),
		'Video'            => array(
			'asf|asx'      => 'video/x-ms-asf',
			'wmv'          => 'video/x-ms-wmv',
			'wmx'          => 'video/x-ms-wmx',
			'wm'           => 'video/x-ms-wm',
			'avi'          => 'video/avi',
			'divx'         => 'video/divx',
			'flv'          => 'video/x-flv',
			'mov|qt'       => 'video/quicktime',
			'mpeg|mpg|mpe' => 'video/mpeg',
			'mp4|m4v'      => 'video/mp4',
			'ogv'          => 'video/ogg',
			'webm'         => 'video/webm',
			'mkv'          => 'video/x-matroska',
		),
		'Text'             => array(
			'txt|asc|c|cc|h' => 'text/plain',
			'csv'            => 'text/csv',
			'tsv'            => 'text/tab-separated-values',
			'ics'            => 'text/calendar',
			'rtx'            => 'text/richtext',
			'css'            => 'text/css',
			'htm|html'       => 'text/html',
		),
		'Audio'            => array(
			'mp3|m4a|m4b' => 'audio/mpeg',
			'ra|ram'      => 'audio/x-realaudio',
			'wav'         => 'audio/wav',
			'ogg|oga'     => 'audio/ogg',
			'mid|midi'    => 'audio/midi',
			'wma'         => 'audio/x-ms-wma',
			'wax'         => 'audio/x-ms-wax',
			'mka'         => 'audio/x-matroska',
		),
		'Misc application' => array(
			'rtf'     => 'application/rtf',
			'js'      => 'application/javascript',
			'pdf'     => 'application/pdf',
			'swf'     => 'application/x-shockwave-flash',
			'class'   => 'application/java',
			'tar'     => 'application/x-tar',
			'zip'     => 'application/zip',
			'gz|gzip' => 'application/x-gzip',
			'rar'     => 'application/rar',
			'7z'      => 'application/x-7z-compressed',
			'exe'     => 'application/x-msdownload',
		),
		'MS Office'        => array(
			'doc'                          => 'application/msword',
			'pot|pps|ppt'                  => 'application/vnd.ms-powerpoint',
			'wri'                          => 'application/vnd.ms-write',
			'xla|xls|xlt|xlw'              => 'application/vnd.ms-excel',
			'mdb'                          => 'application/vnd.ms-access',
			'mpp'                          => 'application/vnd.ms-project',
			'docx'                         => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
			'docm'                         => 'application/vnd.ms-word.document.macroEnabled.12',
			'dotx'                         => 'application/vnd.openxmlformats-officedocument.wordprocessingml.template',
			'dotm'                         => 'application/vnd.ms-word.template.macroEnabled.12',
			'xlsx'                         => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
			'xlsm'                         => 'application/vnd.ms-excel.sheet.macroEnabled.12',
			'xlsb'                         => 'application/vnd.ms-excel.sheet.binary.macroEnabled.12',
			'xltx'                         => 'application/vnd.openxmlformats-officedocument.spreadsheetml.template',
			'xltm'                         => 'application/vnd.ms-excel.template.macroEnabled.12',
			'xlam'                         => 'application/vnd.ms-excel.addin.macroEnabled.12',
			'pptx'                         => 'application/vnd.openxmlformats-officedocument.presentationml.presentation',
			'pptm'                         => 'application/vnd.ms-powerpoint.presentation.macroEnabled.12',
			'ppsx'                         => 'application/vnd.openxmlformats-officedocument.presentationml.slideshow',
			'ppsm'                         => 'application/vnd.ms-powerpoint.slideshow.macroEnabled.12',
			'potx'                         => 'application/vnd.openxmlformats-officedocument.presentationml.template',
			'potm'                         => 'application/vnd.ms-powerpoint.template.macroEnabled.12',
			'ppam'                         => 'application/vnd.ms-powerpoint.addin.macroEnabled.12',
			'sldx'                         => 'application/vnd.openxmlformats-officedocument.presentationml.slide',
			'sldm'                         => 'application/vnd.ms-powerpoint.slide.macroEnabled.12',
			'onetoc|onetoc2|onetmp|onepkg' => 'application/onenote',
		),
		'OpenOffice'       => array(
			'odt' => 'application/vnd.oasis.opendocument.text',
			'odp' => 'application/vnd.oasis.opendocument.presentation',
			'ods' => 'application/vnd.oasis.opendocument.spreadsheet',
			'odg' => 'application/vnd.oasis.opendocument.graphics',
			'odc' => 'application/vnd.oasis.opendocument.chart',
			'odb' => 'application/vnd.oasis.opendocument.database',
			'odf' => 'application/vnd.oasis.opendocument.formula',
		),
		'WordPerfect'      => array(
			'wp|wpd' => 'application/wordperfect',
		),
		'iWork'            => array(
			'key'     => 'application/vnd.apple.keynote',
			'numbers' => 'application/vnd.apple.numbers',
			'pages'   => 'application/vnd.apple.pages',
		)
	);
}