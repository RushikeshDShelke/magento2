define([
	"jquery"
], function($) {
	"use strict";

	$.widget('topefekt.magesms', {
		options: {
			url: '',
			method: 'post',
			triggerEvent: 'click'
		},
		_create: function() {
			this._bind();
		},

		_bind: function() {
			var self = this;
			var $form = $('#marketing_filter');
			self.options.url = $form.attr('action');
			self.element.on(self.options.triggerEvent, function() {
				self._ajaxSubmit();
			});
		},

		_ajaxSubmit: function() {
			var self = this;
			var filter = $('#marketing_filter').serialize();
/*
			if (!filter) {
				filter = [$('#filter1').val(), $('#filter2').val()]
			} else {
				filter = $('#filter').val();
			}
*/
			$.ajax({
				url: self.options.url,
				type: self.options.method,
				data: filter + '&name=' + $('#magesms_marketing_filters').val(),
				dataType: 'json',
				success: function (response) {
					if (!response.error && response.html) {
						$('#magesms_applied_filters').html(response.html.appliedFilters).trigger('contentUpdated');
						$('#magesms-marketing-customer').html(response.html.customers).trigger('contentUpdated');
						countitSMS.marketingCount = response.html.count;
						countitSMS.count();

					}
				}
			});
		}
	});
	return $.topefekt.magesms;
});