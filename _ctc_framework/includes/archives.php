<?php
/**
 * Archive Functions
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
 * DATE ARCHIVES
 **********************************/

/**
 * Custom Post Type Date Archive Setup
 * 
 * At time of making, WordPress (3.6 and possibly later) does not support dated archives for custom post types as it does for standard posts.
 * This injects rules so that URL's like /cpt/2012/05 can be used with the custom post type archive template.
 * 
 * Note: resave permalinks if ever change this
 *
 * Thanks to Milan Petrovic for his guide: http://www.dev4press.com/2012/tutorials/wordpress/practical/url-rewriting-custom-post-types-date-archive/
 * (with an assist from Brian Krogsgard: http://krogsgard.com)
 *
 * @since 0.9
 * @param array $post_types Post types to enable date archive for
 * @param object $wp_rewrite
 */
function ctfw_cpt_date_archive_setup( $post_types, $wp_rewrite ) {

	// Enable override by child theme
	$rules = apply_filters( 'ctfw_cpt_date_archive_setup_rules', array(), $post_types, $wp_rewrite ); // empty if nothing passed in by filter

	// If rules not already provided via filter
	if ( empty( $rules ) ) {

		// Cast single post type as array
		$post_types = (array) $post_types;
		
		// Loop given post types to build rules
		foreach ( $post_types as $post_type_slug ) {

			// Post type data
			$post_type = get_post_type_object( $post_type_slug );

			// Post type has archive enabled
			if ( isset( $post_type->has_archive ) && true === $post_type->has_archive ) {

				// Date archive rules
				$date_rules = array(
				
					// Year, Month, Day: /cpt-slug/2012/01/1
					array(
						'rule' => '([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})', // URL pattern
						'vars' => array( 'year', 'monthnum', 'day' ) // corresponding query parameters
					),
					
					// Year, Month: /cpt-slug/2012/01
					array(
						'rule' => '([0-9]{4})/([0-9]{1,2})',
						'vars' => array( 'year', 'monthnum' )
					),
					
					// Day: /cpt-slug/2012
					array(
						'rule' => '([0-9]{4})',
						'vars' => array( 'year' )
					)
					
				);

				// Build rewrite rules and queries
				foreach ( $date_rules as $date_rule ) {
				
					// Base query
					$query = 'index.php?post_type=' . $post_type_slug;

					// Append date parameters and match index
					$i = 1;
					foreach ( $date_rule['vars'] as $var ) {
						$query .= '&' . $var . '=' . $wp_rewrite->preg_index( $i );
						$i++; // last in loop will serve as next index feed and pagination queries below
					}

					// Base rule
					$archive_slug = ! empty( $post_type->rewrite['slug'] ) ? $post_type->rewrite['slug'] : $post_type->name; // use rewrite slug if provided; otherwise post type slug
					$rule = $archive_slug . '/'. $date_rule['rule'];
					
					// Date URL
					$rules[$rule . '/?$' ] = $query;
					
					// Feed URLs
					$rules[$rule . '/feed/(feed|rdf|rss|rss2|atom)/?$' ] = $query . '&feed=' . $wp_rewrite->preg_index( $i );
					$rules[$rule . '/(feed|rdf|rss|rss2|atom)/?$' ] = $query . '&feed=' . $wp_rewrite->preg_index( $i );
					
					// Paginated URLs
					$rules[$rule . '/page/([0-9]{1,})/?$' ] = $query . '&paged=' . $wp_rewrite->preg_index( $i );
					
				}
				
			}
			
		}

	}

	// Apply the rules for given post types
	if ( ! empty( $rules ) ) {
		$wp_rewrite->rules = array_merge( $rules, $wp_rewrite->rules );
	}

}

/**
 * Get permalink for post type month archive
 *
 * Modified version of WordPress core get_month_link() with post type argument.
 *
 * @since 0.9
 * @global object $wp_rewrite
 * @param int $year Four digit year
 * @param int $month Numeric month
 * @param string $post_type Post type to build link for
 * @return string Permalink for date archive
 */
