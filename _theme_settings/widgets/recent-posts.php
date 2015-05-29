<?php

// Recent Posts
// ----------------------------------------------------
class ThemeWidgetRecentPosts extends ThemeWidgetBase {
	
	/*
	* Register widget function. Must have the same name as the class
	*/
	function ThemeWidgetRecentPosts() {
		$widget_opts = array(
			'classname' => 'theme-widget-recent-posts', // class of the <li> holder
			'description' => __( 'Displays recent posts in a custom style.','forgiven' ) // description shown in the widget list
		);
		// Additional control options. Width specifies to what width should the widget expand when opened
		$control_ops = array(
			//'width' => 350,
		);
		// widget id, widget display title, widget options
		$this->WP_Widget('theme-widget-recent-posts', __('Custom Recent Posts','forgiven'), $widget_opts, $control_ops);
		$this->custom_fields = array(
			array(
				'name'=>'title',
				'type'=>'text',
				'title'=>'Title', 
				'default'=>__('Recent Posts','forgiven')
			),
			array(
				'name'=>'categories',
				'type'=>'multiCategories',
				'title'=>__('Select Categories','forgiven'),
				'default'=>''
			),
			array(
				'name'=>'load',
				'type'=>'integer',
				'title'=>__('How many total items?','forgiven'), 
				'default'=>'10'
			)
		);
	}
	
	/*
	* Called when rendering the widget in the front-end
	*/
	function front_end($args, $instance) {
	
		extract($args);
		
		global $hide_thumbnails;
		$hide_thumbnails = true;
		
		$limit = intval($instance['load']);
		$title = $instance['title'];
		$categories = $instance['categories'];
		if ($categories) { $categories = implode(",",$categories); }
		$current_sidebar = $args['id'];
		if ($current_sidebar == 'homepage-horizontal-blocks') { $is_horizontal = true; } else { $is_horizontal = false; }
		
		query_posts(array('posts_per_page'=>$limit, 'cat'=>$categories));
		if ( have_posts() ) : ?>
				
			<?php echo ($title ? $before_title.$title.$after_title : ''); ?>
			
			<?php $temp_counter = 0;
			while ( have_posts() ) : the_post(); global $post; $temp_counter++;
				
				echo '<div class="sidebar-posts">';
				get_template_part('includes/singlerow','post');
				echo '</div>';
							
			endwhile;
						
		endif; wp_reset_query();
		
	}
}

?>