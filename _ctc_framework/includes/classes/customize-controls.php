<?php
/**
 * Theme Customizer Controls
 *
 * @package    Church_Theme_Framework
 * @subpackage Classes
 * @copyright  Copyright (c) 2013, churchthemes.com
 * @link       https://github.com/churchthemes/church-theme-framework
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 * @since      0.9
 */

// No direct access
if ( ! defined( 'ABSPATH' ) ) exit;

// Make sure customizer is registered
if ( class_exists( 'WP_Customize_Control' ) ) {

	/**
	 * Textarea control class
	 *
	 * @since 0.9
	 */
	class CTFW_Customize_Textarea_Control extends WP_Customize_Control {

		public $type = 'textarea';

		public function render_content() {
			
			// allow description to be placed here
			do_action( 'ctfw_customize_textarea_control_before' );
			do_action( 'ctfw_customize_textarea_control_before-' . $this->id );

			?>		
			<label>
				<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
				<textarea class="widefat" rows="5" <?php $this->link(); ?>><?php echo esc_textarea( $this->value() ); ?></textarea>
			</label>
			<?php
			
		}

	}

	/**
	 * Number control class
	 *
	 * @since 0.9
	 */
	class CTFW_Customize_Number_Control extends WP_Customize_Control {

		public $type = 'number';

		public function render_content() {

			?>		
			<label>
				<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
				<input type="number" size="2" step="1" min="0" <?php $this->link(); ?> value="<?php echo esc_attr( $this->value() ); ?>" />
			</label>
			<?php
			
		}

	}

	/**
	 * Extended background image class
	 *
	 * This adds a Presets tab (multiple) in place of the Default tab (single)
	 *
	 * @since 0.9
	 */
	class CTFW_Customize_Background_Image_Control extends WP_Customize_Background_Image_Control {

		/**
		 * Constructor
		 *
		 * @since 0.9
		 */
		public function __construct( $manager, $id = false, $args = array() ) {

			parent::__construct( $manager );

			// Presets array
			$this->presets = isset( $args['presets'] ) ? $args['presets'] : array();
			
			// Add presets tab (multiple)
			if ( $this->presets ) {
				$this->add_tab( 'ctfw_presets',  _x( 'Presets', 'customizer', 'church-theme-framework' ),  array( $this, 'tab_preset_backgrounds' ) );
			}
			
			// Remove "Default" tab - user can select first in presets
			$this->remove_tab( 'default' );
			
		}

		/**
		 * List multiple presets
		 *
		 * @since 0.9
		 */
		public function tab_preset_backgrounds() {
			
			foreach ( $this->presets as $file => $data ) {
			
				// Output mimics print_tab_image() output but adds preset data attributes

				$url = set_url_scheme( $data['url'] );
				$thumbnail_url = set_url_scheme( $data['thumb_url'] );
				
				?>
				<a href="#" class="thumbnail" <?php if ( $data['colorable'] ) : ?>data-customize-image-title="<?php _e( 'Colorable', 'church-theme-framework' ); ?>"<?php endif; ?>
					data-customize-image-value="<?php echo esc_url( $url ); ?>" 
					data-customize-image-preset-fullscreen="<?php echo esc_attr( $data['fullscreen'] ); ?>" 
					data-customize-image-preset-repeat="<?php echo esc_attr( $data['repeat'] ); ?>" 
					data-customize-image-preset-position="<?php echo esc_attr( $data['position'] ); ?>" 
					data-customize-image-preset-attachment="<?php echo esc_attr( $data['attachment'] ); ?>" 
					data-customize-image-preset-colorable="<?php echo esc_attr( $data['colorable'] ); ?>">
					<div class="ctfw-customizer-thumbnail-wrapper"><img src="<?php echo esc_url( $thumbnail_url ); ?>" /></div>
				</a>
				<?php
				
			}
			
		}

	}

}