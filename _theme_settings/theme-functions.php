<?php

function get_absolute_file_url( $url ) {
	if( is_multisite() ) {
		global $blog_id;
		$upload_dir = wp_upload_dir();

		if( strpos( $upload_dir['basedir'], 'blogs.dir' ) !== false ) {
			$parts = explode( '/files/', $url );
			$url = network_home_url() . '/wp-content/blogs.dir/' . $blog_id . '/files/' . $parts[ 1 ];
		}
	}

	return $url;
}

function forgivenTruncate($string, $your_desired_width) {
  $parts = preg_split('/([\s\n\r]+)/', $string, null, PREG_SPLIT_DELIM_CAPTURE);
  $parts_count = count($parts);

  $length = 0;
  $last_part = 0;
  for (; $last_part < $parts_count; ++$last_part) {
    $length += strlen($parts[$last_part]);
    if ($length > $your_desired_width) { break; }
  }

  return strip_tags(implode(array_slice($parts, 0, $last_part)));
}


// ------------------------------------------------------------
// Load Stylesheets, Scripts & Customizations
function forgiven_theme_styles_scripts()  
{



	$template_dir = get_stylesheet_directory_uri();



	// jQuery, because of course.
	if (!is_admin()) {
		wp_enqueue_script('jquery');
	}

	wp_enqueue_style( 'slicknav', $template_dir . '/_theme_styles/slicknav.css', array(), '1.0', 'all' );
	wp_enqueue_style( 'font-awesome', $template_dir . '/_theme_styles/font-awesome/font-awesome.min.css', array(), '1.0', 'all' );
  	wp_enqueue_style( 'custom-stylesheet', get_bloginfo('stylesheet_url'), array(), '1.0', 'all' );
  	wp_enqueue_style( 'custom-transitions', $template_dir . '/_theme_styles/transitions.css', array(), '1.0', 'all' );
  	wp_enqueue_style( 'custom-responsive', $template_dir . '/_theme_styles/responsive.css', array(), '2.0', 'all' );
  	wp_enqueue_style( 'custom-magnific', $template_dir . '/_theme_styles/magnific.css', array(), '0.9.5', 'all' );
  	wp_enqueue_style( 'custom-google-fonts', 'http://fonts.googleapis.com/css?family='.$custom_font.':100,200,300,400,500,600,700,800&subset=latin,cyrillic-ext,cyrillic,greek-ext,vietnamese,latin-ext', array(), '1.0', 'all');
  	wp_enqueue_style( 'customized-styles', $template_dir . '/_theme_styles/custom.php?woo_button_color='.$woo_button_color.'&main_color='.$main_color.'&bg_color='.$background_color.'&bg_image='.$background_image.'&alt_color='.$footer_color.'&footer_bar_color='.$footer_bar_color.'&nav_color='.$nav_color.'&font='.$custom_font, array(), '1.0', 'all');
 
	// Scripts, to make it flow	
	wp_enqueue_script('html5',$template_dir . '/js/html5.js', array(),'1.0',false);
	wp_enqueue_script('custom-modernizr', $template_dir . '/js/modernizr.js', array(), '2.6.0', false);
	wp_enqueue_script('spin',$template_dir . '/js/spin.min.js', array(),'1.0',true);
	wp_enqueue_script('spin-jquery',$template_dir . '/js/spin.jquery.js', array(),'1.0',true);
	wp_enqueue_script('slicknav', $template_dir . '/js/jquery.slicknav.min.js', array(), '1.0', true);
	wp_enqueue_script('carouFredSel', $template_dir . '/js/jquery.carouFredSel-6.2.1-packed.js', array(), '1.0', true);
	wp_enqueue_script('collagePlus', $template_dir . '/js/jquery.collagePlus.min.js', array(), '1.0', true);
	wp_enqueue_script('collagePlusCaption', $template_dir . '/js/jquery.collageCaption.min.js', array(), '1.0', true);
	wp_enqueue_script('collagePlusWhitespace', $template_dir . '/js/jquery.removeWhitespace.min.js', array(), '1.0', true);
	wp_enqueue_script('easing', $template_dir . '/js/jquery.easing.js', array(), '1.0', true);
	wp_enqueue_script('custom-fitvids', $template_dir . '/js/fitvids.js', array(), '1.0', true);
	wp_enqueue_script('stackBoxBlur', $template_dir . '/js/StackBoxBlur.js', array(), '1.0', true);
	wp_enqueue_script('custom-magnific', $template_dir . '/js/magnific.js', array(), '0.9.5', true);
	wp_enqueue_script('blurSlider', $template_dir . '/js/jquery.blurSlider.js', array(), '1.0', true);
	wp_enqueue_script('jqueryPlugin',$template_dir . '/js/jquery_countdown/jquery.plugin.min.js', array(),'1.0.1',false);
	wp_enqueue_script('jqueryCountdown',$template_dir . '/js/jquery_countdown/jquery.countdown.min.js', array(),'2.0.1',false);
	if ($countdown_lang){
		wp_enqueue_script('jqueryCountdownLang',$template_dir . '/js/jquery_countdown/jquery.countdown-'.$countdown_lang.'.js', array(),'2.0.1',false);
	}
	wp_enqueue_script('customFunctions', $template_dir . '/js/jquery.main.js', array(), '1.0', true);

}
 
