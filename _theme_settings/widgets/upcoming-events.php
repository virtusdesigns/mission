<?php

// Recent Posts
// ----------------------------------------------------
class ThemeWidgetUpcomingEvents extends ThemeWidgetBase {
	
	/*
	* Register widget function. Must have the same name as the class
	*/
	function ThemeWidgetUpcomingEvents() {
		$widget_opts = array(
			'classname' => 'theme-widget-upcoming-events', // class of the <li> holder
			'description' => __( 'Displays your upcoming events.','forgiven' ) // description shown in the widget list
		);
		// Additional control options. Width specifies to what width should the widget expand when opened
		$control_ops = array(
			//'width' => 350,
		);
		// widget id, widget display title, widget options
		$this->WP_Widget('theme-widget-upcoming-events', __('Upcoming Events','forgiven'), $widget_opts, $control_ops);
		$this->custom_fields = array(
			array(
				'name'=>'title',
				'type'=>'text',
				'title'=>'Title', 
				'default'=>__('Upcoming Events','forgiven')
			),
			array(
				'name'=>'load',
				'type'=>'integer',
				'title'=>__('How many total items?','forgiven'), 
				'default'=>'3'
			)
		);
	}
	
	/*
	* Called when rendering the widget in the front-end
	*/
	function front_end($args, $instance) {
	
		extract($args);
		
		$limit = intval($instance['load']);
		$title = $instance['title'];
		
		$events = tribe_get_events(array(
			'eventDisplay'=>'list',
			'posts_per_page'=>$limit
		));
		
		if (!empty($events)) {
		
			echo ($title ? $before_title.$title.$after_title : '');
			
			foreach ($events as $event) {
			
				$start_date = strtotime(tribe_get_start_date($event->ID,false,'Y-m-d H:i:s'));
				$start_date_day = date('Y-m-d', $start_date);
				$end_date = strtotime(tribe_get_end_date($event->ID,false,'Y-m-d H:i:s'));
				$end_date_day = date('Y-m-d', $end_date);
				$all_day = tribe_event_is_all_day($event->ID);
				$time_format = get_option('time_format');
				
				if ($all_day){
					$date_format = date_i18n('F j', $start_date).'<span>&bull;</span> <em>'.__('All day','forgiven').'</em>';
				} else if ($end_date_day){
					if ($start_date_day == $end_date_day){
						$date_format = date_i18n('F j', $start_date).'<span>&bull;</span> <em>'.date($time_format,$start_date).' &ndash; '.date($time_format,$end_date).'</em>';
					} else {
						$date_format = date_i18n('F j', $start_date).' <em>@ '.date($time_format,$start_date).'<br />'.__('to','forgiven').'</em> '.date_i18n('F j', $end_date).' <em>@'.date($time_format,$end_date).'</em>';
					}
				}
				
				?><article class="upcoming-event-block clearfix">
					<h3><a href="<?php echo get_permalink($event->ID); ?>"><?php echo apply_filters('the_title', $event->post_title); ?></a></h3>
					<small><?php echo $date_format; ?></small>
					<p><?php echo ($event->post_excerpt ? $event->post_excerpt : forgivenTruncate($event->post_content,155).' ...'); ?></p>
					<a class="es-button" href="<?php echo get_permalink($event->ID); ?>"><?php _e('Event Information','forgiven'); ?></a>
				</article><?php
			}
		} wp_reset_query();
		
	}
}

?>