<?php
/*-------------------------------------------------------*/
/* Run Theme Blvd framework (required)
/*-------------------------------------------------------*/

require_once( get_template_directory() . '/framework/themeblvd.php' );

/*-------------------------------------------------------*/
/* Start Child Theme
/*-------------------------------------------------------*/

include_once(STYLESHEETPATH . '/customlogin/custom-login.php');

add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );
function theme_enqueue_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
}

/*-------------------------------------------------------*/
/* Add Theme Options
/*-------------------------------------------------------*/
themeblvd_add_option_tab( 'church_content', 'Church Content' );


$churchcontent = 'Church Content Support';
$churchcontent_description = 'Here you can configure your options for displaying Church Content.';
$churchcontent_options = array(
    array(
        'name'      => 'Enable Sermons',
        'desc'      => 'Select whether you\'d like to enable support for Church Themes Sermons.',
        'id'        => 'churchcontent_sermons',
        'std'       => 0,
        'type'      => 'checkbox',
    ),
    array(
        'name'      => 'Enable People',
        'desc'      => 'Select whether you\'d like to enable support for Church Themes People.',
        'id'        => 'churchcontent_people',
        'std'       => 0,
        'type'      => 'checkbox',
    ),
    array(
        'name'      => 'Enable Locations',
        'desc'      => 'Select whether you\'d like to enable support for Church Themes Locations.',
        'id'        => 'churchcontent_locations',
        'std'       => 0,
        'type'      => 'checkbox',
    ),
     array(
        'name'      => 'Enable Events',
        'desc'      => 'Select whether you\'d like to enable support for Church Themes Events.',
        'id'        => 'churchcontent_events',
        'std'       => 0,
        'type'      => 'checkbox',
    ),
    array(
        'name'      => 'Staff Groups',
        'desc'      => 'Split up Staff page into groups.',
        'id'        => 'staff_groups',
        'std'       => 0,
        'type'      => 'checkbox',
    ),
);
themeblvd_add_option_section( 'church_content', 'churchcontent', $churchcontent, $churchcontent_description, $churchcontent_options );







function category_featured_img(){
    
    $categoryimg = hmk_taxonomy_image_url();
    
    if (function_exists('hmk_taxonomy_image_url')) {
    
	    if (is_tax()) {
	    
		    echo '<div id="category-image">';
		    
		    echo '<img src="'.$categoryimg.'" height="auto" width="100%" alt="" />';
		    
		    echo '</div>';
	    
	    }
    
    }
      
}
add_action('themeblvd_header_after', 'category_featured_img');



// files from forgiven




// Initial Load
require('_framework/init.php');

// Add theme support for post thumbnails & post formats
//require('_theme_settings/add-theme-support.php');

// Register Sidebars
//require('_theme_settings/register-sidebars.php');

// Register widgets
require('_theme_settings/widgets/init.php');

// Theme related functions
require('_theme_settings/theme-functions.php');

// Set up custom meta fields
require('_theme_settings/custom-fields/init.php');

// Shortcodes
//require('_theme_settings/theme-shortcodes.php');

// Load the styles and assets if on the OT pane
// global $pagenow;
// if (isset($_GET['page']) && $_GET['page'] != 'ot-theme-options' || !isset($_GET['page'])) {
//     function ot_admin_styles() { /* Block the styles from loading anywhere but the admin page */ }
// }

// Church Theme Content Framework
if (class_exists('Church_Theme_Content')):


	// Church Theme Content Framework
	require(get_stylesheet_directory() . '/_ctc_framework/framework.php');

	function forgiven_add_ctc_support() {
		add_theme_support('church-theme-content');
	
	 	if (themeblvd_get_option( 'churchcontent_sermons')) {add_theme_support('ctc-sermons');}
	 	if (themeblvd_get_option( 'churchcontent_people')) {add_theme_support('ctc-people');}
	 	if (themeblvd_get_option( 'churchcontent_locations')) {add_theme_support('ctc-locations');}
	 	if (themeblvd_get_option( 'churchcontent_events')) {add_theme_support('ctc-events');}
	 	if (!is_multisite()) { add_theme_support('ctfw-force-downloads'); }
	}
	 
	add_action( 'after_setup_theme', 'forgiven_add_ctc_support', 1001);
	
endif;


