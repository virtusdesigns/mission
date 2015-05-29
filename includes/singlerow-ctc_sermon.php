<?php

echo '<div class="sermon-archive-block">';
			
	// Featured Thumbnail
	echo (has_post_thumbnail() ? '<div class="clearfix"><div class="sermon-thumb">'.get_the_post_thumbnail($post->ID,'sermon-thumb').'</div>' : '');
	
		// Title, meta and excerpt
		?><div class="sermon-title-meta<?php echo (has_post_thumbnail() ? ' with-thumb' : ''); ?>">
		
			<h4 class="post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
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
			<?php if (has_excerpt($post->ID)): ?><?php the_excerpt(); ?><?php endif; ?>
			<a href="<?php the_permalink(); ?>" class="es-button"><?php _e('View Teaching','forgiven'); ?></a>
			
		</div><?php
	
	echo (has_post_thumbnail() ? '</div>' : '');

echo '</div>';