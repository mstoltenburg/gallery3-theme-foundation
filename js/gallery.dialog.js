(function($) {
	'use strict';

	$.widget("ui.gallery_dialog", {
		options: {
			autoOpen: false,
			autoResize: true,
			modal: true,
			resizable: false,
			position: "center"
		},
		_create: function() {
			var self = this;
			if (!self.options.immediate) {
				this.element.click(function(event) {
					event.preventDefault();
					self._show($(event.currentTarget).attr("href"));
					return false;
				});
			} else {
				self._show(this.element.attr("href"));
			}
		},

		_show: function(sHref) {
			var self = this;
			var eDialog = '<div id="g-dialog" class="reveal-modal"></div>';

			if ($("#g-dialog").length) {
				$("#g-dialog").html();
			} else {
				$("body").append(eDialog);
			}

			if (!self.options.close) {
				self.options.close = self.close_dialog;
			}
			// $("#g-dialog").dialog(self.options);

			$("#g-dialog").gallery_show_loading();

			$.ajax({
				url: sHref,
				type: "GET",
				success: function(data, textStatus, xhr) {
					var mimeType = /^(\w+\/\w+)\;?/.exec(xhr.getResponseHeader("Content-Type"));

					var content = "";
					if (mimeType[1] == "application/json") {
						content = unescape(data.html);
					} else {
						content = data;
					}

					$("#g-dialog").html(content).gallery_show_loading();

					if ($("#g-dialog form").length) {
						self.form_loaded(null, $("#g-dialog form"));
					}
					self._layout();

					// $("#g-dialog").dialog("open");
					$("#g-dialog").append('<a class="close-reveal-modal">&#215;</a>');
					$("#g-dialog").foundation("reveal", "open");
					self._set_title();

					if ($("#g-dialog form").length) {
						self._ajaxify_dialog();
					}
				}
			});
			// $("#g-dialog").dialog("option", "self", self);
		},

		error: function(xhr, textStatus, errorThrown) {
			$("#g-dialog").html(xhr.responseText);
			self._set_title();
			self._layout();
		},

		_layout: function() {
			var dialogClass;
			var dialogHeight = $("#g-dialog").height();
			var childWidth = $("#g-dialog form").width();
			var size = $.gallery_get_viewport_size();
			if ($("#g-dialog iframe").length) {
				dialogClass = "expand";
				// Set the iframe width and height
				$("#g-dialog iframe").width("100%").height(size.height() - 100);
			} else if ($("#g-dialog .g-dialog-panel").length) {
				dialogClass = "expand";
				$("#g-dialog").height(size.height() - 100);
			} else if (childWidth <= 150 || childWidth > 300) {
				dialogClass = "small";
			} else {
				dialogClass = "small";
			}

			$("#g-dialog").addClass(dialogClass);
		},

		form_loaded: function(event, ui) {
			// Should be defined (and localized) in the theme
			MSG_CANCEL = MSG_CANCEL || 'Cancel';
			var eCancel = '<button class="g-cancel ui-state-default ui-corner-all">' + MSG_CANCEL + '</button>';
			if ($("#g-dialog .submit").length) {
				$("#g-dialog .submit").addClass("ui-state-default ui-corner-all");
				$("#g-dialog .submit").parent().append(eCancel);
				$.fn.gallery_hover_init();
				$("#g-dialog .g-cancel").click(function(event) {
					$("#g-dialog").foundation("reveal", "close");
					event.preventDefault();
				});
			 }
			$("#g-dialog .ui-state-default").hover(
				function() {
					$(this).addClass("ui-state-hover");
				},
				function() {
					$(this).removeClass("ui-state-hover");
				}
			);
		},

		close_dialog: function(event, ui) {
			// var self = $("#g-dialog").dialog("option", "self");
			// if ($("#g-dialog form").length) {
			// 	self._trigger("form_closing", null, $("#g-dialog form"));
			// }
			// self._trigger("dialog_closing", null, $("#g-dialog"));
			$("#g-dialog").foundation("reveal", "close");
		},

		_ajaxify_dialog: function() {
			var self = this;
			$("#g-dialog form").ajaxForm({
				dataType: "json",
				beforeSubmit: function(formData, form, options) {
					form.find(":submit")
						.addClass("ui-state-disabled")
						.attr("disabled", "disabled");
					return true;
				},
				success: function(data) {
					if (data.html) {
						$("#g-dialog").html(data.html);
						// $("#g-dialog").dialog("option", "position", "center");
						$("#g-dialog form :submit").removeClass("ui-state-disabled")
							.attr("disabled", null);
						self._set_title();
						self._ajaxify_dialog();
						self.form_loaded(null, $("#g-dialog form"));
						if (typeof data.reset == 'function') {
							eval(data.reset + '()');
						}
					}
					if (data.result == "success") {
						if (data.location) {
							window.location = data.location;
						} else {
							window.location.reload();
						}
					}
				},
				error: function(xhr, textStatus, errorThrown) {
					$("#g-dialog").html(xhr.responseText);
					self._set_title();
					self._layout();
				}
			});
		},

		_set_title: function() {
			// Remove titlebar for progress dialogs or set title
			if ($("#g-dialog #g-progress").length) {
				$(".ui-dialog-titlebar").remove();
			} else if ($("#g-dialog h1").length) {
				// $("#g-dialog").dialog('option', 'title', $("#g-dialog h1:eq(0)").html());
				// $("#g-dialog h1:eq(0)").hide();
			} else if ($("#g-dialog fieldset legend").length) {
				// $("#g-dialog").dialog('option', 'title', $("#g-dialog fieldset legend:eq(0)").html());
			}
			$(".ui-dialog-title").width('auto');
		},

		form_closing: function(event, ui) {},
		dialog_closing: function(event, ui) {}
	});
})(jQuery);