add_action('wp_enqueue_scripts', 'forgiven_theme_styles_scripts');




// ------------------------------------------------------------
// Add Thumbnails to Page/Post management screen

if ( !function_exists('AddThumbColumn') && function_exists('add_theme_support') ) {

    function AddThumbColumn($cols) {
        $cols['thumbnail'] = __('Featured Image','forgiven');
        return $cols;
    }
    function AddThumbValue($column_name, $post_id) {
        if ( 'thumbnail' == $column_name ) {
        
        	if (has_post_thumbnail( $post_id )) :
				$image_url = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), 'gallery-small' );
				if (is_array($image_url)) { $image_url = $image_url[0]; }
			endif;
        
            if ( isset($image_url) && $image_url ) {
                echo '<img style="border-radius:3px; margin:5px 0;" src="'.$image_url.'" width="100" />';
            } else {
                echo __('None','forgiven');
            }
            
        }
    }
    
    // for posts
    add_filter( 'manage_posts_columns', 'AddThumbColumn' );
    add_action( 'manage_posts_custom_column', 'AddThumbValue', 10, 2 );
    
    // for pages
    add_filter( 'manage_pages_columns', 'AddThumbColumn' );
    add_action( 'manage_pages_custom_column', 'AddThumbValue', 10, 2 );
    
}




// ------------------------------------------------------------
// Pagination

function js_get_pagination($args = null) {
	global $wp_query;
	
	$total_pages = $wp_query->max_num_pages;
	$big = 999999999; // need an unlikely integer
	
	if ($total_pages > 1){
	
		echo '<div id="pagination" class="clearfix">';
			echo paginate_links( array(
				'base' => @add_query_arg('paged','%#%'),
				'format' => '?paged=%#%',
				'current' => max( 1, get_query_var('paged') ),
				'total' => $wp_query->max_num_pages,
				'type' => 'list',
				'prev_text' => '&laquo;',
				'next_text' => '&raquo;',
			));
		echo '</div>';
	
	}
	
}
        



// ------------------------------------------------------------
// Breadcrumb Display

