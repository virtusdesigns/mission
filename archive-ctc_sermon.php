<?php
/*
	Archive for Teachings
*/

$paged   = (get_query_var('paged')) ? get_query_var('paged') : 1;

$topic   = !empty( $_GET['topic'] ) ? $_GET['topic'] : '';
$book    = !empty( $_GET['book'] ) ? $_GET['book'] : '';
$series  = !empty( $_GET['series'] ) ? $_GET['series'] : '';
$speaker = !empty( $_GET['speaker'] ) ? $_GET['speaker'] : '';

$topic_query   = forgiven_generate_tax_query( $topic, 'ctc_sermon_topic' );
$book_query    = forgiven_generate_tax_query( $book, 'ctc_sermon_book' );
$series_query  = forgiven_generate_tax_query( $series, 'ctc_sermon_series' );
$speaker_query = forgiven_generate_tax_query( $speaker, 'ctc_sermon_speaker' );

$tax_query = array(
	'relation' => 'AND',
	$topic_query,
	$book_query,
	$series_query,
	$speaker_query,
);

$args = array(
	'post_type' => 'ctc_sermon',
	'paged' => $paged,
	'tax_query' => $tax_query
);

get_header(); global $template_dir;

?>
<div id="page-post" class="shell clearfix">
	
	<article <?php post_class('full page-content'); ?>>
	
	<?php js_breadcrumbs(); ?>
	
	<?php
	
		if (have_posts()) : while(have_posts()) : the_post(); ?>

		<?php 
		
		endwhile; endif;

		get_template_part( 'includes/sermons', 'filter' );
		
		query_posts($args);
		if (have_posts()) :
			while(have_posts()) : the_post();
	
				get_template_part('includes/singlerow','ctc_sermon');
				
			endwhile;
		endif; 
		
		js_get_pagination(); wp_reset_query();
		
	?></article>
	
</div>
<?php

get_footer();