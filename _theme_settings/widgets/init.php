<?php

include('recent-posts.php');
include('featured-sermon.php');
include('recent-tweets.php');
include('facebook-feed.php');
include('text.php');
include('hours.php');
include('map.php');
if (class_exists('TribeEvents')) include('upcoming-events.php');

/* Register the widgets */
function load_widgets() {
	register_widget('ThemeWidgetRecentPosts');
	register_widget('ThemeWidgetRecentTweets');
	register_widget('ThemeWidgetFacebookFeed');
	register_widget('ThemeWidgetFeaturedSermon');
	register_widget('ThemeWidgetTextWidget');
	register_widget('ThemeWidgetHoursWidget');
	register_widget('ThemeWidgetMapWidget');
	if (class_exists('TribeEvents')) register_widget('ThemeWidgetUpcomingEvents');
}
add_action('widgets_init', 'load_widgets');

?>