/**
 * Initialize jQuery UI and Gallery Plugins
 */

(function ($) {
	'use strict';

	// Override gallery function
	$.fn.gallery_show_message = function() {
		return this.each(function(i){
			$(this).hide().append('<a href="#" class="close">&times;</a>').on("click", ".close", function(event) {
				event.preventDefault();
				$(this).parent().fadeOut(300, function () {
					$(this).parent().remove();
					// $(this).parent().slideUp(500);
				});
			}).fadeIn(1000);
		});
	};

	$.widget( "ui.dialog", $.ui.dialog, {

		_currentEvent: null,

		open: function() {
			var that = this;
			if ( this._isOpen ) {
				if ( this._moveToTop() ) {
					this._focusTabbable();
				}
				return;
			}

			this._isOpen = true;
			this.opener = $( this.document[0].activeElement );

			this._size();
			this._position();
			this._moveToTop( null, true );

			$(document).foundation("reveal", {
				// animationSpeed: 300,
				opened: function() {
					that._focusTabbable();
					that._trigger("focus");
				},
				closed: function() {
					that._trigger( "close", this._currentEvent );
					that.uiDialog.remove();
				}
			});

			this.uiDialogTitlebarClose.remove();
			// this._setOptions({
			// 	left: 'auto',
			// 	backgroundColor: 'red'
			// });
			this.uiDialog
				// .removeClass()
				.addClass("reveal-modal")
				.css({
					left: '50%',
					marginLeft: '-250px'
				})
				.append('<a class="close-reveal-modal">&#215;</a>')
				.foundation("reveal", "open");

			this._trigger("open");
		},

		close: function( event ) {
			var that = this;

			if ( !this._isOpen || this._trigger( "beforeClose", event ) === false ) {
				return;
			}

			this._isOpen = false;
			this._currentEvent = event;

			if ( !this.opener.filter(":focusable").focus().length ) {
				// Hiding a focused element doesn't trigger blur in WebKit
				// so in case we have nothing to focus on, explicitly blur the active element
				// https://bugs.webkit.org/show_bug.cgi?id=47182
				$( this.document[0].activeElement ).blur();
			}

			this.uiDialog.foundation("reveal", "close");
		}

	});

	$.widget( "ui.gallery_dialog", $.ui.gallery_dialog, {
		options: {
			closeOnEscape: true,
			draggable: true
		}
	});

})(jQuery);

$(document).ready(function() {
	'use strict';

	// Initialize status message effects
	$("#g-action-status li").gallery_show_message();

	// Initialize dialogs
	$(".g-dialog-link").gallery_dialog();

	// Initialize short forms
	$(".g-short-form").gallery_short_form();

	// Apply jQuery UI icon, hover, and rounded corner styles
	// $("input[type=submit]:not(.g-short-form input)").addClass("ui-state-default ui-corner-all");
	if ($("#g-view-menu").length) {
		$("#g-view-menu ul").removeClass("g-menu").removeClass("sf-menu");
		$("#g-view-menu a").addClass("ui-icon");
	}

/*
	// Apply jQuery UI icon and hover styles to context menus
	if ($(".g-context-menu").length) {
		$(".g-context-menu li").addClass("ui-state-default");
		$(".g-context-menu a").addClass("g-button ui-icon-left");
		$(".g-context-menu a").prepend("<span class=\"ui-icon\"></span>");
		$(".g-context-menu a span").each(function() {
			var iconClass = $(this).parent().attr("class").match(/ui-icon-.[^\s]+/).toString();
			$(this).addClass(iconClass);
		});
	}
*/

	// Remove titles for menu options since we're displaying that text anyway
//	$(".sf-menu a, .sf-menu li").removeAttr("title");

/*
	// Album and search results views
	if ($("#g-album-grid").length) {
		// Set equal height for album items and vertically align thumbnails/metadata
		$(".g-item").equal_heights().gallery_valign();
		// Store the resulting item height.  Storing this here for the whole grid as opposed to in the
		// hover event as an attr for each item is more efficient and ensures IE6-8 compatibility.
		 var item_height = $(".g-item").height();

		// Initialize thumbnail hover effect
		$(".g-item").hover(
			function() {
				// Insert a placeholder to hold the item's position in the grid
				var place_holder = $(this).clone().attr("id", "g-place-holder");
				$(this).after($(place_holder));
				// Style and position the hover item
				var position = $(this).position();
				$(this).css("top", position.top).css("left", position.left);
				$(this).addClass("g-hover-item");
				// Initialize the contextual menu. Note that putting it here delays execution until needed.
				$(this).gallery_context_menu();
				// Set the hover item's height.  Use "li a" on the context menu so we get the height of the
				// collapsed menu and avoid problems with incomplete slideUp/Down animations.
				$(this).height("auto");
				$(this).height(Math.max($(this).height(), item_height) +
				$(this).find(".g-context-menu li a").height());
			},
			function() {
				// Reset item height and position
				$(this).height(item_height);
				$(this).css("top", "").css("left", "");
				// Remove the placeholder and hover class from the item
				$(this).removeClass("g-hover-item");
				$("#g-place-holder").remove();
			}
		);

		// Realign any thumbnails that change so that when we rotate a thumb it stays centered.
		$(".g-item").bind("gallery.change", function() {
			$(".g-item").each(function() {
				$(this).height($(this).find("img").height() + 2);
			});
			$(".g-item").equal_heights().gallery_valign();
		});
	}
*/

	// Photo/Item item view
	if ($("#g-photo,#g-movie").length) {
		// Ensure the resized image fits within its container
		$("#g-photo,#g-movie").gallery_fit_photo();

		// Initialize context menus
		$("#g-photo,#g-movie").hover(function(){
			$(this).gallery_context_menu();
		});

		// Add scroll effect for links to named anchors
		$.localScroll({
			queue: true,
			duration: 1000,
			hash: true
		});

		$(this).find(".g-dialog-link").gallery_dialog();
		$(this).find(".g-ajax-link").gallery_ajax();
	}

	// Initialize button hover effect
	$.fn.gallery_hover_init();

});
