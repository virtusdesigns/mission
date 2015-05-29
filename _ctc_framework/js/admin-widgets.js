/**
 * Admin Widgets Page JavaScript
 */

jQuery( document ).ready( function( $ ) {

	/*******************************************
	 * IMAGE FIELD
	 *******************************************/

	// Choose Image
	$( 'body' ).on( 'click', '.ctfw-widget-image-choose', function( event ) {

		var value_container, frame;

		// Stop click to URL
		event.preventDefault();

		// Get field value container
		value_container = $( this ).parent( '.ctfw-widget-value' );

		// Media frame
		frame = wp.media( {
			title : ctfw_widgets.image_library_title,
			multiple : false,
			library : { type : 'image' },
			button : { text : ctfw_widgets.image_library_button }
		} );

		// Open media frame and set current image
		// This information was useful: http://bit.ly/13FATWB
		frame.on( 'open', function() {

			var image_id, current_attachment;

			image_id = $( '.ctfw-widget-image', value_container ).val();

			if ( image_id ) {
				current_attachment = wp.media.attachment( image_id );
				current_attachment.fetch();
				frame.state().get( 'selection' ).add( current_attachment );
			}

		} ).open(); // do open after binding

		// Set attachment ID and preview on click of "Use in Widget"
		// ( don't do on 'close' so user can cancel )
		frame.on( 'select', function() {

			var attachments, attachment, attachment_id, attachment_preview_url;

			// Get attachment data
			attachments = frame.state().get( 'selection' ).toJSON();
			attachment = attachments[0];

			// An image is selected
			if ( typeof attachment != 'undefined' ) {

				// Get attachment ID
				attachment_id = attachment.id;

				// Get medium size image for preview if exists
				attachment_preview_url = attachment.url; // use full if no medium
				if ( typeof attachment.sizes.medium != 'undefined' ) {
					attachment_preview_url = attachment.sizes.medium.url;
				}

				// Have attachment ID and preview image
				if ( attachment_id && attachment_preview_url ) {

					// Set attachment ID on hidden input
					$( '.ctfw-widget-image', value_container ).val( attachment_id );

					// Set image preview
					$( '.ctfw-widget-image-preview', value_container ).html( '<img src="' + attachment_preview_url + '" />' );

					// Set class on value container to tell image and remove button to show
					$( value_container )
						.removeClass( 'ctfw-widget-image-unset' )
						.addClass( 'ctfw-widget-image-set' );

				}

			}

		} );

	} );

	// Remove Image
	$( 'body' ).on( 'click', '.ctfw-widget-image-remove', function( event ) {

		var value_container;

		// Stop click to URL
		event.preventDefault();

		// Get field value container
		value_container = $( this ).parent( '.ctfw-widget-value' );

		// Set attachment ID on hidden input
		$( '.ctfw-widget-image', value_container ).val( '' );

		// Set image preview
		$( '.ctfw-widget-image-preview', value_container ).empty();

		// Set class on value container to tell image and remove button NOT to show
		$( value_container )
			.removeClass( 'ctfw-widget-image-set' )
			.addClass( 'ctfw-widget-image-unset' );

	} );

	/*******************************************
	 * RESTRICT WIDGETS/SIDEBARS
	 *******************************************/

	// Add hidden message to all widgets
	// admin-widgets.css hides this by default
	// admin_head outputs CSS to show this and hide form content
	if ( ctfw_widgets.widget_restrictions ) { // if feature supported
		$( '.widget-inside' ).prepend( '<div class="ctfw-widget-incompatible">' + ctfw_widgets.incompatible_message + '</div>' );
	}

} );