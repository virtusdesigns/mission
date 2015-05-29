<div class="col-sm-4">
<article class="recent-post-block staff clearfix">
	<?php if (has_post_thumbnail($post->ID)){
		extract(ctfw_person_data());	
		$image_url = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID),'circle-thumb'); $image_url = $image_url[0]; ?>
		<a href="<?php the_permalink(); ?>" class="widget-post-thumbnail">
			<img src="<?php echo $image_url; ?>" />
			<span class="meta-info">
			
				<div class="post-meta">
					<?php if ( $position ) : ?>
						<span><i class="fa fa-user"></i><?php echo esc_html( $position ); ?></span><br />
					<?php endif; ?>
					<?php if ( $phone ) : ?>
						<span><i class="fa fa-phone"></i><?php echo esc_html( $phone ); ?></span><br />
					<?php endif; ?>
				</div>
				
			</span>
		</a>
	<?php } ?>
	
	<h3><?php the_title(); ?></h3>
	
	<?php the_excerpt(); ?>
	<p class="post-link">
		<a href="<?php the_permalink(); ?>"><?php _e('Read Biography','forgiven'); ?></a>
	</p>
</article>
</div>