// Envira Gallery Activation
// add_action( 'after_setup_theme', 'tgm_envira_define_license_key' );
// function tgm_envira_define_license_key() {
    
    // If the key has not already been defined, define it now.
//     if ( ! defined( 'ENVIRA_LICENSE_KEY' ) ) {
//         define( 'ENVIRA_LICENSE_KEY', '93b032dcb25f3564ff1814b3fd777efb' );
//     }
    
// }

// // Soliloquy License
// add_action( 'after_setup_theme', 'tgm_soliloquy_define_license_key' );
// function tgm_soliloquy_define_license_key() {
    
    // If the key has not already been defined, define it now.
//     if ( ! defined( 'SOLILOQUY_LICENSE_KEY' ) ) {
//         define( 'SOLILOQUY_LICENSE_KEY', '1dff474a33f27e4481a6716f13f77989' );
//     }
    
// }


// Visual Composer Theme Mode
// add_action( 'init', 'boxy_vcSetAsTheme' );
// function boxy_vcSetAsTheme() {
// 	if (function_exists('vc_set_as_theme')) : vc_set_as_theme(false); endif;
// }

// Slider Revolution Theme Mode
// add_action( 'init', 'boxy_revsliderSetAsTheme' );
// function boxy_revsliderSetAsTheme() {
// 	if (function_exists('set_revslider_as_theme')){ set_revslider_as_theme(); }
// }

// Option Tree Settings
// add_filter( 'ot_show_pages', '__return_false' );
// add_filter( 'ot_show_new_layout', '__return_false' );
// add_filter( 'ot_theme_mode', '__return_true' );
// load_template( trailingslashit( get_stylesheet_directory() ) . 'option-tree/ot-loader.php' );
// load_template( trailingslashit( get_stylesheet_directory() ) . '_theme_settings/theme-options.php' );

// // Live Composer Compatibility
// if ( ! function_exists( 'ot_get_media_post_ID' ) ) {
//   function ot_get_media_post_ID() {
//     global $wpdb;
//     return $wpdb->get_var( "SELECT ID FROM $wpdb->posts WHERE `post_name` = 'media' AND `post_type` = 'option-tree' AND `post_status` = 'private'" ); 
//   }
// }

// WooCommerce Titles
// if (isset($woocommerce)):
// 	add_filter('woocommerce_page_title','es_woo_title', 15);
// 	function es_woo_title( $page_title ){
// 		return '<span>'.$page_title.'</span>';
// 	}
// endif;

// if(function_exists('vc_set_as_theme')) vc_set_as_theme();







# Returns an array with terms titles and slugs
function forgiven_get_terms_slugs( $terms, $push_all = true ){

    if ( empty( $terms ) ){
        return;
    }

    if ( $push_all ) {
        $fixed = array( 'all' => __('All','forgiven') );
    }

    foreach ( $terms as $term ) {
        $fixed[ $term->slug ] = $term->name;
    }

    return $fixed;
}

# Returns an array with group titles and slugs
function forgiven_get_group_slugs( $terms, $push_all = true ){

    if ( empty( $terms ) ){
        return;
    }

    if ( $push_all ) {
        $fixed = array( 'all' => __('All','forgiven') );
    }

    foreach ( $terms as $term ) {
        $fixed[ $term->slug ]['name'] = $term->name;
        $fixed[ $term->slug ]['description'] = $term->description;
    }

    return $fixed;
}

# Create filter dropdown
function forgiven_render_dropdown( $terms, $arg_name, $label = '' ){
        
    $current_term = !empty( $_GET[ $arg_name ] ) ? $_GET[ $arg_name ] : '';

    if ( empty( $terms ) ){
        return;
    }

    if ( $label ){
        echo '<label>'. $label .'</label>';
    }

    echo '<select name="' . $arg_name . '">';
    foreach ( $terms as $slug => $title ) {
        echo '<option '. ( $slug == $current_term ? 'selected' : '' )  .' value="' . $slug . '">' . $title . '</option>';
    }
    echo '</select>';
}

# Generate tax_query
function forgiven_generate_tax_query( $term, $taxonomy ){
    if ( empty( $term ) || $term == 'all' ){
        return;
    }

    return array(
        'taxonomy' => $taxonomy,
        'field'    => 'slug',
        'terms'    => $term
    );
}