function js_breadcrumbs($post_id = ''){


	$hide_breadcrumbs = (is_array($hide_breadcrumbs) ? $hide_breadcrumbs[0] : false);
	
	if ($hide_breadcrumbs){
	
		// Don't show the breadcrumbs.
	
	} else {

		$breadcrumbs = '<p id="breadcrumbs"><a href="'.home_url().'">'.__('Home','forgiven').'</a>';
		
		if (is_page()){
		
			$ancestors = get_post_ancestors($post_id);
			$ancestors = array_reverse($ancestors);
			if (!empty($ancestors)){
				foreach($ancestors as $page_id){
					$breadcrumbs .= '&nbsp;&nbsp;/&nbsp;&nbsp;<a href="'.get_permalink($page_id).'">'.get_the_title($page_id).'</a>';
				}
			}
		
		} else if (is_search()){
		
			$breadcrumbs .= '&nbsp;&nbsp;/&nbsp;&nbsp;'.__('Search Results','forgiven');
		
		} else if ('ctc_sermon' == get_post_type()){
			
			if (is_tax()){ $breadcrumbs .= '&nbsp;&nbsp;/&nbsp;&nbsp;<a href="'.home_url().'/teachings/">'.__('Teachings','forgiven').'</a>'; } else
			if (is_archive()){ $breadcrumbs .= '&nbsp;&nbsp;/&nbsp;&nbsp;'.__('Teachings','forgiven'); } else {
			$breadcrumbs .= '&nbsp;&nbsp;/&nbsp;&nbsp;<a href="'.home_url().'/teachings/">'.__('Teachings','forgiven').'</a>'; }
							
		} else if (is_single()){
		
			if( get_option( 'show_on_front' ) == 'page' ):
				$blog_link = get_permalink( get_option('page_for_posts' ) );
			else :
				$blog_link = bloginfo('url');
			endif;
			$breadcrumbs .= '&nbsp;&nbsp;/&nbsp;&nbsp;<a href="'.$blog_link.'">'.__('Blog','forgiven').'</a>';
			
		} elseif (is_category()) {
		
			$breadcrumbs .= '&nbsp;&nbsp;/&nbsp;&nbsp;'.single_cat_title('',false);
			
		} elseif (is_month()) {
		
			$breadcrumbs .= '&nbsp;&nbsp;/&nbsp;&nbsp;'.__('Archive for','forgiven').' '.get_the_time('F, Y');

		} else if (is_year()) {
			
			$breadcrumbs .= '&nbsp;&nbsp;/&nbsp;&nbsp;'.__('Archive for','forgiven').' '.get_the_time('Y');

		} elseif (is_author()) {
		
			$breadcrumbs .= '&nbsp;&nbsp;/&nbsp;&nbsp;'.__('Author Archive','forgiven').': '.get_the_author();
		
		}
		
		if (!is_tax() && !is_archive() && !is_search()){
		
			$original_title = get_the_title($post_id);
			$shortened_title = substr(get_the_title($post_id), 0, 75);
			
			$orig_length = strlen($original_title);
			$new_length = strlen($shortened_title);
			
			$dots = ''; if ($new_length < $orig_length) { $dots = '...'; }
			
			$breadcrumbs .= '&nbsp;&nbsp;/&nbsp;&nbsp;'.$shortened_title.$dots.'</p>';
			
		} else if (is_tax()){ $breadcrumbs .= '&nbsp;&nbsp;/&nbsp;&nbsp;'.single_cat_title('',false).'</p>'; }
		
		echo $breadcrumbs;
		
	}
	
}




