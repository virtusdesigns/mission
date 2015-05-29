<?php
/**
 * Localization Functions
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

/**
 * Load Theme Textdomain
 *
 * Language file should go in wp-content/languages/themes/textdomain-locale.mo.
 * There is no option for using languages folder in theme, because this is dangerous.
 * This folder is only for storing the .pot file and any pre-made translations.
 * It is absolutely best to keep it outside of theme.
 * 
 * See http://core.trac.wordpress.org/changeset/22346
 * 
 * @since 0.9
 */
function ctfw_load_theme_textdomain() {

	// Theme supports?
	if ( current_theme_supports( 'ctfw-load-translation' ) ) {

		// Textdomain same as theme's directory
		$textdomain = apply_filters( 'ctfw_theme_textdomain', CTFW_THEME_SLUG );

		// First, check for language file from the 'languages' folder in theme (recommended only for pre-made translations coming with theme)
		// Secondarily, load custom language file from outside the theme at wp-content/languages/themes/textdomain-locale.mo (safe from theme updates)
		load_theme_textdomain( $textdomain, CTFW_THEME_LANG_DIR );

	}

}

add_action( 'after_setup_theme', 'ctfw_load_theme_textdomain' );

/**
 * Use theme's translation file for framework text strings
 *
 * The framework's textdomain is 'church-theme-framework' while the theme has its own textdomain.
 * This makes it so one translation file (the theme's) can be used for both domains.
 *
 * Thank you to Justin Tadlock: https://github.com/justintadlock/hybrid-core/blob/master/functions/i18n.php
 * 
 * @since 0.9
 * @param string $translated Translated text
 * @param string $text Original text
 * @param string $domain Textdomain
 * @return string Modified translated string
 */
function ctfw_gettext( $translated, $text, $domain ) {

	// Theme supports?
	if ( current_theme_supports( 'ctfw-load-translation' ) ) {	

		// Framework textdomain?
		if ( 'church-theme-framework' == $domain ) {

			// Use theme's translation
			$translations = get_translations_for_domain( CTFW_THEME_SLUG ); // theme's directory name
			$translated = $translations->translate( $text );

		}

	}

	return $translated;

}

add_filter( 'gettext', 'ctfw_gettext', 1, 3 );
