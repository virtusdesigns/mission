<?php
/**
 * Theme license and automatic updates
 *
 * For use with remote install of Easy Digital Downloads Software Licensing extension.
 * Integration is based on Pippin Williamson's sample theme for the extension.
 *
 * Add support for this framework feature like this:
 *
 *		add_theme_support( 'ctfw-edd-license', array(
 *  		'store_url'				=> 'yourstore.com',			// URL of store running EDD with Software Licensing extension
 *			'updates'				=> true,					// default true; enable automatic updates
 *			'options_page'			=> true,					// default true; provide options page for license entry/activaton
 *			'options_page_message'	=> '',						// optional message to show on options page
 *			'inactive_notice'		=> true,					// default true; show notice with link to license options page before license active
 *    	) );
 *
 * This default configuration assumes download's name in EDD is same as theme name.
 * See ctfw_edd_license_config() below for other arguments and their defaults.
 *
 * @package    Church_Theme_Framework
 * @subpackage Admin
 * @copyright  Copyright (c) 2013, churchthemes.com
 * @link       https://github.com/churchthemes/church-theme-framework
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 * @since      0.9
 */

// No direct access
if ( ! defined( 'ABSPATH' ) ) exit;

/*******************************************
 * CONFIGURATION
 *******************************************/

/**
 * License feature configuration
 *
 * Return arguments specified for licensing feature.
 * If no argument passed, whole array is returned.
 *
 * @since 0.9
 * @param string $arg Optional argument to retrieve
 * @return mixed Whole config array or single argument
 */
function ctfw_edd_license_config( $arg = false ) {

	$config = array();

	// Get theme support
	$support = get_theme_support( 'ctfw-edd-license' );
	if ( $support ) {

		// Get arguments
		$config = ! empty( $support[0] ) ? $support[0] : array();

		// Set defaults
		$config = wp_parse_args( $config, array(
			'store_url'				=> '',						// URL of store running EDD with Software Licensing extension
			'version'				=> CTFW_THEME_VERSION,		// default is to auto-determine from theme
			'license'				=> ctfw_edd_license_key(),	// default is to use '{theme}_license_key' option
			'item_name'				=> CTFW_THEME_NAME,			// default is to use theme name; must match download name in EDD
			'author'				=> CTFW_THEME_AUTHOR,		// default is to auto-determine from theme
			'updates'				=> true,					// default true; enable automatic updates
			'options_page'			=> true,					// default true; provide options page for license entry/activaton
			'options_page_message'	=> '',						// optional message to show on options page
			'inactive_notice'		=> true,					// default true; show notice with link to license options page before license active
		) );

		// Get specific argument?
		$config = isset( $config[$arg] ) ? $config[$arg] : $config;

	}

	// Return filtered
	return apply_filters( 'ctfw_edd_license_config', $config );

}

/*******************************************
 * AUTOMATIC UPDATES
 *******************************************/

/**
 * Theme updater
 *
 * @since 0.9
 */
function ctfw_edd_license_updater() {

	// Theme supports updates?
	if ( ctfw_edd_license_config( 'updates' ) ) {

		// Include updater class
		locate_template( CTFW_CLASS_DIR . '/CTFW_EDD_SL_Theme_Updater.php', true );

		// Activate updates
		$edd_updater = new CTFW_EDD_SL_Theme_Updater( array( 
			'remote_api_url' 	=> ctfw_edd_license_config( 'store_url' ), 		// Store URL running EDD with Software Licensing extension
			'version' 			=> ctfw_edd_license_config( 'version' ), 		// Current version of theme
			'license' 			=> ctfw_edd_license_key(), 						// The license key entered by user
			'item_name' 		=> ctfw_edd_license_config( 'item_name' ),		// The name of this theme
			'author'			=> ctfw_edd_license_config( 'author' )			// The author's name
		) );

	}

}

add_action( 'after_setup_theme', 'ctfw_edd_license_updater', 99 ); // after any use of add_theme_support() at 10

/*******************************************
 * OPTIONS DATA
 *******************************************/

/**
 * License key option name
 *
 * Specific to the current theme.
 *
 * @since 0.9
 * @param string $append Append string to base option name
 * @return string Option name
 */
function ctfw_edd_license_key_option( $append = '' ) {

	$field = CTFW_THEME_SLUG . '_license_key';

	if ( $append ) {
		$field .= '_' . ltrim( $append, '_' );
	}

	return apply_filters( 'ctfw_edd_license_key_option', $field, $append );

}

