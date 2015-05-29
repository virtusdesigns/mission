<?php

// Recent Posts
// ----------------------------------------------------
class ThemeWidgetFeaturedSermon extends ThemeWidgetBase {
	
	/*
	* Register widget function. Must have the same name as the class
	*/
	function ThemeWidgetFeaturedSermon() {
		$widget_opts = array(
			'classname' => 'theme-widget-featured-sermon', // class of the <li> holder
			'description' => __( 'Displays a featured sermon.','forgiven' ) // description shown in the widget list
		);
		// Additional control options. Width specifies to what width should the widget expand when opened
		$control_ops = array(
			//'width' => 350,
		);
		// widget id, widget display title, widget options
		$this->WP_Widget('theme-widget-featured-sermon', __('Featured Sermon','forgiven'), $widget_opts, $control_ops);
		$this->custom_fields = array(
			array(
				'name'=>'title',
				'type'=>'text',
				'title'=>'Title', 
				'default'=>__('Featured Sermon','forgiven')
			),
			array(
				'name'=>'sermon_id',
				'type'=>'customPosts',
				'options'=>array(
					'post_type' => 'ctc_sermon',
					),
				'title'=>__('Select a Sermon','forgiven'),
				'default'=>''
			)
		);
	}
	
	/*
	* Called when rendering the widget in the front-end
	*/
	function front_end($args, $instance) {
	
		extract($args);
		
		$sermon_title = $instance['title'];
		$sermon_choice = $instance['sermon_id'];
		
		if (!$sermon_choice[0]){

			$sermon_query = array(
				'post_type' => 'ctc_sermon',
			    'posts_per_page' => 1,
			    'orderby' => 'date',
			    'order' => 'desc'
			);
			
		} else {
			
			$sermon_query = array(
				'post_type' => 'ctc_sermon',
			    'posts__in' => $sermon_choice[0]
			);
			
		}
		
		query_posts($sermon_query);
		$temp_count = 0; $total_count = 0;
		
		if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
		
			<?php extract(ctfw_sermon_data()); ?>
		
			<section id="sermon-bar" class="homepage-block">
				<div class="shell clearfix">
					<div class="sermon-info">
						<h3><?php echo $sermon_title; ?></h3>
						<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
						<div class="post-meta">
							<span><i class="fa fa-calendar"></i> <?php echo relativeTime(get_the_time('U')) ?></span><?php
										
								if ( $speakers = get_the_term_list( $post->ID, 'ctc_sermon_speaker', '', __( ', ', 'forgiven' ) ) ) :
									echo '<span><i class="fa fa-user"></i> ';
									echo $speakers;
									echo '</span>';
								endif;
								
								if ( $topics = get_the_term_list( $post->ID, 'ctc_sermon_topic', '', __( ', ', 'forgiven' ) ) ) :
									echo '<span><i class="fa fa-file-text-o"></i> ';
									echo $topics;
									echo '</span>';
								endif;
						
								if ( $books = get_the_term_list( $post->ID, 'ctc_sermon_book', '', __( ', ', 'forgiven' ) ) ) :
									echo '<span><i class="fa fa-book"></i> ';
									echo $books;
									echo '</span>';
								endif;
								
								if ( $series = get_the_term_list( $post->ID, 'ctc_sermon_series', '', __( ', ', 'forgiven' ) ) ) :
									echo '<span><i class="fa fa-files-o"></i> ';
									echo $series;
									echo '</span>';
								endif;
						
							?><span><i class="fa fa-comment"></i> <a href="<?php the_permalink(); ?>/#comments"><?php comments_number(__('No comments','forgiven'),'1 '.__('comment','forgiven'),'% '.__('comments','forgiven')); ?></a></span>
						</div>
						<?php if ( $audio_player ) : echo $audio_player; endif; ?>
					</div>
				</div>
			</section><?php
			
		endwhile; endif;
		
		wp_reset_query();
		
	}
}

?>