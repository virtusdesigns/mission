<div id="page-post" class="shell clearfix">
	
	<article <?php post_class('full page-content'); ?>><?php
	
		if (have_posts()) : while(have_posts()) : the_post();
	
		js_breadcrumbs(); ?>
		<h1 class="page-title"><?php the_title(); ?></h1>
		<?php the_content();
		
		endwhile; endif;
		
		$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
		$args = array(
			'post_type' => 'ctc_sermon',
			'paged' => $paged
		);
		
		query_posts($args);
		if (have_posts()) :
			while(have_posts()) : the_post();
			
				get_template_part('singlerow','ctc_sermon');
				
			endwhile;
		endif; 
		
		js_get_pagination(); wp_reset_query();
		
	?></article>
	
</div>