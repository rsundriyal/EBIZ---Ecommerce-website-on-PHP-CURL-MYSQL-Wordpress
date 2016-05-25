jQuery(document).ready(function($) {
	// Chosen selects
	$( '.chosen-select' ).chosen({
		search_contains: true,
		display_selected_options: false,
		width: '100%'
	});

	// Select all/none
	$( '.chosen-select-all' ).click( function() {
		$(this).closest( 'td' ).find( 'select option' ).attr( 'selected', 'selected' );
		$(this).closest( 'td' ).find( 'select' ).trigger( 'chosen:updated' );
		return false;
	});

	$( '.chosen-select-none' ).click( function() {
		$(this).closest( 'td' ).find( 'select option' ).removeAttr( 'selected' );
		$(this).closest( 'td' ).find( 'select' ).trigger( 'chosen:updated' );
		return false;
	});
});