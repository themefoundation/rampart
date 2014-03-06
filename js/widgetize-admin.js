/**
 * Sets up widget page subnavigation
 *
 * @since			1.0
 */
function widgetizeSetupTabs( pageIDs ) {

	// Adds navigation tab for each post with widget areas
	jQuery.each( pageIDs, function(key, page){
		jQuery('.subsubsub').append('<li>| <a href="#" id="widget-tab-' + page.ID + '">' + page.post_title + '</a></li> ');
	});

	// Resets default widget visibility
	widgetizeResetTabs( pageIDs );

	jQuery('.subsubsub #default').click(function() {

		// Handles current tab classes
		jQuery('.subsubsub .current').removeClass('current');
		jQuery('.subsubsub #default').addClass('current');

		// Handles widget area visibility.
		jQuery('#widgets-right .widgets-holder-wrap').hide();
		widgetizeResetTabs( pageIDs );

	});
}

/**
 * Resets default widget visibility
 *
 * @since			1.0
 */
function widgetizeResetTabs( pageIDs ){

	// Shows the wrapper div.
	jQuery('.widgets-holder-wrap').show();

	// Hides custom widget areas and sets navigation functions.
	jQuery.each( pageIDs, function(key, page){
		jQuery('.sidebar-' + page.ID).hide();
		jQuery('#widget-tab-' + page.ID ).click(function() {
			switchWidgetAreas( page.ID );
		});
	});
}

/**
 * Switches visible widget areas
 *
 * @since			1.0
 */
function switchWidgetAreas( page_id ){

	// Handles current tab classes.
	jQuery('.subsubsub .current').removeClass('current');
	jQuery('.subsubsub #widget-tab-' + page_id).addClass('current');

	// Handles widget area visibility.
	jQuery('#widgets-right .widgets-holder-wrap').hide();
	jQuery('.sidebar-' + page_id).show();
}