function ctc_person_new_label($args) {
	// the $fruits parameter is an array of all fruits from the pippin_show_fruits() function
 
	$args = array(
		'labels' => array(
		'name'	=> _x( 'People', 'post type general name', 'church-theme-content' ),
		'singular_name'	=> _x( 'Person', 'post type singular name', 'church-theme-content' ),
		'add_new' => _x( 'Add New', 'person', 'church-theme-content' ),
		'add_new_item' => __( 'Add Person', 'church-theme-content' ),
		'edit_item' => __( 'Edit Person', 'church-theme-content' ),
		'new_item' => __( 'New Person', 'church-theme-content' ),
		'all_items' => __( 'All People', 'church-theme-content' ),
		'view_item' => __( 'View Person', 'church-theme-content' ),
		'search_items' => __( 'Search People', 'church-theme-content' ),
		'not_found' => __( 'No people found', 'church-theme-content' ),
		'not_found_in_trash' => __( 'No people found in Trash', 'church-theme-content' )
		),
		'public' => true,
		'publicly_queryable'  => false,
		'has_archive' => true,
		'rewrite'	=> array(
			'slug' => 'people',
			'with_front' => false,
			'feeds'	=> true,
		),
		'supports' => array( 'title', 'editor', 'page-attributes', 'thumbnail', 'excerpt' ),
		'taxonomies' => array( 'ctc_person_group' ),
		'menu_icon'	=> 'dashicons-admin-users'
	);
 

	$args = array_merge($args, $args);
	
	return $args;
}
add_filter('ctc_post_type_person_args', 'ctc_person_new_label');



function ctc_sermon_new_label($args) {
	// the $fruits parameter is an array of all fruits from the pippin_show_fruits() function
 
	$args = array(
		'labels' => array(
			'name'	=> _x( 'Teachings', 'post type general name', 'church-theme-content' ),
			'singular_name'	=> _x( 'Teaching', 'post type singular name', 'church-theme-content' ),
			'add_new' => _x( 'Add New', 'teaching', 'church-theme-content' ),
			'add_new_item' => __( 'Add Teaching', 'church-theme-content' ),
			'edit_item' => __( 'Edit Teaching', 'church-theme-content' ),
			'new_item' => __( 'New Teaching', 'church-theme-content' ),
			'all_items' => __( 'All Teachings', 'church-theme-content' ),
			'view_item' => __( 'View Teaching', 'church-theme-content' ),
			'search_items' => __( 'Search Teaching', 'church-theme-content' ),
			'not_found' => __( 'No teachings found', 'church-theme-content' ),
			'not_found_in_trash' => __( 'No teachings found in Trash', 'church-theme-content' )
		),
		'public' => true,
		'has_archive' => true,
		'rewrite'	=> array(
			'slug' => 'teachings',
			'with_front' => false,
			'feeds'	=> 'teachings'
		),
		'supports' => array( 'title', 'editor', 'excerpt', 'publicize', 'thumbnail', 'comments', 'author', 'revisions' ), // 'editor' required for media upload button (see Meta Boxes note below about hiding)
		'taxonomies' => array( 'ctc_sermon_topic', 'ctc_sermon_book', 'ctc_sermon_series', 'ctc_sermon_speaker', 'ctc_sermon_tag' ),
		'menu_icon'	=> 'dashicons-video-alt3'
	);
 

	$args = array_merge($args, $args);
	
	return $args;
}
add_filter('ctc_post_type_sermon_args', 'ctc_sermon_new_label');




function ctc_sermon_new_taxonomy_topic_label($args) {
	// the $fruits parameter is an array of all fruits from the pippin_show_fruits() function
 
	$args = array(
		'labels' => array(
			'name' => _x( 'Teaching Topics', 'taxonomy general name', 'church-theme-content' ),
			'singular_name'	=> _x( 'Teaching Topic', 'taxonomy singular name', 'church-theme-content' ),
			'search_items' => _x( 'Search Topics', 'teachings', 'church-theme-content' ),
			'popular_items' => _x( 'Popular Topics', 'teachings', 'church-theme-content' ),
			'all_items' => _x( 'All Topics', 'teachings', 'church-theme-content' ),
			'parent_item' => null,
			'parent_item_colon' => null,
			'edit_item' => _x( 'Edit Topic', 'teachings', 'church-theme-content' ),
			'update_item' => _x( 'Update Topic', 'teachings', 'church-theme-content' ),
			'add_new_item' => _x( 'Add Topic', 'teachings', 'church-theme-content' ),
			'new_item_name' => _x( 'New Topic', 'teachings', 'church-theme-content' ),
			'separate_items_with_commas' => _x( 'Separate topics with commas', 'teachings', 'church-theme-content' ),
			'add_or_remove_items' => _x( 'Add or remove topics', 'teachings', 'church-theme-content' ),
			'choose_from_most_used' => _x( 'Choose from the most used topics', 'teachings', 'church-theme-content' ),
			'menu_name' => _x( 'Topics', 'teachings menu name', 'church-theme-content' )
		),
		'hierarchical'	=> true, // category-style instead of tag-style
		'public' => true,
		'rewrite' => array(
			'slug' => 'teaching-topic',
			'with_front' => false,
			'hierarchical' => true
		)
	);
 

	$args = array_merge($args, $args);
	
	return $args;
}
add_filter('ctc_taxonomy_sermon_topic_args', 'ctc_sermon_new_taxonomy_topic_label');


