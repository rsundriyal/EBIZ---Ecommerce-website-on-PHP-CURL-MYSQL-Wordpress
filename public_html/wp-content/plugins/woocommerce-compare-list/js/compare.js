(function($) {
	$.fn.setDragCursor = function(dragging) {
		var cursor, coords = wccm.ie == 1 ? '' : ' 4 4';

		if (dragging) {
			cursor = wccm.gecko == 1 ? "-moz-grabbing" : "url(" + wccm.cursors + "closedhand.cur)" + coords + ", move";
			if (wccm.opera == 1) {
				cursor = "move";
			}
		} else {
			cursor = wccm.gecko == 1 ? "-moz-grab" : "url(" + wccm.cursors + "openhand.cur)" + coords + ", move";
		}

		return $(this).css('cursor', cursor);
	};

	$.fn.setDraggable = function() {
		var compares = $(this),
			html = $('html');

		compares.each(function() {
			var compare = $(this),
				tables = compare.find('.wccm-table'),
				wrappers = compare.find('.wccm-table-wrapper'),
				dragging = false,
				maxshift = wrappers.width() - tables.width(),
				offset = 0,
				shift = 0;

			$(window).resize(function() {
				maxshift = wrappers.width() - tables.width();
				if (maxshift < 0) {
					wrappers.setDragCursor();
				} else {
					wrappers.css('cursor', 'default');
					tables.css('margin-left', '0');
				}
			});

			if (maxshift < 0) {
				wrappers.setDragCursor();
				shift = parseInt(tables.css('margin-left'));
			}

			tables.mousedown(function(e) {
				var node = e.target.nodeName;

				if (maxshift < 0 && node != 'IMG' && node != 'A') {
					dragging = true;
					offset = e.screenX;
					shift = parseInt(tables.css('margin-left'));
					wrappers.setDragCursor(dragging);
				}
			});

			html.mouseup(function() {
				dragging = false;
				if (maxshift < 0) {
					wrappers.setDragCursor();
				}
			});

			html.mousemove(function(e) {
				var move = shift - (offset - e.screenX);
				if (dragging && maxshift <= move && move <= 0) {
					tables.css('margin-left', move + 'px');
				}
			});
		});

		return compares;
	};

	$(document).ready(function() {
		$('.wccm-compare-table').setDraggable();
	});
})(jQuery);