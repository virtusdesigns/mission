<?php
/*-------------------------------------------------------*/
/* Run Theme Blvd framework (required)
/*-------------------------------------------------------*/

require_once( get_template_directory() . '/framework/themeblvd.php' );

/*-------------------------------------------------------*/
/* Start Child Theme
/*-------------------------------------------------------*/

add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );
function theme_enqueue_styles() {
    wp_enqueue_style( 'parent-style', get_stylesheet_directory_uri() . '/style.css' );

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
        'std'       => 'show',
        'type'      => 'radio',
        'options'   => array(
            'yes' => 'Yes, enable Sermons.',
            'no' => 'No, disable Sermons.'
        )
    ),
    array(
        'name'      => 'Enable People',
        'desc'      => 'Select whether you\'d like to enable support for Church Themes People.',
        'id'        => 'churchcontent_people',
        'std'       => 1,
        'type'      => 'checkbox',
    ),
    array(
        'name'      => 'Enable Locations',
        'desc'      => 'Select whether you\'d like to enable support for Church Themes Locations.',
        'id'        => 'churchcontent_locations',
        'std'       => 'show',
        'type'      => 'radio',
        'options'   => array(
            'yes' => 'Yes, enable Locations.',
            'no' => 'No, disable Locations.'
        )
    ),
    array(
        'name'      => 'Enable Locations',
        'desc'      => 'Select whether you\'d like to enable support for Church Themes Locations.',
        'id'        => 'churchcontent_background',
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





// files from forgiven




// Initial Load
require('_framework/init.php');

// Add theme support for post thumbnails & post formats
require('_theme_settings/add-theme-support.php');

// Register Sidebars
require('_theme_settings/register-sidebars.php');

// Register widgets
require('_theme_settings/widgets/init.php');

// Theme related functions
require('_theme_settings/theme-functions.php');

// Set up custom meta fields
//require('_theme_settings/custom-fields/init.php');

// Shortcodes
require('_theme_settings/theme-shortcodes.php');

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
	 	
	 	
	 	if (themeblvd_get_option( 'churchcontent_people')) {add_theme_support('ctc-people');}
	 	
	 	
if ( themeblvd_get_option('churchcontent_sermons') == 'yes' ) {
	add_theme_support('ctc-sermons');
}



	 	
	 	//add_theme_support( 'ctc-locations' );
	 	//add_theme_support( 'ctc-events' );
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