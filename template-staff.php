<?php
/*
Template Name: Staff
*/

$groups = themeblvd_get_option('staff_groups');

get_header(); global $template_dir;

?><div class="bottom-spacer"></div>
<div id="page-post" class="shell clearfix">
	
	<article <?php post_class('full page-content'); ?>><?php
	
		if (have_posts()) : while(have_posts()) : the_post();
	
		js_breadcrumbs(); ?>
		<h1 class="page-title"><?php the_title(); ?></h1>
		<?php the_content();
		
		endwhile; endif;

		if ( empty( $groups )) {
			
			$args = array(
				'post_type' => 'ctc_person',
				'orderby' => 'menu_order',
				'order' => 'asc',
				'posts_per_page' => -1
			);
			
			query_posts($args);
				get_template_part( 'includes/loop', 'staff-member' );
			wp_reset_query();
			
		} else {
			
			$groups = forgiven_get_group_slugs( get_terms( 'ctc_person_group', array('orderby' => 'slug')), false );		

			foreach ( $groups as $slug => $title ) {
				echo '<h3 class="staff-group-title">' . $title['name'];
				if ($title['description']): echo wpautop($title['description']); endif;
				echo '</h3>';

				$args = array(
					'post_type' => 'ctc_person',
					'orderby' => 'menu_order',
					'order' => 'asc',
					'posts_per_page' => -1,
					'tax_query' => array(
						array(
							'taxonomy' => 'ctc_person_group',
							'field' => 'slug',
							'terms' => $slug
						)
					)
				);
				
				query_posts($args);
					get_template_part( 'includes/loop', 'staff-member' );
				wp_reset_query();

			}
		}
		
	?></article>
	
</div>
<div class="bottom-spacer"></div><?php

get_footer();