<?php get_header(); ?>

<?php if (have_posts()) : ?>
	
	<?php while (have_posts()) : the_post();
	
			get_template_part('includes/postparts/postpart',get_post_type());
		
		endwhile; ?>
		
<?php endif;

get_footer();