function ctfw_post_type_get_month_link( $year, $month, $post_type = false ) {

	global $wp_rewrite;

	if ( ! $year ) {
		$year = gmdate( 'Y', current_time( 'timestamp' ) );
	}

	if ( ! $month ) {
		$month = gmdate( 'm', current_time( 'timestamp' ) );
	}

	$monthlink = $wp_rewrite->get_month_permastruct();

	if ( ! empty( $monthlink ) ) { // using pretty permalinks

		// Get rewrite slug for post type
		$slug = '';
		if ( ! empty( $post_type ) ) {
			$post_type_object = get_post_type_object( $post_type );
			if ( isset( $post_type_object->rewrite['slug'] ) ) {
				$slug = $post_type_object->rewrite['slug'];
			}
		}

		$monthlink = str_replace( '%year%', $year, $monthlink );
		$monthlink = str_replace( '%monthnum%', zeroise( intval( $month ), 2 ), $monthlink );

		return apply_filters( 'ctfw_post_type_month_link', home_url( $slug . user_trailingslashit( $monthlink, 'month' ) ), $year, $month );

	} else { // default with query string

		$post_type_param = '';
		if ( 'post' != $post_type ) { // not necessary for default post type
			$post_type_param = '&post_type=' . $post_type;
		}

		return apply_filters( 'ctfw_post_type_month_link', home_url( '?m=' . $year . zeroise( $month, 2 ) . $post_type_param ), $year, $month );

	}

}

/**********************************
 * REDIRECTION
 **********************************/

/**
 * Redirect post type archives to pages
 *
 * Use add_theme_support( 'ctfw-archive-redirection' ) to redirect post type archives to pages using specific page templates.
 * Post types and page templates from ctfw_content_types() are used to automate this (theme must filter page templates in).
 *
 * Page template should output same loop but with with title, featured image, etc. for nicer presentation and to avoid duplicate content.
 * This is done only for non-date archive. Feeds are unaffected.
 *
 * @since 0.9
 */
function ctfw_redirect_archives_to_pages() {

	// Theme supports this?
	if ( ! current_theme_supports( 'ctfw-archive-redirection' ) ) {
		return false;
	}

	// Run only on post type archive, but not date archive or feed
	if ( ! is_post_type_archive() || is_year() || is_month() || is_day() || is_feed() )  {
		return false;
	}

	// Get content types
	$content_types = ctfw_content_types();

	// Loop content types
	foreach ( $content_types as $content_type => $content_type_data ) {

		// Get primary template for content type (first in array)
		$page_template = ! empty( $content_type_data['page_templates'][0] ) ? $content_type_data['page_templates'][0] : false;

		// Have page template
		if ( $page_template ) {

			// Get post type(s) for content type (probably just one)
			$post_types = $content_type_data['post_types'];

			// Have post types
			if ( ! empty( $post_types ) ) {

				// Loop post types
				foreach ( $post_types as $post_type ) {

					// Have post type
					if ( ! empty( $post_type ) ) {

						// Only if archive is for specific post type
						if ( is_post_type_archive( $post_type ) ) {

							// Check if a page is using primary template
							if ( $redirect_page = ctfw_get_page_by_template( $page_template ) ) {

								// Found a page?
								if ( ! empty( $redirect_page->ID ) ) {

									// Get page data
									$post_type_obj = get_post_type_object( $post_type );

									// Don't redirect if URL is the same (post type and page have same slug); prevent infinite loop
									if ( $redirect_page->post_name != $post_type_obj->rewrite['slug'] ) {

										// Get URL
										$page_url = get_permalink( $redirect_page->ID );

										// Go!
										wp_redirect( $page_url, 301 );
										exit;

									}

								}

							}

						}

					}

				}

			}

		}

	}

}

add_action( 'template_redirect', 'ctfw_redirect_archives_to_pages' );
