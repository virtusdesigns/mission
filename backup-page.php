<?php get_header(); global $template_dir, $no_slider;

$no_slider = false;	
	
if (have_posts()) : while(have_posts()) : the_post();

	get_template_part('includes/pageparts/pagepart','slider');
	
	
	// Get Page Variables
	$show_posts = get_post_meta($post->ID,'_display_recent_posts',true); $show_posts = ($show_posts ? $show_posts[0] : '');
	$show_sermon = get_post_meta($post->ID,'_display_sermon_bar',true); $show_sermon = ($show_sermon ? $show_sermon[0] : '');
	$show_parallax = get_post_meta($post->ID,'_display_parallax',true); $show_parallax = ($show_parallax ? $show_parallax[0] : '');
	$show_events = get_post_meta($post->ID,'_display_upcoming_events',true); $show_events = ($show_events ? $show_events[0] : '');
	$show_single_event = get_post_meta($post->ID,'_display_single_event',true); $show_single_event = ($show_single_event ? $show_single_event[0] : '');
	$show_twitter = get_post_meta($post->ID,'_display_recent_tweets',true); $show_twitter = ($show_twitter ? $show_twitter[0] : '');
	$show_widgets = get_post_meta($post->ID,'_widget_layout',true); $show_widgets = ($show_widgets ? $show_widgets[0] : '');
	$show_feature_blocks = get_post_meta($post->ID,'_feature_block_layout',true); $show_feature_blocks = ($show_feature_blocks ? $show_feature_blocks[0] : '');
	$section_array = array();
	
	$page_content_location = get_post_meta($post->ID,'_page_content_order',true);
	
	if (get_the_content() || isset($_GET['dslc']) || get_post_meta(get_the_ID(), 'dslc_code', true)): $section_array[$page_content_location.'-content'] = 'content'; endif;
	
	if ($show_posts):
		global $section_title;
		$posts_location = get_post_meta($post->ID,'_recent_posts_order',true);
		$section_title = get_post_meta($post->ID,'_recent_posts_title',true);
		$section_array[$posts_location.'-posts'] = 'posts';
	endif;
	
	if ($show_sermon):
		global $sermon_title,$sermon_choice;
		$sermon_location = get_post_meta($post->ID,'_sermon_order',true);
		$sermon_title = get_post_meta($post->ID,'_sermon_bar_title',true);
		$sermon_choice = get_post_meta($post->ID,'_sermon_choice',true);
		$section_array[$sermon_location.'-sermon'] = 'sermon';
	endif;
	
	if ($show_parallax):
		$parallax_location = get_post_meta($post->ID,'_parallax_order',true);
		$section_array[$parallax_location.'-parallax'] = 'parallax';
	endif;
	
	if ($show_twitter):
		global $section_title_tweets;
		$posts_location = get_post_meta($post->ID,'_recent_tweets_order',true);
		$section_array[$posts_location.'-tweets'] = 'tweets';
	endif;
	
	if (class_exists('TribeEvents')) {
		if ($show_events):
			global $event_items_title;
			$event_items_title = get_post_meta($post->ID,'_event_items_title',true);
			$events_location = get_post_meta($post->ID,'_event_items_order',true);
			$section_array[$events_location.'-events'] = 'events';
		endif;
		if ($show_single_event):
			global $single_event_items_title;
			$single_event_items_title = get_post_meta($post->ID,'_single_event_items_title',true);
			$single_event_items_order = get_post_meta($post->ID,'_single_event_items_order',true);
			$single_event_id = get_post_meta($post->ID,'_single_event_id',true);
			$section_array[$single_event_items_order.'-single_event'] = 'single_event';
		endif;
	} else {
		$show_events = false;
		$show_single_event = false;
	}
	
	if ($show_widgets && $show_widgets != 'no-widgets'):
		$widget_location = get_post_meta($post->ID,'_widget_items_order',true);
		$section_array[$widget_location.'-widgets'] = 'widgets';
	endif;
	
	if ($show_feature_blocks && $show_feature_blocks != 'no-blocks'):
		$feature_block_location = get_post_meta($post->ID,'_feature_blocks_order',true);
		$section_array[$feature_block_location.'-featureblocks'] = 'featureblocks';
	endif;
	
	ksort($section_array);
	
	global $show_events, $show_posts;
	
	$last_item = end($section_array);
	$first_item = reset($section_array);
	
	$previous_section = false;
	
	foreach($section_array as $section):
	
		if ($section == $first_item && $section == 'single_event' ||
			$section == $first_item && $section == 'posts' ||
			$section == $first_item && $section == 'widgets' ||
			$section == $first_item && $section == 'content' ||
			$section == $first_item && $section == 'events'): ?><div class="bottom-spacer"></div><?php			
		elseif ($previous_section == 'posts' && $section == 'widgets' ||
			$previous_section == 'posts' && $section == 'single_event' ||
			$previous_section == 'posts' && $section == 'events' ||
			$previous_section == 'posts' && $section == 'content' ||
			$previous_section == 'posts' && $section == 'parallax' ||
			$previous_section == 'posts' && $section == 'sermon' ||
			$previous_section == 'widgets' && $section == 'posts' ||
			$previous_section == 'widgets' && $section == 'single_event' ||
			$previous_section == 'widgets' && $section == 'events' ||
			$previous_section == 'widgets' && $section == 'content' ||
			$previous_section == 'widgets' && $section == 'parallax' ||
			$previous_section == 'widgets' && $section == 'sermon' ||
			$previous_section == 'events' && $section == 'widgets' ||
			$previous_section == 'events' && $section == 'single_event' ||
			$previous_section == 'events' && $section == 'posts' ||
			$previous_section == 'events' && $section == 'content' ||
			$previous_section == 'events' && $section == 'parallax' ||
			$previous_section == 'events' && $section == 'sermon' ||
			$previous_section == 'content' && $section == 'widgets' ||
			$previous_section == 'content' && $section == 'single_event' ||
			$previous_section == 'content' && $section == 'posts' ||
			$previous_section == 'content' && $section == 'events' ||
			$previous_section == 'content' && $section == 'parallax' ||
			$previous_section == 'content' && $section == 'sermon' ||
			$previous_section == 'tweets' && $section == 'widgets' ||
			$previous_section == 'tweets' && $section == 'single_event' ||
			$previous_section == 'tweets' && $section == 'posts' ||
			$previous_section == 'tweets' && $section == 'events' ||
			$previous_section == 'tweets' && $section == 'content' ||
			$previous_section == 'parallax' && $section == 'widgets' ||
			$previous_section == 'parallax' && $section == 'single_event' ||
			$previous_section == 'parallax' && $section == 'posts' ||
			$previous_section == 'parallax' && $section == 'events' ||
			$previous_section == 'parallax' && $section == 'content' ||
			$previous_section == 'sermon' && $section == 'widgets' ||
			$previous_section == 'sermon' && $section == 'single_event' ||
			$previous_section == 'sermon' && $section == 'posts' ||
			$previous_section == 'sermon' && $section == 'events' ||
			$previous_section == 'sermon' && $section == 'content' ||
			$previous_section == 'featureblocks' && $section == 'content' ||
			$previous_section == 'featureblocks' && $section == 'widgets' ||
			$previous_section == 'featureblocks' && $section == 'single_event' ||
			$previous_section == 'featureblocks' && $section == 'events' ||
			$previous_section == 'featureblocks' && $section == 'posts'): ?><div class="bottom-spacer"></div><?php
		elseif ($previous_section == 'posts' && $section == 'tweets' ||
			$previous_section == 'widgets' && $section == 'tweets' ||
			$previous_section == 'single_event' && $section == 'tweets' ||
			$previous_section == 'events' && $section == 'tweets' ||
			$previous_section == 'content' && $section == 'tweets' ||
			$previous_section == 'posts' && $section == 'parallax' ||
			$previous_section == 'widgets' && $section == 'parallax' ||
			$previous_section == 'single_event' && $section == 'parallax' ||
			$previous_section == 'events' && $section == 'parallax' ||
			$previous_section == 'content' && $section == 'parallax' ||
			$previous_section == 'posts' && $section == 'sermon' ||
			$previous_section == 'widgets' && $section == 'sermon' ||
			$previous_section == 'single_event' && $section == 'sermon' ||
			$previous_section == 'events' && $section == 'sermon' ||
			$previous_section == 'content' && $section == 'sermon' ||
			$previous_section == 'posts' && $section == 'featureblocks' ||
			$previous_section == 'content' && $section == 'featureblocks' ||
			$previous_section == 'widgets' && $section == 'featureblocks' ||
			$previous_section == 'single_event' && $section == 'featureblocks' ||
			$previous_section == 'events' && $section == 'featureblocks'): ?><div class="bottom-spacer"></div><?php
		endif;
	
		wp_reset_query();
		get_template_part('includes/pageparts/pagepart',$section);
		$previous_section = $section;
		
		if ($section == $last_item && $section == 'posts' ||
			$section == $last_item && $section == 'widgets' ||
			$section == $last_item && $section == 'single_event' ||
			$section == $last_item && $section == 'content' ||
			$section == $last_item && $section == 'events'): ?><div class="bottom-spacer"></div><?php endif;
		
	endforeach;

endwhile; endif;
get_footer();