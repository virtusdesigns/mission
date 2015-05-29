<?php
/**
 * Page Functions
 *
 * These functions apply to the page post type only.
 *
 * @package    Church_Theme_Framework
 * @subpackage Functions
 * @copyright  Copyright (c) 2013, churchthemes.com
 * @link       https://github.com/churchthemes/church-theme-framework
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 * @since      0.9
 */

// No direct access
if ( ! defined( 'ABSPATH' ) ) exit;

/**********************************
 * DATA
 **********************************/

/**
 * Get page by template
 *
 * Get newest page using a specific template file name.
 * 
 * Multiple templates can be specified as array and the first match will be used.
 * This is handy when one template rather than the usual is used for primary content.
 *
 * @since 0.9
 * @param string|array $templates Template or array of templates (first match used)
 * @return object Page data
 */
function ctfw_get_page_by_template( $templates ) {

	$page = false;

	// Force single template string into array
	$templates = (array) $templates;

	// Loop template by priority
	foreach ( $templates as $template ) {

		// Templates are stored in directory
		$template = CTFW_THEME_PAGE_TPL_DIR . '/' . basename( $template );

		/*

		// If more than one, gets the newest
		$pages = get_pages( array(
			'meta_key' => '_wp_page_template',
			'meta_value' => $template,
			'sort_column' => 'ID',
			'sort_order' => 'DESC',
			'number' => 1
		) );
		
		// Got one?
		if ( ! empty( $pages[0] ) ) {
			return $pages[0];
		}
		
		*/
		
		// Note: the method above fails for pages that have parent(s) so using WP_Query directly
		
		// If more than one, gets the newest
		$page_query = new WP_Query( array(
			'post_type'			=> 'page',
			'nopaging'			=> true,
			'posts_per_page'	=> 1,
			'meta_key' 			=> '_wp_page_template',
			'meta_value' 		=> $template,
			'orderby'			=> 'ID',
			'order'				=> 'DESC'
		) );
		
		// Got one?
		if ( ! empty( $page_query->post ) ) {
			$page = $page_query->post;
			break; // if not check next template
		}

	}

	return apply_filters( 'ctfw_get_page_by_template', $page, $templates );

}

/**
 * Get page ID by template
 * 
 * Get newest page ID using a specific template file name.
 * 
 * Multiple templates can be specified as array and the first match will be used.
 * This is handy when one template rather than the usual is used for primary content.
 *
 * @since 0.9
 * @param string|array $templates Template or array of templates (first match used)
 * @return int Page ID
 */
function ctfw_get_page_id_by_template( $templates ) {

	$page = ctfw_get_page_by_template( $templates );

	$page_id = ! empty( $page->ID ) ? $page->ID : '';
	
	return apply_filters( 'ctfw_get_page_id_by_template', $page_id, $templates );	

}

/**
 * Page options
 *
 * Handy for making select options
 *
 * @since 0.9
 * @param bool $allow_none Whether or not to include option for none
 * @return array Page options
 */
function ctfw_page_options( $allow_none = true ) {

	$pages = get_pages( array(
		'hierarchical' => false,
	) );
	
	$page_options = array();
	
	if ( ! empty( $allow_none ) ) {
		$page_options[] = '';
	}
	
	foreach ( $pages as $page ) {
		$page_options[$page->ID] = $page->post_title;
	}
	
	return $page_options;

}
