<?php

// Recent Posts
// ----------------------------------------------------
class ThemeWidgetRecentTweets extends ThemeWidgetBase {
	
	/*
	* Register widget function. Must have the same name as the class
	*/
	function ThemeWidgetRecentTweets() {
		$widget_opts = array(
			'classname' => 'theme-widget-recent-tweets', // class of the <li> holder
			'description' => __( 'Displays recent tweets from a username.','forgiven' ) // description shown in the widget list
		);
		// Additional control options. Width specifies to what width should the widget expand when opened
		$control_ops = array(
			//'width' => 350,
		);
		// widget id, widget display title, widget options
		$this->WP_Widget('theme-widget-recent-tweets', __('Twitter Feed','forgiven'), $widget_opts, $control_ops);
		$this->custom_fields = array(
			array(
				'name'=>'title',
				'type'=>'text',
				'title'=>'Title', 
				'default'=>__('Recent Tweets','forgiven')
			),
			array(
				'name'=>'twitter_user',
				'type'=>'text',
				'title'=>'Twitter Username', 
				'default'=>''
			),
			array(
				'name'=>'load',
				'type'=>'integer',
				'title'=>__('How many tweets?','forgiven'), 
				'default'=>'3'
			),
			array(
				'name'=>'button_text',
				'type'=>'text',
				'title'=>'Button Text (optional)', 
				'default'=>''
			),
			array(
				'name'=>'button_url',
				'type'=>'text',
				'title'=>'Button URL (optional)', 
				'default'=>''
			),
			array(
				'name'=>'new_window',
				'type'=>'set',
				'title'=>'Open button URL in a new window?', 
				'default'=>'',
				'options'=>array(true=>'Yes')
			)
		);
	}
	
	/*
	* Called when rendering the widget in the front-end
	*/
	function front_end($args, $instance) {
	
		extract($args);
		
		if (ot_get_option('twitter_oauth_access_token') && ot_get_option('twitter_oauth_access_token_secret') && ot_get_option('twitter_consumer_key') && ot_get_option('twitter_consumer_secret')){
		
			$load = intval($instance['load']);
			$title = $instance['title'];
			$twitter_user = $instance['twitter_user'];
			$button_text = $instance['button_text'];
			$button_url = $instance['button_url'];
			$new_window = $instance['new_window'];
			
			?><div class="tweets-widget"><?php
				
				echo ($title ? $before_title.$title.$after_title : '');
				
				if ($button_url || $button_text) {
				
					?><a href="<?php echo $button_url; ?>"<?php if ($new_window){ ?>target="_blank"<?php } ?> class="widget-button"><?php echo $button_text; ?></a><?php
				
				} ?>
			
				<div class="tweets-container">
					
					<?php
					$twitter_helper = new TwitterHelper($twitter_user);
					$tweets = $twitter_helper->get_tweets($twitter_user, $load);
					if (empty($tweets)) {
						return;
					}
					
					if (!empty($tweets)) {
						echo '<ul>';
						foreach ($tweets as $tweet) {
							?>
							<li>
								<span class="tweet_text"><?php echo wpautop(preg_replace('~' . preg_quote($instance['twitter_user'], '~') . ': ~iu', '', $tweet->tweet_text)); ?></span>
								<span class="tweet_time"><a target="_blank" href="<?php echo $tweet->tweet_link; ?>"><?php echo $tweet->time_distance; ?> &mdash; <?php _e('View on Twitter','forgiven'); ?></a></span>
							</li>
							<?php
						}
						echo '</ul>';
					}
					?>
					
				</div>
			
			</div><?php

		} else {
			
			echo '<p style="color:#dd0000;"><strong>Important:</strong> You need to enter your Twitter Settings on the Theme Options panel before you can use this widget.</p>';
			
		}
		
	}
}

?>