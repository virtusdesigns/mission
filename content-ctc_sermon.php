<?php
/**
 * The default template for displaying content of posts.
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(themeblvd_get_att('class')); ?>>

	<header class="entry-header">

		<?php if ( ! has_post_format('aside') && ! has_post_format('quote') ) : ?>
			<h1 class="entry-title<?php if ( themeblvd_get_att('show_meta') ) echo ' entry-title-with-meta'; ?>">
				<?php themeblvd_the_title(); ?>
			</h1>
		<?php endif; ?>

		<?php if ( themeblvd_get_att('show_meta') ) : ?>
			<div class="meta-wrapper above">
				<?php themeblvd_blog_meta(); ?>
			</div><!-- .meta-wrapper (end) -->
		<?php endif; ?>

	</header><!-- .entry-header -->

	<div class="entry-content clearfix">
		<?php themeblvd_blog_content( themeblvd_get_att('content') ); // Abide by relevant excerpt vs content theme option ?>
		

	</div><!-- .entry-content -->

	<?php if ( themeblvd_get_att('show_sub_meta') ) : ?>
		<div class="sub-meta-wrapper">
			<?php themeblvd_blog_sub_meta(); ?>
		</div><!-- .sub-meta-wrapper (end) -->
	<?php endif; ?>

	<?php if ( is_single() ) : ?>
		<?php wp_link_pages( array( 'before' => '<div class="page-link">' . themeblvd_get_local('pages').': ', 'after' => '</div>' ) ); ?>
	<?php endif; ?>

	<?php edit_post_link( themeblvd_get_local( 'edit_post' ), '<div class="edit-link"><i class="fa fa-edit"></i> ', '</div>' ); ?>

</article><!-- #post-<?php the_ID(); ?> -->