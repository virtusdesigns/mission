<?php

global $event_items_title;

	
		$event_category = get_post_meta($post->ID,'_event_category',true);
		echo '<div class="schedule-category">'.($event_category ? $event_category : 0).'</div>';
		
		?><section id="homepage-events" class="homepage-block">
				<div class="shell clearfix" style="position:relative;">
					<h2 class="centered schedule-title"><span><?php echo $event_items_title; ?></span></h2>
					<a href="#" class="fg-schedule-prev-week fg-schedule-week-change bx-btn" data="<?php echo date('Y/m/d', strtotime('-1 week')); ?>"><i class="fa fa-arrow-left"></i><span>&nbsp;&nbsp;&nbsp;<?php _e('Previous Week','forgiven'); ?></span></a>
					<a href="#" class="fg-schedule-next-week fg-schedule-week-change bx-btn" data="<?php echo date('Y/m/d', strtotime('+1 week')); ?>"><span><?php _e('Next Week','forgiven'); ?>&nbsp;&nbsp;&nbsp;</span><i class="fa fa-arrow-right"></i></a><?php
					echo '<div id="schedule-block" class="ajax-wrapper"><div class="spinner"></div></div>';
				?></div>
		</section>