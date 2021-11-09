define([
	"jquery",
	'mage/translate'
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
			self.options.url = self.element.context.href;
			self.element.on(self.options.triggerEvent, function(event) {
				event.preventDefault();
				self._ajaxSubmit();
			});
		},
		_ajaxSubmit: function() {
			if (window.confirm($.mage.__('Are you sure you want to reset the filter?'))) {
				var self = this;
				$.ajax({
					url: self.options.url,
					type: self.options.method,
					data: {a: 1},
					dataType: 'json',
					success: function (response) {
						if (!response.error) {
							$('#magesms_applied_filters').html(response.html.appliedFilters).trigger('contentUpdated');;
							$('#magesms-marketing-customer').html(response.html.customers).trigger('contentUpdated');;
							$('#magesms-marketing-customerdeleted').html(response.html.deleted).trigger('contentUpdated');;
							countitSMS.marketingCount = response.html.count;
							countitSMS.count();
							$('#messages').html('<ul class="messages"><li class="success-msg"><ul><li>' + $.mage.__('Filter has been reset.') + '</li></ul></li></ul>');
						}
					}
				});
			}
		}
	});
	return $.topefekt.magesms;
});