<div id="page-post" class="shell clearfix">

	<?php
	
	$post_options = get_post_meta($post->ID,'_post_options',true);
	$sidebar_choice = get_post_meta($post->ID, '_post_sidebar_choice', true);
	$sidebar_type = get_post_meta($post->ID,'_post_sidebar_layout',true);
	$sidebar_type = (!empty($sidebar_type) ? $sidebar_type = $sidebar_type[0] : $sidebar_type = false);
	
	if ($sidebar_type == 'left'){
		$page_type = 'right';
		$featured_image_size = 'sm';
	} else if ($sidebar_type == 'right'){
		$page_type = 'left';
		$featured_image_size = 'sm';
	} else if ($sidebar_type == 'no-sidebar'){
		$page_type = 'full';
		$featured_image_size = 'full';
	} else {
		$page_type = ot_get_option('default_page_type','full');
		if ($page_type == 'full'):
			$featured_image_size = 'full';
		elseif ($page_type == 'right') :
			$sidebar_type = 'left';
			$featured_image_size = 'sm';
		elseif ($page_type == 'left') :
			$sidebar_type = 'right';
			$featured_image_size = 'sm';
		endif;
	}

	extract(ctfw_person_data());
		
	?><article <?php post_class($page_type.' page-content'); ?>>
		
		<?php js_breadcrumbs(); ?>
		
		<div class="clearfix">
		
			<?php if (has_post_thumbnail()){
				echo '<div class="staff-image">'; the_post_thumbnail('circle-thumb'); echo '</div>';
				echo '<div class="staff-info">';
			} else {
				echo '<div class="staff-info-no-thumb">';
			}
			?>
			
				<h1 class="page-title"><?php the_title(); ?></h1>
				
				<div class="post-meta lg">
							
					<?php if ( $position ) : ?>
						<span><i class="fa fa-user"></i><?php echo esc_html( $position ); ?></span><br />
					<?php endif; ?>
					<?php if ( $phone ) : ?>
						<span><i class="fa fa-phone"></i><?php echo esc_html( $phone ); ?></span><br />
					<?php endif; ?>
					
					<?php if ( $email || $urls ) : ?>
						<?php if ( $email ) : ?>
							<span><i class="fa fa-envelope"></i><a href="mailto:<?php echo antispambot( $email, true ); ?>"><?php echo antispambot( $email ); ?></a></span><br />
						<?php endif; ?>
						<?php if ( $urls ) : ?>
							<div class="forgiven-url-icons"><?php forgiven_social_icons( $urls ); ?></div>
						<?php endif; ?>
					<?php endif; ?>
					
				</div>
	
			</div>
		
		</div>
		
		<?php the_content();

	?></article><?php
	
	if ($sidebar_type && $sidebar_type != 'no-sidebar'){ ?>
		<aside class="<?php echo $sidebar_type; ?>">
			<?php get_sidebar(); ?>
		</aside>
	<?php } ?>
	
</div>