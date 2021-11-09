define([
	"jquery"
], function($) {
	"use strict";

	$.widget('topefekt.magesms', {
		options: {
			url: '',
			method: 'post',
			triggerEvent: 'change'
		},
		_create: function() {
			this._bind();
		},

		_bind: function() {
			var self = this;
			self.element.on(self.options.triggerEvent, function() {
				$('#magesms_load_filter').html('');
				if (!$(self.element).val()) {
					return;
				}
				self._ajaxSubmit();
			});
		},
		_ajaxSubmit: function() {
			var self = this;
			$.ajax({
				url: self.options.url,
				type: self.options.method,
				data: {name: $(self.element).val()},
				dataType: 'json',
				success: function (response) {
					if (!response.error) {
						$('#magesms_load_filter').html(response.html);
						if (response.js) {
							for (var i in response.js) {
								eval(response.js[i]);
							}
						}
					}
				}
			});
		}
	});
	return $.topefekt.magesms;
});