// Customize the WordPress Gallery Shortcode
add_filter( 'post_gallery', 'my_post_gallery', 10, 2 );
function my_post_gallery( $output, $attr) {
    global $post, $wp_locale;

    static $instance = 0;
    $instance++;

    // We're trusting author input, so let's at least make sure it looks like a valid orderby statement
    if ( isset( $attr['orderby'] ) ) {
        $attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );
        if ( !$attr['orderby'] )
            unset( $attr['orderby'] );
    }

    extract(shortcode_atts(array(
        'order'      => 'ASC',
        'orderby'    => 'menu_order ID',
        'id'         => $post->ID,
        'itemtag'    => 'dl',
        'icontag'    => 'dt',
        'captiontag' => 'dd',
        'columns'    => 3,
        'size'       => 'thumbnail',
        'include'    => '',
        'exclude'    => ''
    ), $attr));

    $id = intval($id);
    if ( 'RAND' == $order )
        $orderby = 'none';

    if ( !empty($include) ) {
        $include = preg_replace( '/[^0-9,]+/', '', $include );
        $_attachments = get_posts( array('include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );

        $attachments = array();
        foreach ( $_attachments as $key => $val ) {
            $attachments[$val->ID] = $_attachments[$key];
        }
    } elseif ( !empty($exclude) ) {
        $exclude = preg_replace( '/[^0-9,]+/', '', $exclude );
        $attachments = get_children( array('post_parent' => $id, 'exclude' => $exclude, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
    } else {
        $attachments = get_children( array('post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
    }

    if ( empty($attachments) )
        return '';

    if ( is_feed() ) {
        $output = "\n";
        foreach ( $attachments as $att_id => $attachment )
            $output .= wp_get_attachment_link($att_id, $size, true) . "\n";
        return $output;
    }

    $itemtag = tag_escape($itemtag);
    $captiontag = tag_escape($captiontag);
    $columns = intval($columns);
    $itemwidth = $columns > 0 ? floor(100/$columns) : 100;
    $float = is_rtl() ? 'right' : 'left';

    $selector = "gallery-{$instance}";

    $output = apply_filters('gallery_style', "
        <style type='text/css'>
            #{$selector} {
                margin: auto;
            }
            #{$selector} .gallery-item {
                float: {$float};
                margin-top: 10px;
                text-align: center;
                width: {$itemwidth}%;           }
            #{$selector} img {
                border: 2px solid #cfcfcf;
            }
            #{$selector} .gallery-caption {
                margin-left: 0;
            }
        </style>
        <!-- see gallery_shortcode() in wp-includes/media.php -->
        <div class='Collage'>");

    $i = 0;
    foreach ( $attachments as $id => $attachment ) {
        $image = wp_get_attachment_image($id,'gallery-thumb');
        $image_url = wp_get_attachment_url($id);
        $output .= "<div class='Image_Wrapper' data-caption='".($captiontag && trim($attachment->post_excerpt) ? wptexturize($attachment->post_excerpt) : "")."'><a title='" . wptexturize($attachment->post_excerpt) . "' href='$image_url'>$image";
        $output .= "</a></div>";
    }

    $output .= "</div>\n";

    return $output;
}




// ------------------------------------------------------------
// Misc Functions

	function relativeTime($ts)
	{
	    if(!ctype_digit($ts))
	        $ts = strtotime($ts);
	
	    $diff = time() - $ts;
	    if($diff == 0)
	        return __('now','forgiven');
	    elseif($diff > 0)
	    {
	        $day_diff = floor($diff / 86400);
	        if($day_diff == 0)
	        {
	            if($diff < 60) return  __('just now','forgiven');
	            if($diff < 120) return __('1 minute ago','forgiven');
	            if($diff < 3600) return floor($diff / 60).' '.__('minutes ago','forgiven');
	            if($diff < 7200) return '1 hour ago';
	            if($diff < 86400) return floor($diff / 3600).' '.__('hours ago','forgiven');
	        }
	        if($day_diff == 1) return __('Yesterday','forgiven');
	        if($day_diff < 7) return $day_diff.' '.__('days ago','forgiven');
	        if($day_diff < 31) return ceil($day_diff / 7).' '.__('weeks ago','forgiven');
	        if($day_diff < 60) return __('last month','forgiven');
	        return date_i18n(get_option('date_format'), $ts);
	    }
	    else
	    {
	        $diff = abs($diff);
	        $day_diff = floor($diff / 86400);
	        if($day_diff == 0)
	        {
	            if($diff < 120) return __('in a minute','forgiven');
	            if($diff < 3600) return __('in','forgiven').' '.floor($diff / 60).' '.__('minutes','forgiven');
	            if($diff < 7200) return __('in an hour','forgiven');
	            if($diff < 86400) return __('in','forgiven').' '.floor($diff / 3600).' '.__('hours','forgiven');
	        }
	        if($day_diff == 1) return __('Tomorrow','forgiven');
	        if($day_diff < 4) return date('l', $ts);
	        if($day_diff < 7 + (7 - date('w'))) return __('next week','forgiven');
	        if(ceil($day_diff / 7) < 4) return __('in','forgiven').' '.ceil($day_diff / 7).' '.__('weeks','forgiven');
	        if(date('n', $ts) == date('n') + 1) return __('next month','forgiven');
	        return date_i18n(get_option('date_format'), $ts);
	    }
	}

	function main_menu_message(){ echo '<span style="padding:15px 0 0; width:80%; display:block; position:relative; line-height:23px; text-align:left; font-size:15px; color:rgba(0,0,0,0.75);">Please <a style="color:#FFB351; text-decoration:underline;" href="'.home_url().'/wp-admin/nav-menus.php">create and set a menu</a> for the main navigation.</span>'; }
	
	// Fix <p>'s and <br>'s from showing up around shortcodes.
	//add_filter('the_content', 'js_empty_paragraph_fix');
	function js_empty_paragraph_fix($content)
	{   
	    $array = array ( '<p>[' => '[', ']</p>' => ']', ']<br />' => ']' );
	    $content = strtr($content, $array);
	    return $content;
	}
	
	function custom_excerpt($text) {
		$text = str_replace('[...]', '...', $text);
		return $text;
	}
	add_filter('get_the_excerpt', 'custom_excerpt');
	
	function js_char_shortalize($text, $length = 180, $append = '...') {
		$new_text = substr($text, 0, $length);
		if (strlen($text) > $length) {
			$new_text .= '...';
		}
		return $new_text;
	}
	
	function makeClickableLinks($text) {

		$text = str_replace(array('<','>'), array('&lt;','&gt;'),$text);
		return preg_replace('@(https?://([-\w\.]+)+(:\d+)?(/([\w/_\.-]*(\?\S+)?)?)?)@', '<a target="_blank" href="$1">$1</a>', $text);

	}
	
	function plural($num) {
		if ($num != 1)
			return "s";
	}
	
	class FORGIVENCustomNavigation extends Walker_Nav_Menu {
		
		function start_lvl( &$output, $depth = 0, $args = array() ) {
			$indent = str_repeat("\t", $depth);
			$output .= "\n$indent<section class=\"dropdown\"><ul>\n";
		}
		
		function end_lvl( &$output, $depth = 0, $args = array() ) {
			$indent = str_repeat("\t", $depth);
			$output .= "$indent</ul></section>\n";
		}
	
	}
	
	function get_page_ancestor($page_id) {
	    $page_obj = get_page($page_id);
	    while($page_obj->post_parent!=0) {
	        $page_obj = get_page($page_obj->post_parent);
	    }
	    return get_page($page_obj->ID);
	}

	
	
	

	
	/***********************************
	 * ICON FONT
	 ***********************************
	
	/**
	 * Get icon class
	 *
	 * Return icon class for specific element, for easy filtering to replace icons in specific areas.
	 *
	 * For social icons to filter, see forgiven_social_icon_map() below.
	 *
	 * @since 1.0
	 * @param string $element Element icon used with
	 * @return string Icon class
	 */
	function forgiven_get_icon_class( $element ) {
		
		// Elements and their classes
		$classes = array(
			'footer-phone'			=> 'el-icon-phone-alt',
			'footer-address'		=> 'el-icon-map-marker',
			'search-button'			=> 'el-icon-search', 		// top bar and widget
			'nav-left'				=> 'el-icon-arrow-left', 	// prev/next navigation
			'nav-right'				=> 'el-icon-arrow-right', 	// prev/next navigation
			'comments-link'			=> 'el-icon-comment', 		// "(icon) 5 Comments"
			'comment-reply'			=> 'el-icon-comment-alt', 	// "Reply" button on comment
			'comment-edit'			=> 'el-icon-edit', 			// "Edit" button on comment
			'edit-post'				=> 'el-icon-edit',			// edit button for any post type
			'gallery'				=> 'el-icon-camera',
			'quote'					=> 'el-icon-quotes-alt',
			'quote-link'			=> 'el-icon-share-alt',
			'chat'					=> 'el-icon-comment-alt',
			'link'					=> 'el-icon-share-alt',
			'image'					=> 'el-icon-photo',
			'entry-date'			=> 'el-icon-calendar',
			'entry-byline'			=> 'el-icon-user',
			'entry-parent'			=> 'el-icon-paper-clip',
			'entry-category'		=> 'el-icon-folder-open',
			'entry-tag'				=> 'el-icon-tags',
			'download'				=> 'el-icon-download', 	// generic download
			'read'					=> 'el-icon-book', 		// sermon
			'video-play'			=> 'el-icon-video',		// sermon
			'audio-play'			=> 'el-icon-headphones', // sermon
			'video-download'		=> 'el-icon-download', 	// sermon
			'audio-download'		=> 'el-icon-download', 	// sermon
			'pdf-download'			=> 'el-icon-download', 	// sermon
			'sermon-topic'			=> 'el-icon-folder-open',
			'sermon-book'			=> 'el-icon-book',
			'sermon-series'			=> 'el-icon-forward-alt',
			'sermon-speaker'		=> 'el-icon-mic',
			'event-date'			=> 'el-icon-calendar',
			'event-address'			=> 'el-icon-map-marker',
			'event-time'			=> 'el-icon-time',
			'event-directions'		=> 'el-icon-road',
			'event-venue'			=> 'el-icon-flag',
			'location-phone'		=> 'el-icon-phone-alt',
			'location-address'		=> 'el-icon-map-marker',
			'location-times'		=> 'el-icon-time',
			'location-directions'	=> 'el-icon-road',
			'person-position'		=> 'el-icon-adult',
			'person-phone'			=> 'el-icon-phone-alt',
			'person-email'			=> 'el-icon-envelope',
		);
	
		// Make array filterable
		$classes = apply_filters( 'forgiven_icon_classes', $classes, $element );
	
		// Get class for element
		$class = '';
		if ( ! empty( $classes[$element] ) ) {
			$class = $classes[$element];
		}
	
		// Return filterable
		return apply_filters( 'forgiven_get_icon_class', $class, $element );
	
	}
	
	/**
	 * Output icon class
	 *
	 * Output contents of forgiven_get_icon_class()
	 *
	 * @since 1.0
	 * @param string $element Element icon used with
	 * @param bool $return Whether or not to return (false echos)
	 * @return string If echoing class
	 */
	function forgiven_icon_class( $element, $return = false ) {
	
		$class = apply_filters( 'forgiven_icon_class', forgiven_get_icon_class( $element ) );
	
		if ( $return ) {
			return $class;
		} else {
			echo $class;
		}
	
	}
	
	/***********************************
	 * SOCIAL ICONS (Header/Footer)
	 ***********************************
	 
	/**
	 * Icons available
	 * 
	 * This is used in displaying icons with forgiven_social_icons() and
	 * to tell which social networks are supported with forgiven_social_icon_sites().
	 *
	 * @since 1.0
	 * @return array Icon map
	 */
	function forgiven_social_icon_map() {
	
		 // Social media sites with icons
		$icon_map = array(
	
			// CSS Class 							// Match in URL 	// Site Name
			'fa-facebook-square'		=> array(	'facebook',			'Facebook' ),
			'fa-twitter-square'			=> array(	'twitter',			'Twitter' ),
			'fa-google-plus-square'		=> array(	'plus.google',		'Google+' ),
			'fa-pinterest-square'		=> array( 	'pinterest',		'Pinterest' ),
			'fa-youtube-square'			=> array( 	'youtube',			'YouTube' ),
			'fa-vimeo-square'			=> array( 	'vimeo', 			'Vimeo' ),
			'fa-flickr'					=> array( 	'flickr',			'Flickr' ),
			'fa-instagram'				=> array( 	'instagram',		'Instagram' ),
			'fa-foursquare'				=> array( 	'foursquare',		'Foursquare' ),
			'fa-tumblr-square'			=> array( 	'tumblr',			'Tumblr' ),
			'fa-skype'					=> array( 	'skype', 			'Skype' ),
			'fa-linkedin-square'		=> array( 	'linkedin', 		'LinkedIn' ),
			'fa-github-alt'				=> array( 	'github',			'GitHub' ),
			'fa-dribbble'				=> array( 	'dribbble',			'Dribbble' ),
			'fa-microphone'				=> array( 	array( 'itunes', 'podcast' ),	'Podcast' ),
			'fa-rss-square'				=> array( 	array( 'rss', 'feed', 'atom' ), 'RSS' ),
			'fa-globe'					=> array( 	'http', 			'Website' ), // anything not matching the above will show a generic website icon
	
		);
	
		// Return filtered
		return apply_filters( 'forgiven_social_icon_map', $icon_map );
		
	}
	
	/**
	 * List of sites with icons
	 *
	 * Shown to user in Theme Customizer
	 *
	 * @since 1.0
	 * @param bool $or True to use "or"; otherwise "and"
	 * @return string List of sites with icons
	 */
	function forgiven_social_icon_sites( $or = false ) {
	
		$icon_map = forgiven_social_icon_map();
		
		$sites_with_icons = '';
		$sites_with_icons_count = count( $icon_map );
		
		$i = 0;
		
		foreach ( $icon_map as $site_data ) { // make list of sites with icons
		
			$i++;
			
			if ( $i > 1 ) { // not first one
				if ( $i < $sites_with_icons_count ) { // not last one
					$sites_with_icons .= _x( ', ', 'social icons list', 'forgiven' );
				} else { // last one
					if ( ! empty( $or ) ) {
						$sites_with_icons .= _x( ' or ', 'social icons list', 'forgiven' );
					} else {
						$sites_with_icons .= _x( ' and ', 'social icons list', 'forgiven' );					
					}
				}
			}
			
			$sites_with_icons .= $site_data[1];
	
		}
		
		return apply_filters( 'forgiven_social_icon_sites', $sites_with_icons );
	
	}
	
	/**
	 * Show icons
	 *
	 * @since 1.0
	 * @param array $urls URLs set in Customizer
	 * @param bool $return Return or echo
	 * @return string Icons HTML if not echoing
	 */
	function forgiven_social_icons( $urls, $return = false ) {
	
		$icon_list = '';
	
		// Social media URLs defined in Customizer
		if ( ! empty( $urls ) ) {
	
			// Available Icons
			$icon_map = forgiven_social_icon_map();
					
			// Loop URLs (in order entered by user) to build icon list
			$icon_items = '';
			$url_array = explode( "\n", $urls );
			foreach ( $url_array as $url ) {
	
				$url = trim( $url );
				
				// URL is valid
				if ( ! empty( $url ) && ( '[ctcom_rss_url]' == $url || preg_match( '/^(http(s*)):\/\/(.+)\.(.+)|skype:(.+)/i', $url ) ) ) { // basic URL check
				
					// Find matching icon
					foreach ( $icon_map as $icon_class => $site_data ) {
					
						$url_checks = (array) $site_data[0];
						$url_matched = false;
	
						foreach ( $url_checks as $url_match ) {
							if ( preg_match( '/' . preg_quote( $url_match ) . '/i', $url ) && ! $url_matched ) {
								$url_matched = true;
								$icon_items .= '<span><a href="' . esc_attr( $url ) . '" title="' . esc_attr( $site_data[1] ) . '" target="_blank"><i class="fa '.$icon_class.'"></i></a></span>' . "\n";				
							}
						}
						
						if ( $url_matched ) {
							break;
						}
						
					}
					
				}			
			
			}
	
			// Wrap with <ul> tags and apply shortcodes
			if ( ! empty( $icon_items ) ) {
				$icon_list .= do_shortcode( $icon_items ); // for [ctcom_rss_url]
			}
		
		}
		
		// Echo or return filtered
		$icon_list = apply_filters( 'forgiven_social_icons', $icon_list, $urls );
		if ( $return ) {
			return $icon_list;
		} else {
			echo $icon_list;
		}
		
	}
	
	function forgiven_socials_search(){
	
		// Get Social Links
		$socials = array();
		$socials['facebook'] = ot_get_option('facebook');
		$socials['soundcloud'] = ot_get_option('soundcloud');
		$socials['twitter'] = ot_get_option('twitter');
		$socials['googleplus'] = ot_get_option('googleplus');
		$socials['linkedin'] = ot_get_option('linkedin');
		$socials['instagram'] = ot_get_option('instagram');
		$socials['pinterest'] = ot_get_option('pinterest');
		$socials['vimeo'] = ot_get_option('vimeo');
		$socials['youtube'] = ot_get_option('youtube');
		$socials['feed'] = ot_get_option('feed');
		$activate_search = ot_get_option('activate_search');
		
		if (!empty($socials)):
			echo ($socials['facebook'] ? '<a target="_blank" href="'.$socials['facebook'].'" class="social"><i class="fa fa-facebook-square"></i></a>' : '');
			echo ($socials['twitter'] ? '<a target="_blank" href="'.$socials['twitter'].'" class="social"><i class="fa fa-twitter-square"></i></a>' : '');
			echo ($socials['googleplus'] ? '<a target="_blank" href="'.$socials['googleplus'].'" class="social"><i class="fa fa-google-plus-square"></i></a>' : '');
			echo ($socials['linkedin'] ? '<a target="_blank" href="'.$socials['linkedin'].'" class="social"><i class="fa fa-linkedin-square"></i></a>' : '');
			echo ($socials['vimeo'] ? '<a target="_blank" href="'.$socials['vimeo'].'" class="social"><i class="fa fa-vimeo-square"></i></a>' : '');	
			echo ($socials['youtube'] ? '<a target="_blank" href="'.$socials['youtube'].'" class="social"><i class="fa fa-youtube-square"></i></a>' : '');
			echo ($socials['instagram'] ? '<a target="_blank" href="'.$socials['instagram'].'" class="social"><i class="fa fa-instagram"></i></a>' : '');
			echo ($socials['pinterest'] ? '<a target="_blank" href="'.$socials['pinterest'].'" class="social"><i class="fa fa-pinterest-square"></i></a>' : '');
			echo ($socials['feed'] ? '<a href="'.$socials['feed'].'" class="social"><i class="fa fa-rss-square"></i></a>' : '');
			echo ($socials['soundcloud'] ? '<a target="_blank" href="'.$socials['soundcloud'].'" class="social" style="font-size:22px; width:41px;"><i class="fa fa-soundcloud"></i></a>' : '');
		endif;
		
		if ($activate_search):
	
			?><div class="search">
				<form action="<?php echo home_url(); ?>/" method="get">
					<input type="text" class="field" name="s" value="<?php _e('Search','forgiven'); ?>..." title="<?php _e('Search','forgiven'); ?>..." />
					<input type="submit" value="<?php _e('Go','forgiven'); ?>" />
				</form>
				<i class="fa fa-search"></i>
			</div><?php
		
		endif;
		
	}
	



// End Misc Functions
// ------------------------------------------------------------

?>