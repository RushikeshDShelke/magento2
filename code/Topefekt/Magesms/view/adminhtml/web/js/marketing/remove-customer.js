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
						$('#magesms-marketing-customer').html(response.html.customers).trigger('contentUpdated');
						$('#magesms-marketing-customerdeleted').html(response.html.deleted).trigger('contentUpdated');
						countitSMS.marketingCount = response.html.count;
						if ($('#magesms_customer_grid') && response.html.customer_letter) {
							$('#magesms_customer_grid').html(response.html.customer_letter).trigger('contentUpdated');
							//magesms_customer_gridJsObject = new varienGrid('magesms_customer_grid');
						}
						countitSMS.count();
					}
				}
			});
		},
	});
	return $.topefekt.magesms;
});