/**
 * License key value
 *
 * @since 0.9
 * @param string $append Append string to base option name
 * @return string Option value
 */
function ctfw_edd_license_key( $append = '' ) {

	$option = trim( get_option( ctfw_edd_license_key_option( $append ) ) );

	return apply_filters( 'ctfw_edd_license_key', $option, $append );

}

/**
 * License is locally active
 *
 * @since 0.9
 * @return bool True if active
 */
function ctfw_edd_license_active() {

	$active = false;

	if ( get_option( ctfw_edd_license_key_option( 'status' ) ) == 'active' ) {
		$active = true;
	}

	return apply_filters( 'ctfw_edd_license_active', $active );

}

/*******************************************
 * OPTIONS PAGE
 *******************************************/

/**
 * Add menu item and page
 *
 * @since 0.9
 */
function ctfw_edd_license_menu() {

	// Theme supports license options page?
	if ( ctfw_edd_license_config( 'options_page' ) ) {

		// Add menu item and page
		add_theme_page(
			_x( 'Theme License', 'page title', 'church-theme-framework' ),
			_x( 'Theme License', 'menu title', 'church-theme-framework' ),
			'manage_options',
			'theme-license',
			'ctfw_edd_license_page' // see below for output
		);

	}

}

add_action( 'admin_menu', 'ctfw_edd_license_menu' );

/**
 * Options page content
 *
 * @since 0.9
 */
function ctfw_edd_license_page() {

	$license 	= ctfw_edd_license_key();
	$status 	= ctfw_edd_license_key( 'status' ); // local status

	?>
	<div class="wrap">

		<?php screen_icon(); ?>

		<h2><?php _ex( 'Theme License', 'page title', 'church-theme-framework' ); ?></h2>

		<?php if ( $message = ctfw_edd_license_config( 'options_page_message' ) ) : ?>
		<p>
			<?php echo $message; ?>
		</p>
		<?php endif; ?>

		<form method="post" action="options.php">
		
			<?php settings_fields( 'ctfw_edd_license' ); ?>
			
			<?php wp_nonce_field( 'ctfw_edd_license_nonce', 'ctfw_edd_license_nonce' ); ?>

			<h3 class="title"><?php _ex( 'License Key', 'heading', 'church-theme-framework' ); ?></h3>

			<table class="form-table">

				<tbody>

					<tr valign="top">	

						<th scope="row" valign="top">
							<?php _e( 'License Key', 'church-theme-framework' ); ?>
						</th>

						<td>
							<input id="<?php echo esc_attr( ctfw_edd_license_key_option() ); ?>" name="<?php echo esc_attr( ctfw_edd_license_key_option() ); ?>" type="text" class="regular-text" value="<?php echo esc_attr( $license ); ?>" />
						</td>

					</tr>

				</tbody>

			</table>

			<?php submit_button( __( 'Save Key', 'church-theme-framework' ) ); ?>


			<?php if ( $license ) : ?>

			<h3 class="title"><?php _e( 'License Activation', 'church-theme-framework' ); ?></h3>

			<table class="form-table">

				<tbody>

					<tr valign="top">	

						<th scope="row" valign="top">
							<?php _e( 'License Status', 'church-theme-framework' ); ?>
						</th>

						<td>
							<?php if ( ctfw_edd_license_active() ) : ?>
								<span class="ctfw-license-active"><?php _ex( 'Active', 'license key', 'church-theme-framework' ); ?></span>
							<?php else : ?>
								<span class="ctfw-license-inactive"><?php _ex( 'Inactive', 'license key', 'church-theme-framework' ); ?></span>
							<?php endif; ?>
						</td>

					</tr>

				</tbody>

			</table>

			<p class="submit">
				<?php if ( ctfw_edd_license_active() ) : ?>
					<input type="submit" class="button button-primary" name="ctfw_edd_license_deactivate" value="<?php _e( 'Deactivate License', 'church-theme-framework' ); ?>" />
				<?php else : ?>
					<input type="submit" class="button button-primary" name="ctfw_edd_license_activate" value="<?php _e( 'Activate License', 'church-theme-framework' ); ?>" />
				<?php endif; ?>
			</p>

			<?php endif; ?>


		</form>

	</div>
	<?php
}

/**
 * Register option
 *
 * Create setting in options table
 *
 * @since 0.9
 */
