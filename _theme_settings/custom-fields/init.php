<?php

//function add_forgiven_custom_fields(){

	//include('pages.php');
	//include('posts.php');
	//if (class_exists('Church_Theme_Content')):
	//	include('sermons.php');
	//endif;
	
//}

//add_action( 'init', 'add_forgiven_custom_fields' );

function forgiven_save_event_list_for_dropdown(){
	if (class_exists('TribeEvents')){
		$events_for_dropdown = tribe_get_events(array(
			'eventDisplay'=>'list',
			'posts_per_page'=>100
		));
		update_option('forgiven_event_list',$events_for_dropdown);
	} else {
		update_option('forgiven_event_list',false);
	}
}

if (class_exists('TribeEvents')){
	add_action('admin_init', 'forgiven_save_event_list_for_dropdown');
}