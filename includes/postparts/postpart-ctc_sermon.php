<div id="page-post" class="shell clearfix">

	<?php extract(ctfw_sermon_data());
	

	if (!is_array($post_options) || !in_array('hide_featured_image',$post_options)): $thumbnail_status = ''; else : $thumbnail_status = 'hidden-thumb'; endif;
	
	?><article <?php post_class($thumbnail_status.' '.$page_type.' page-content'); ?>><?php
	
		// Featured Thumbnail

			echo (has_post_thumbnail() ? '<div class="clearfix"><div class="sermon-thumb">'.get_the_post_thumbnail($post->ID,'sermon-thumb').'</div>' : '');

		
			// Title, meta and excerpt
			?><div class="sermon-title-meta<?php echo (has_post_thumbnail() ? ' with-thumb' : ''); ?>"><?php
			
				js_breadcrumbs(); ?>
				<h1 class="page-title"><?php the_title(); ?></h1>
				<div class="sermon-meta-block">
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
					<?php if (has_excerpt($post->ID)): ?><div class="excerpt"><?php the_excerpt(); ?></div><?php endif; ?>
				</div>
				
			</div>
			
			<?php echo (has_post_thumbnail() ? '</div>' : ''); ?>
		
		<div id="forgiven-sermon-full-media" class="clearfix">
		
			<?php $tab_order = explode('_',get_option('sermon_tab_order','video_audio_text'));
			$temp_count = 0;
			
			foreach($tab_order as $tab){
			
				switch ($tab) {
				    case 'audio':
				    	if ( $audio_player ) : $temp_count++; ?>
							<a href="#" class="fg-sermon-button<?php if ($temp_count == 1): echo ' active'; endif; ?>" data="audio">
								<i class="fa fa-volume-up"></i>
								<?php _e( 'Audio', 'forgiven' ); ?>
							</a>
						<?php endif; 
				        break;
				    case 'video':
				    	if ( $video_player ) : $temp_count++; ?>
							<a href="#" class="fg-sermon-button<?php if ($temp_count == 1): echo ' active'; endif; ?>" data="video">
								<i class="fa fa-video-camera"></i>
								<?php _e( 'Video', 'forgiven' ); ?>
							</a>
						<?php endif;
				        break;
				    case 'text':
				    	if ( $has_full_text ) : $temp_count++; ?>
							<a href="#" class="fg-sermon-button<?php if ($temp_count == 1): echo ' active'; endif; ?>" data="text">
								<i class="fa fa-file-text-o"></i>
								<?php _e( 'Text', 'forgiven' ); ?>
							</a>
						<?php endif;
				        break;
				}
				
			} ?>
			
			<div id="fg-save-buttons">
					
				<?php

				if ( $video_download_url ) :
					?><a class="fg-sermon-button-sm" href="<?php echo esc_url( $video_download_url ); ?>" title="<?php echo esc_attr( __( 'Save Video', 'forgiven' ) ); ?>">
						<i class="fa fa-arrow-circle-o-down"></i>
						<?php _e( 'Save Video', 'forgiven' ); ?>
					</a><?php
				endif;

				if ( $audio_download_url ) :
					?><a class="fg-sermon-button-sm" href="<?php echo esc_url( $audio_download_url ); ?>" title="<?php echo esc_attr( __( 'Save Audio', 'forgiven' ) ); ?>">
						<i class="fa fa-arrow-circle-o-down"></i>
						<?php _e( 'Save Audio', 'forgiven' ); ?>
					</a><?php
				endif;
				
				if ( $pdf_download_url ) :
					?><a class="fg-sermon-button-sm" href="<?php echo esc_url( $pdf_download_url ); ?>" title="<?php echo esc_attr( __( 'Save PDF', 'forgiven' ) ); ?>">
						<i class="fa fa-arrow-circle-o-down"></i>
						<?php _e( 'Save PDF', 'forgiven' ); ?>
					</a><?php
				endif;

				?>
					
			</div>
			
		</div>
		
		<div id="fg-sermon-player-blocks">
		
			<?php $temp_count = 0; foreach($tab_order as $tab){
			
				switch ($tab) {
				    case 'audio':
				    	if ($audio_player) : $temp_count++; ?>
							<div class="fg-sermon-block audio<?php if ($temp_count == 1): ?> active<?php endif; ?>">
								<?php echo $audio_player ?>
							</div>
						<?php endif;
				        break;
				    case 'video':
				    	if ($video_player) : $temp_count++; ?>
							<div class="fg-sermon-block video<?php if ($temp_count == 1): ?> active<?php endif; ?>">
								<?php echo $video_player; ?>
							</div>
						<?php endif;
				        break;
				    case 'text':
				    	if ($has_full_text) : $temp_count++; ?>
							<div class="fg-sermon-block text<?php if ($temp_count == 1): ?> active<?php endif; ?>">
								<?php the_content(); ?>
							</div>
						<?php endif;
				        break;
				}
				
			} ?>
			
		</div>

		<?php if (!$has_full_text) : the_content(); endif;
		
		comments_template();
					
		wp_link_pages('before=<p>&after=</p>&next_or_number=number&pagelink=page %');

	?></article><?php
	
	if ($sidebar_type && $sidebar_type != 'no-sidebar'){ ?>
		<aside class="<?php echo $sidebar_type; ?>">
			<?php dynamic_sidebar($sidebar_choice); ?>
		</aside>
	<?php } ?>
	
</div>