function ctfw_edd_license_register_option() {

	// If theme supports it
	if ( ctfw_edd_license_config( 'options_page' ) ) {
		register_setting( 'ctfw_edd_license', ctfw_edd_license_key_option(), 'ctfw_edd_license_sanitize' );
	}

}

add_action( 'admin_init', 'ctfw_edd_license_register_option' );

/**
 * Sanitize license key
 *
 * Also unset local status if changing key,
 *
 * @since 0.9
 * @param string $new Key being saved
 * @return string Sanitized key
 */
function ctfw_edd_license_sanitize( $new ) {

	$old = ctfw_edd_license_key();

	// Unset local status as active when changing key -- need to activate new key
	if ( $old && $old != $new ) {
		delete_option( ctfw_edd_license_key_option( 'status' ) );
	}

	$new = trim( $new );

	return $new;

}

/**
 * Activate or deactivate license key
 *
 * @since 0.9
 */
function ctfw_edd_license_activation( ) {

	// Activate or Deactivate button clicked
	if ( isset( $_POST['ctfw_edd_license_activate'] ) || isset( $_POST['ctfw_edd_license_deactivate'] ) ) {

		// Security check
	 	if( ! check_admin_referer( 'ctfw_edd_license_nonce', 'ctfw_edd_license_nonce' ) ) {
			return;
		}

		// Activate or deactivate?
		$action = isset( $_POST['ctfw_edd_license_activate'] ) ? 'activate_license' : 'deactivate_license';

		// Call action via API
		if ( $license_data = ctfw_edd_license_action( $action ) ) {

			// If activated remotely, set local status; or set local status if was already active remotely -- keep in sync
			if ( 'activate_license' == $action ) {

				// Success
				if ( 'valid' == $license_data->license || 'valid' == ctfw_edd_license_check() ) {
					update_option( ctfw_edd_license_key_option( 'status' ), 'active' );
				}

				// Failure - note error for next page load
				else {
					set_transient( 'ctfw_edd_license_activation_result', 'fail', 15 ); // will be deleted after shown or in 15 seconds
				}

			}

			// If deactivated remotely, set local status; or set local status if was already inactive remotely -- keep in sync
			elseif ( 'deactivate_license' == $action && ( 'deactivated' == $license_data->license || 'inactive' == ctfw_edd_license_check() ) ) {
				delete_option( ctfw_edd_license_key_option( 'status' ) );
			}

		}

	}

}

add_action( 'admin_init', 'ctfw_edd_license_activation' );

/**
 * Show notice on activation failure
 *
 * @since 0.9
 */
function ctfw_edd_license_activation_failure_notice() {

	// Only on Theme License page
	$screen = get_current_screen();
	if ( 'appearance_page_theme-license' != $screen->base ) {
		return;
	}

	// Have a result transient?
	if ( $activation_result = get_transient( 'ctfw_edd_license_activation_result' ) ) {

		// Failed
		if ( 'fail' == $activation_result ) {

			?>
			<div id="ctfw-license-activation-error-notice" class="error">
				<p>
					<?php
					printf(
						__( '<b>License key could not be activated.</b> Read the <a href="%s" target="_blank">License Keys</a> guide for help.', 'church-theme-framework' ),
						'http://churchthemes.com/go/license-keys'
					);
					?>
				</p>
			</div>
			<?php

		}

		// Delete transient
		delete_transient( 'ctfw_edd_license_activation_result' );

	}

}

add_action( 'admin_notices', 'ctfw_edd_license_activation_failure_notice' );

/*******************************************
 * LICENSE NOTICE
 *******************************************/

/**
 * Show inactive license notice
 *
 * @since 0.9
 */
function ctfw_edd_license_notice() {

	// Theme supports this notice?
	if ( ! ctfw_edd_license_config( 'inactive_notice' ) ) {
		return;
	}

	// License is already locally active
	if ( ctfw_edd_license_active() ) {
		return;
	}

	// User can edit theme options?
	if ( ! current_user_can( 'edit_theme_options' ) ) {
		return;
	}

	// Show only on relevant pages as not to overwhelm the admin
	$screen = get_current_screen();
	if ( ! in_array( $screen->base, array( 'dashboard', 'themes', 'update-core' ) ) ) {
		return;
	}

	// Notice
	?>
	<div id="ctfw-license-notice" class="updated">
		<p>
			<?php
			printf(
				__( '<b>License Activation:</b> Please activate your <a href="%s">License Key</a> for the %s theme.', 'church-theme-framework' ),
				admin_url( 'themes.php?page=theme-license' ),
				CTFW_THEME_NAME
			);
			?>
		</p>
	</div>
	<?php

}

