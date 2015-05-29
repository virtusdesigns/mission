<?php

// Recent Posts
// ----------------------------------------------------
class ThemeWidgetFacebookFeed extends ThemeWidgetBase {
	
	/*
	* Register widget function. Must have the same name as the class
	*/
	function ThemeWidgetFacebookFeed() {
		$widget_opts = array(
			'classname' => 'theme-widget-facebook-feed', // class of the <li> holder
			'description' => __( 'Displays the Facebook Feed from a user or page.','forgiven' ) // description shown in the widget list
		);
		// Additional control options. Width specifies to what width should the widget expand when opened
		$control_ops = array(
			//'width' => 350,
		);
		// widget id, widget display title, widget options
		$this->WP_Widget('theme-widget-facebook-feed', __('Facebook Feed','forgiven'), $widget_opts, $control_ops);
		$this->custom_fields = array(
			array(
				'name'=>'title',
				'type'=>'text',
				'title'=>'Title', 
				'default'=>__('Facebook Feed','forgiven')
			),
			array(
				'name'=>'facebook_id',
				'type'=>'text',
				'title'=>'Facebook Page ID',
				'default'=>''
			),
			array(
				'name'=>'load',
				'type'=>'integer',
				'title'=>__('How many total items?','forgiven'), 
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
		
		if (ot_get_option('facebook_app_id') && ot_get_option('facebook_app_secret')){
		
			global $fb;
			$fb = new Facebook(array(
				'appId' => ot_get_option('facebook_app_id'),
				'secret' => ot_get_option('facebook_app_secret')
			));
			$fb->getAccessToken();
			
			$load = intval($instance['load']);
			$title = $instance['title'];
			$facebook_id = $instance['facebook_id'];
			$button_text = $instance['button_text'];
			$button_url = $instance['button_url'];
			$new_window = $instance['new_window'];
			
			?><div class="facebook-widget"><?php
				
				echo ($title ? $before_title.$title.$after_title : ''); ?>
				
				<?php if ($button_url || $button_text) {
				
					?><a href="<?php echo $button_url; ?>"<?php if ($new_window){ ?>target="_blank"<?php } ?> class="widget-button"><?php echo $button_text; ?></a><?php
				
				} ?>
				
				<ul>
					<?php
						
					$statuses = $fb->api('/' . $facebook_id . '/feed', array( 'limit' => $load, 'type' => 'message' ));
					
					if (!empty($statuses['data'])) {
						$temp_count = 0;
						foreach ($statuses['data'] as $s): $temp_count++;
							
							if ($temp_count <= $load){
							
								if ($s['type'] == 'photo'){
								
									if (isset($s['message'])){
										$message = $s['message'];
									} elseif (isset($s['story'])) {
										$message = $s['story'];
									}
								
									?>
									<li>
										<span class="tweet_text"><em><?php echo makeClickableLinks(js_char_shortalize($message)); ?></em><?php echo '<br /><strong><a href="'.$s['link'].'">View photo</a></strong>'; ?></span>
										<span class="tweet_time"><span><?php echo relativeTime($s['created_time'],true); ?></span></span>
									</li>
									<?php
								
								} else {
								
									if (isset($s['message'])){
										$message = $s['message'];
									} else {
										$message = $s['story'];
									}
							
									?>
									<li>
										<span class="tweet_text"><?php echo makeClickableLinks(js_char_shortalize($message)); ?><?php if ($s['type'] == 'link'){ echo '<br /><a href="'.$s['link'].'">Click to view link</a>'; } ?></span>
										<span class="tweet_time"><span><?php echo relativeTime($s['created_time'],true); ?></span></span>
									</li>
									<?php
								
								}
								
							} else {
								break;
							}
						endforeach;
					}
					?>
				</ul>
			
			</div><?php

		} else {
			
			echo '<p style="color:#dd0000;"><strong>Important:</strong> You need to enter your Facebook Settings on the Theme Options panel before you can use this widget.</p>';
			
		}
		
	}
}

?>