function ctc_sermon_new_taxonomy_book_label($args) {
	// the $fruits parameter is an array of all fruits from the pippin_show_fruits() function
 
	$args = array(
		'labels' => array(
			'name' => _x( 'Teaching Books', 'taxonomy general name', 'church-theme-content' ),
			'singular_name'	=> _x( 'Teaching Book', 'taxonomy singular name', 'church-theme-content' ),
			'search_items' => _x( 'Search Books', 'teachings', 'church-theme-content' ),
			'popular_items' => _x( 'Popular Books', 'teachings', 'church-theme-content' ),
			'all_items' => _x( 'All Books', 'teachings', 'church-theme-content' ),
			'parent_item' => null,
			'parent_item_colon' => null,
			'edit_item' => _x( 'Edit Book', 'teachings', 'church-theme-content' ),
			'update_item' => _x( 'Update Book', 'teachings', 'church-theme-content' ),
			'add_new_item' => _x( 'Add Book', 'teachings', 'church-theme-content' ),
			'new_item_name' => _x( 'New Book', 'teachings', 'church-theme-content' ),
			'separate_items_with_commas' => _x( 'Separate books with commas', 'teachings', 'church-theme-content' ),
			'add_or_remove_items' => _x( 'Add or remove books', 'teachings', 'church-theme-content' ),
			'choose_from_most_used' => _x( 'Choose from the most used books', 'teachings', 'church-theme-content' ),
			'menu_name' => _x( 'Books', 'teaching menu name', 'church-theme-content' )
		),
		'hierarchical'	=> true, // category-style instead of tag-style
		'public' => true,
		'rewrite' => array(
			'slug' => 'teaching-book',
			'with_front' => false,
			'hierarchical' => true
		)
	);
 

	$args = array_merge($args, $args);
	
	return $args;
}
add_filter('ctc_taxonomy_sermon_book_args', 'ctc_sermon_new_taxonomy_book_label');


function ctc_sermon_new_taxonomy_series_label($args) {
	// the $fruits parameter is an array of all fruits from the pippin_show_fruits() function
 
	$args = array(
		'labels' => array(
			'name' => _x( "Teaching Series", 'taxonomy general name', 'church-theme-content' ),
			'singular_name'	=> _x( "Teaching Series", 'taxonomy singular name', 'church-theme-content' ),
			'search_items' => _x( "Search Series", 'teachings', 'church-theme-content' ),
			'popular_items' => _x( "Popular Series", 'teachings', 'church-theme-content' ),
			'all_items' => _x( "All Series", 'teachings', 'church-theme-content' ),
			'parent_item' => null,
			'parent_item_colon' => null,
			'edit_item' => _x( 'Edit Series', 'teachings', 'church-theme-content' ),
			'update_item' => _x( 'Update Series', 'teachings', 'church-theme-content' ),
			'add_new_item' => _x( 'Add Series', 'teachings', 'church-theme-content' ),
			'new_item_name' => _x( 'New Series', 'teachings', 'church-theme-content' ),
			'separate_items_with_commas' => _x( "Separate series with commas", 'teachings', 'church-theme-content' ),
			'add_or_remove_items' => _x( "Add or remove series", 'teachings', 'church-theme-content' ),
			'choose_from_most_used' => _x( "Choose from the most used series", 'teachings', 'church-theme-content' ),
			'menu_name' => _x( "Series", 'teaching menu name', 'church-theme-content' )
		),
		'hierarchical'	=> true, // category-style instead of tag-style
		'public' => true,
		'rewrite' => array(
			'slug' => 'teaching-series',
			'with_front' => false,
			'hierarchical' => true
		)
	);
 

	$args = array_merge($args, $args);
	
	return $args;
}
add_filter('ctc_taxonomy_sermon_series_args', 'ctc_sermon_new_taxonomy_series_label');