add_action( 'admin_notices', 'ctfw_edd_license_notice', 7 ); // higher priority than functionality plugin notice

/*******************************************
 * EDD API
 *******************************************/

/**
 * Call API with specific action
 *
 * https://easydigitaldownloads.com/docs/software-licensing-api/
 * activate_license, deactivate_license or check_license
 *
 * @since 0.9
 * @param string $action EDD API action: activate_license, deactivate_license or check_license
 * @return object License data from remote server
 */
function ctfw_edd_license_action( $action ) {

	$license_data = array();

	// Theme stores local option?
	if ( ctfw_edd_license_config( 'options_page' ) ) {

		// Valid action?
		$actions = array( 'activate_license', 'deactivate_license', 'check_license' );
		if ( in_array( $action, $actions ) ) {

			// Get license
			$license = ctfw_edd_license_key();

			// Have license
			if ( $license ) {

				// Data to send in API request
				$api_params = array( 
					'edd_action'	=> $action, 
					'license' 		=> $license, 
					'item_name'		=> urlencode( ctfw_edd_license_config( 'item_name' ) ) // name of download in EDD
				);

				// Call the API
				$response = wp_remote_get( add_query_arg( $api_params, ctfw_edd_license_config( 'store_url' ) ), array( 'timeout' => 15, 'sslverify' => false ) );

				// Got a valid response?
				if ( ! is_wp_error( $response ) ) {

					// Decode the license data
					$license_data = json_decode( wp_remote_retrieve_body( $response ) );

				}

			}

		}

	}

	return apply_filters( 'ctfw_edd_license_action', $license_data, $action );

}

/**
 * Check license key status
 *
 * Check if license is valid on remote end.
 *
 * @since 0.9
 * @return string Remote license status
 */
function ctfw_edd_license_check() {

	$status = '';

	// Call action via API
	if ( $license_data = ctfw_edd_license_action( 'check_license' ) ) {
		$status = $license_data->license;
	}

	return apply_filters( 'ctfw_edd_license_check', $status );

}

/**
 * Check for remote deactivation and update local
 *
 * It's handy to run this periodically in case license has been remotely deactivated.
 * Otherwise, they may think they are up to date when they are not.
 *
 * @since 0.9
 */
function ctfw_edd_license_check_deactivation() {

	// Theme stores local option?
	if ( ! ctfw_edd_license_config( 'options_page' ) ) {
		return;
	}

	// Only if locally active
	// Update: Do run always, because might be expired now
	//if ( ! ctfw_edd_license_active() ) { // already inactive locally
	//	return;
	//}

	// Check remote status
	$status = ctfw_edd_license_check();

	// Continue only if got a response
	if ( ! empty( $status ) ) { // don't do anything if times out

		// Deactivated remotely
		if ( in_array( $status, array( 'inactive', 'expired' ) ) ) { // status is not valid

			// Deactivate locally
			delete_option( ctfw_edd_license_key_option( 'status' ) );

		}

	}

}

/**
 * Run remote deactivation check automatically
 *
 * Check for remote deactivation periodically on relevant pages: Dashboard, Theme License, Themes, Updates
 *
 * @since 0.9
 */
function ctfw_edd_license_auto_check_deactivation() {

	// Admin only
	if ( ! is_admin() ) {
		return;
	}

	// Theme stores local option?
	if ( ! ctfw_edd_license_config( 'options_page' ) ) {
		return;
	}

	// Only in relevant areas
	$screen = get_current_screen();
	if ( in_array( $screen->base, array( 'dashboard', 'appearance_page_theme-license', 'themes', 'update-core' ) ) ) {

		// Has this been checked in last day?
		if ( ! get_transient( 'ctfw_edd_license_auto_check_deactivation' ) ) {

			// Check remote status and deactivate locally if necessary
			ctfw_edd_license_check_deactivation();

			// Set transient to prevent check until next day
			set_transient( 'ctfw_edd_license_auto_check_deactivation', true, DAY_IN_SECONDS );

		}

	}

}

add_action( 'current_screen', 'ctfw_edd_license_auto_check_deactivation' );
