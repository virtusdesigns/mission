<?php
/*
	Template Name: Sermons
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

<div id="sidebar_layout" class="clearfix">
<div class="sidebar_layout-inner">
<div class="row grid-protection">

<!-- CONTENT (start) -->

<div id="content" class="<?php echo themeblvd_get_column_class('content'); ?> clearfix" role="main">
<div class="inner">
<?php themeblvd_content_top(); ?>


	

	
	<?php if (have_posts()) : while(have_posts()) : the_post(); ?>
		
		<h1 class="page-title"><?php the_title(); ?></h1>
		<?php the_content();
		
		endwhile; endif;

		get_template_part( 'includes/sermons', 'filter' );
		
		query_posts($args);
		if (have_posts()) :
			while(have_posts()) : the_post();
	
				get_template_part('includes/singlerow','ctc_sermon');
				
			endwhile;
		endif; 
		
		themeblvd_pagination( $x->max_num_pages );
		
	?>

<?php themeblvd_content_bottom(); ?>
</div><!-- .inner (end) -->
</div><!-- #content (end) -->
<!-- CONTENT (end) -->

<!-- SIDEBARS (start) -->

<?php get_sidebar( 'left' ); ?>

<?php get_sidebar( 'right' ); ?>

<!-- SIDEBARS (end) -->


</div><!-- .grid-protection (end) -->
</div><!-- .sidebar_layout-inner (end) -->
</div><!-- .#sidebar_layout (end) -->

<?php get_footer(); ?>