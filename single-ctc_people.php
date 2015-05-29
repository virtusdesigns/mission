<?php get_header(); ?>

<?php if (have_posts()) :
	
	?><div class="bottom-spacer"></div><?php
	
		while (have_posts()) : the_post();
	
			get_template_part('includes/postparts/postpart',get_post_type());
		
		endwhile;
		
	?><div class="bottom-spacer"></div><?php
	
endif;

get_footer();