function ctc_sermon_new_taxonomy_speaker_label($args) {
	// the $fruits parameter is an array of all fruits from the pippin_show_fruits() function
 
	$args = array(
		'labels' => array(
			'name' => _x( 'Teaching Speakers', 'taxonomy general name', 'church-theme-content' ),
			'singular_name'	=> _x( 'Teaching Speaker', 'taxonomy singular name', 'church-theme-content' ),
			'search_items' => _x( 'Search Speakers', 'teachings', 'church-theme-content' ),
			'popular_items' => _x( 'Popular Speakers', 'teachings', 'church-theme-content' ),
			'all_items' => _x( 'All Speakers', 'teachings', 'church-theme-content' ),
			'parent_item' => null,
			'parent_item_colon' => null,
			'edit_item' => _x( 'Edit Speaker', 'teachings', 'church-theme-content' ),
			'update_item' => _x( 'Update Speaker', 'teachings', 'church-theme-content' ),
			'add_new_item' => _x( 'Add Speaker', 'teachings', 'church-theme-content' ),
			'new_item_name' => _x( 'New Speaker', 'teachings', 'church-theme-content' ),
			'separate_items_with_commas' => _x( 'Separate speakers with commas', 'teachings', 'church-theme-content' ),
			'add_or_remove_items' => _x( 'Add or remove speakers', 'teachings', 'church-theme-content' ),
			'choose_from_most_used' => _x( 'Choose from the most used speakers', 'teachings', 'church-theme-content' ),
			'menu_name' => _x( 'Speakers', 'teaching menu name', 'church-theme-content' )
		),
		'hierarchical'	=> true, // category-style instead of tag-style
		'public' => true,
		'rewrite' => array(
			'slug' => 'teaching-speaker',
			'with_front' => false,
			'hierarchical' => true
		)
	);
 

	$args = array_merge($args, $args);
	
	return $args;
}
add_filter('ctc_taxonomy_sermon_speaker_args', 'ctc_sermon_new_taxonomy_speaker_label');



function ctc_sermon_new_taxonomy_tags_label($args) {
	// the $fruits parameter is an array of all fruits from the pippin_show_fruits() function
 
	$args = array(
		'labels' => array(
			'name' => _x( 'Teaching Tags', 'taxonomy general name', 'church-theme-content' ),
			'singular_name'	=> _x( 'Teaching Tag', 'taxonomy singular name', 'church-theme-content' ),
			'search_items' => _x( 'Search Tags', 'teachings', 'church-theme-content' ),
			'popular_items' => _x( 'Popular Tags', 'teachings', 'church-theme-content' ),
			'all_items' => _x( 'All Tags', 'teachings', 'church-theme-content' ),
			'parent_item' => null,
			'parent_item_colon' => null,
			'edit_item' => _x( 'Edit Tag', 'teachings', 'church-theme-content' ),
			'update_item' => _x( 'Update Tag', 'teachings', 'church-theme-content' ),
			'add_new_item' => _x( 'Add Tag', 'teachings', 'church-theme-content' ),
			'new_item_name' => _x( 'New Tag', 'teachings', 'church-theme-content' ),
			'separate_items_with_commas' => _x( 'Separate tags with commas', 'teachings', 'church-theme-content' ),
			'add_or_remove_items' => _x( 'Add or remove tags', 'teachings', 'church-theme-content' ),
			'choose_from_most_used' => _x( 'Choose from the most used tags', 'teachings', 'church-theme-content' ),
			'menu_name' => _x( 'Tags', 'teaching menu name', 'church-theme-content' )
		),
		'hierarchical'	=> false, // tag style instead of category style
		'public' => true,
		'rewrite' => array(
			'slug' => 'teaching-tag',
			'with_front'	=> false,
			'hierarchical' => true
		)
	);
 

	$args = array_merge($args, $args);
	
	return $args;
}
add_filter('ctc_taxonomy_sermon_tag_args', 'ctc_sermon_new_taxonomy_tags_label');