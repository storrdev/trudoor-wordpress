<?php
return	array(

	array(
		'type'		=> 'module',
		'title'		=> __('Hide contents in this widget?','cloudfw'),
		'data'		=> array(

			array(
				'type'		=>	'onoff',
				'id'		=>	$that->get_field_name('enable'),
				'value'		=>	$that->get_value('enable'),						
			),

		)

	),

	array(
		'type'		=> 'module',
		'title'		=> __('Content','cloudfw'),
		'condition'	=> !$that->is_composer,
		'data'		=> array(

			array(
				'type'		=>	'textarea',
				'id'		=>	'comment_out_content',
				'value'		=>	'',
				'width'		=>	'90%',
			),

		)

	),

);