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
			self.element.on(self.options.triggerEvent, function() {
				self._ajaxSubmit();
			});
		},
		_ajaxSubmit: function() {
			var self = this;
			$.ajax({
				url: self.options.url,
				type: self.options.method,
				data: {a:1},
				dataType: 'json',
				success: function (response) {
					if (!response.error) {
						$('#magesms_applied_filters').html(response.html.appliedFilters);
						$('#magesms-marketing-customer').html(response.html.customers).trigger('contentUpdated');
						$('#magesms-marketing-customerdeleted').html(response.html.deleted).trigger('contentUpdated');
						countitSMS.marketingCount = response.html.count;
						countitSMS.count();
					}
				}
			});
		},
	});
	return $.topefekt.magesms;
});