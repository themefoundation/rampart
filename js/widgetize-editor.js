
jQuery(document).ready(function($) {

	// Prepairs output variable
	var currentEdit = '';

	// Sets event listeners.
	setWidgetListeners();

	// Displays "Manage Widgets for this Page" button if widget areas exist.
	areaCount = $('#widgetize .row-actions-visible').length;
	if( 0 < areaCount) {
		$('#manage-widgets-button').removeClass('widgetize-is-hidden');
	}

	// Adds a new widget area to both the editing table and the JSON object.
	$('#add-widget-area').click(function() {

		// Removes previously hidden rows.
		$('.widget-area-deleted').remove();

		// Gets current json object.
		var obj = getWidgetJson();

		if( obj !== null ) {

			// Sets new widget area key
			var highestKey = $(obj).size();
			$.each( obj, function( key, value ) {
				if( key > highestKey ) {
					highestKey = key;
				}
			});
			highestKeyInt = parseInt( highestKey );
			newRow = highestKeyInt + 1;

			// Adds new widget area to json object.
			obj[ newRow ] = { "title":objectL10n.newWidgetAreaTitle, "classes":"" };
			setWidgetJson( obj );

			// Adds new row to meta box.
			newWidgetAreaEditor( newRow );

		} else {

			// Adds new widget area to json object.
			firstRow = { 1 : { 'title':objectL10n.newWidgetAreaTitle, "classes":"" } };
			setWidgetJson( firstRow );

			// Adds new row to meta box.
			newWidgetAreaEditor( '1' );

			// Removes .no-items message box.
			$('#widgetize .no-items').remove();

		}

		// Resets widget listeners to include new edit/delete links.
		setWidgetListeners();

		return false;
	});

	// Saves widget area changes.
	$('.inline-edit-save .save').click(function(event) {

		closeQuickEditor();

		// Gets new values from quick editor
		$(currentEdit).find('.column-title strong').html($('.edit-title').val());
		$(currentEdit).find('.column-classes').html($('.edit-classes').val());

		// Saves changes to json object.
		var obj = getWidgetJson();
		obj[ getWidgetAreaID( event.target.id ) ].title = $('.edit-title').val();
		obj[ getWidgetAreaID( event.target.id ) ].classes = $('.edit-classes').val();
		setWidgetJson( obj );

		return false;
	});

	// Cancels widget area changes.
	$('.inline-edit-save .cancel').click(function(event) {
		closeQuickEditor();
		return false;
	});

	/*
	 * Inserts a new row in the widget table
	 */
	function newWidgetAreaEditor( areaID ){
		$('<tr class="alternate"><td class="title column-title"><strong>' + objectL10n.newWidgetAreaTitle + '</strong> <div class="row-actions-visible"><span class="edit"><a href="#" id="edit-' + areaID + '" class="widget-area-edit">' + objectL10n.quickEdit + '</a> | </span><span class="delete"><a href="#" id="edit-' + areaID + '" class="widget-area-delete">' + objectL10n.delete + '</a></span></div></td><td class="classes column-classes"></td></tr>').appendTo($('#the-list'));
		$('#edit-' + areaID).parents('tr').hide().css('visibility', 'visible').fadeIn(1000);
	}

	/*
	 * Hides quick editor and displays original table row
	 */
	function closeQuickEditor( element ){
		$(currentEdit).show();
		$('.inline-edit-row').appendTo('#inlineedit');
	}

	/*
	 * Gets current JSON value
	 */
	function getWidgetJson(){
		return $.parseJSON($('#widgetize-json').val());
	}

	/*
	 * Sets new JSON value
	 */
	function setWidgetJson( obj ){
		rowsString = JSON.stringify( obj );
		if( rowsString == '{}' ) {
			rowsString = '';
		}
		$('#widgetize-json').val( rowsString );
	}

	/*
	 * Returns ID number that was attached to the end of the input string
	 */
	function getWidgetAreaID( str ) {
			arrayID = str.split('-');
			return arrayID[arrayID.length-1];
	}

	/*
	 * Resets quick edit form to original location
	 */
	function resetQuickEdit(){
		var divClass = $('#inlineedit').find('div').attr('class');
		if( typeof divClass === 'undefined') {
			$(currentEdit).show();
			$('.inline-edit-row').appendTo('#inlineedit');
		}
	}

	/*
	 * Sets event listeners for edit and delete links
	 */
	function setWidgetListeners(){

		// Displays the widget area editor.
		$('.widget-area-delete').click(function(event) {

			// Removes row from view.
			$(this).parents('tr').addClass('widget-area-deleted').fadeOut(500);

			// Removes widget area from json object.
			var obj = getWidgetJson();
			delete obj[ getWidgetAreaID( event.target.id ) ];
			setWidgetJson( obj );

			// Hides "Manage Widgets for this Page" button if no widget areas exist.
			obj = getWidgetJson();
			if( obj === null ) {
				$('#manage-widgets-button').addClass('widgetize-is-hidden');
			}

			return false;
		});

		// Displays the widget area quick editor.
		$('.widget-area-edit').click(function(event) {

			// Prepairs the quick editor.
			resetQuickEdit();

			// Adds input values to the quick editor.
			var key = getWidgetAreaID( event.target.id );
			var currentTitle = $(this).parents('tr').find('.column-title strong').html();
			var currentClasses = $(this).parents('tr').find('.column-classes').html();

			// Replaces widget row with quick editor.
			currentEdit = $(this).parents('tr');
			$('.inline-edit-row').insertAfter($(this).parents('tr')).css('display', 'table-row');
			$('.edit-title').val(currentTitle);
			$('.edit-classes').val(currentClasses);
			$('.inline-edit-save .save').attr('id', key);
			$(currentEdit).hide();

			return false;
		});
	}
});
