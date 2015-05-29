<?php





////////////////////////////////////////////////////////////////////////////////
// SIDEBAR SETTINGS //
$sidebar_layout = ECF_Field::factory('imageradio', 'sermon_sidebar_layout', __('Sidebar Layout','forgiven') );
$sidebar_layout->add_options(array(
	'no-sidebar'=>get_template_directory_uri().'/_theme_settings/images/sidebar_none.png',
	'left'=>get_template_directory_uri().'/_theme_settings/images/sidebar_left.png',
	'right'=>get_template_directory_uri().'/_theme_settings/images/sidebar_right.png',		
));

global $wp_registered_sidebars;
$sidebar_dropdown_elements = array();
foreach($wp_registered_sidebars as $sidebar_id => $sidebar){
	$sidebar_dropdown_elements[$sidebar['id']] = $sidebar['name'];	
}

// Sidebar Choice
$sidebar_choice = ECF_Field::factory('select', 'sermon_sidebar_choice', __('Choose a sidebar:','forgiven'));
$sidebar_choice->add_options($sidebar_dropdown_elements);





////////////////////////////////////////////////////////////////////////////////
// sermon CONTENT //

$sermon_options = ECF_Field::factory('set', 'sermon_options', __('Sermon Options','forgiven') );
$sermon_options->add_options(array('hide_featured_image' => __('Hide the featured image.','forgiven')));





$sermon_option_sep_20 = ECF_Field::factory('sep', 'seperator21');





////////////////////////////////////////////////////////////////////////////////
// SET UP THE PANEL //
$sermon_settings_panel = new ECF_Panel('sermon_settings_panel', __('Sermon Settings','forgiven'), 'ctc_sermon', 'normal', 'high');

$sermon_settings_panel->add_fields(
	array(
			
		// sermon Options
		$sermon_options,
		$sermon_option_sep_20,
			
		// Sidebar Layout
		$sidebar_layout,
		$sidebar_choice,
		
	)
);





?>