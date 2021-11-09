function submitSaveFilter(form) {
	var filters = $$('#marketing_filter input', '#marketing_filter select', '#marketing_filter textrea');
	var elements = [];
	for(var i in filters){
		if(filters[i].value && filters[i].value.length && !filters[i].disabled) elements.push(filters[i]);
	}
	new Ajax.Request(form.action, {
		method: 'post',
		parameters: {
			saveName: $('saveName').value,
			params: encode_base64(Form.serializeElements(elements)),
		},
		//asynchronous: false,
		onSuccess: function(transport) {
			if(transport && transport.responseText) {
				var response = transport.responseText.evalJSON();
				if (response.error != true) {
					Windows.close('template_popup');
					$('messages').innerHTML = '<ul class="messages"><li class="success-msg"><ul><li>' + Translator.translate('Filter has been saved.') + '</li></ul></li></ul>'
				}
			}
		}
	});
}
function submitRemoveFilter(obj) {
	if (window.confirm(Translator.translate('Are you sure you want to remove the filter?'))) {
		var url = obj.href;
		new Ajax.Request(url, {
			method: 'post',
			parameters: {
				
			},
			//asynchronous: false,
			onSuccess: function(transport) {
				if(transport && transport.responseText) {
					var response = transport.responseText.evalJSON();
					if (!response.error)
						$('modal_dialog_message').innerHTML = '' + response.html + '';
						magesms_template_gridJsObject = new varienGrid('magesms_filter_template_grid');
						magesms_template_gridJsObject.rowClickCallback = submitRestoreFilter;
				}
			}
		});
	}
	return false;
}

function submitRestoreFilter(grid, event) {
	var element = Event.findElement(event, 'tr');
	if (Event.element(event).className == 'action-remove') {
		return;
	}
	var url = element.title;
	new Ajax.Request(url, {
		method: 'post',
		parameters: {},
		//asynchronous: false,
		onSuccess: function(transport) {
			if(transport && transport.responseText) {
				var response = transport.responseText.evalJSON();
				if (!response.error) {
					$('magesms_applied_filters').innerHTML = response.html.appliedFilters;
					$('magesms-marketing-customer').innerHTML = response.html.customers;
					$('magesms-marketing-deleted').innerHTML = response.html.deleted;
					countitSMS.marketingCount = response.html.count;
					countitSMS.count();
					$('messages').innerHTML = '<ul class="messages"><li class="success-msg"><ul><li>' + Translator.translate('Filter has been applied.') + '</li></ul></li></ul>'
				}
				closePopup();
			}
		}
	});
}

function loadFilter(obj, url) {
	$.ajax({
		url: url,
		type: 'post',
		dataType: 'json',
		data: {name: obj.value, isAjax: 1},
		//asynchronous: false,
		success: function(response) {
			console.log(response);
			return;
			if (transport && transport.responseText) {
				var response = transport.responseText.evalJSON();
				if (!response.error) {
					document.getElementById('magesms_load_filter').innerHTML = response.html;
					if (response.js) {
						for (key in response.js) {
							eval(response.js[key]);
						}
					}
				}
			}
		}
	});
}

function applyFilter(formName) {
	var form = $(formName);
	var url = form.action;
	var filter = $('filter');
	if (!filter) {
		filter = [$('filter1').value, $('filter2').value]
	} else {
		filter = filter.value;
	}
	new Ajax.Request(url, {
		method: 'post',
		parameters: {
			name: $('magesms_marketing_filters').value,
			'value[]': filter
		},
		//asynchronous: false,
		onSuccess: function(transport) {
			if(transport && transport.responseText) {
				var response = transport.responseText.evalJSON();
				if (!response.error) {
					$('magesms_applied_filters').innerHTML = response.html.appliedFilters;
					$('magesms-marketing-customer').innerHTML = response.html.customers;
					countitSMS.marketingCount = response.html.count;
					countitSMS.count();
				}
			}
		}
	});
}

function removeFilter(obj) {
	var url = obj.href;
	new Ajax.Request(url, {
		method: 'post',
		parameters: {
		},
		//asynchronous: false,
		onSuccess: function(transport) {
			if(transport && transport.responseText) {
				var response = transport.responseText.evalJSON();
				if (!response.error) {
					$('magesms_applied_filters').innerHTML = response.html.appliedFilters;
					$('magesms-marketing-customer').innerHTML = response.html.customers;
					$('magesms-marketing-deleted').innerHTML = response.html.deleted;
					countitSMS.marketingCount = response.html.count;
					countitSMS.count();
				}
			}
		}
	});
}

function removeCustomer(obj) {
	var url = obj.href;
	new Ajax.Request(url, {
		method: 'post',
		parameters: {
		},
		//asynchronous: false,
		onSuccess: function(transport) {
			if(transport && transport.responseText) {
				var response = transport.responseText.evalJSON();
				if (!response.error) {
					$('magesms-marketing-customer').innerHTML = response.html.customers;
					$('magesms-marketing-deleted').innerHTML = response.html.deleted;
					countitSMS.marketingCount = response.html.count;
					if ($('magesms_customer_grid') && response.html.customer_letter) {
						$('magesms_customer_grid').innerHTML = response.html.customer_letter;
						magesms_customer_gridJsObject = new varienGrid('magesms_customer_grid');
					}
					countitSMS.count();
				}
			}
		}
	});
}

function resetFilter(obj) {
	if (window.confirm(Translator.translate('Are you sure you want to reset the filter?'))) {
		var url = obj.href;
		new Ajax.Request(url, {
			method: 'post',
			parameters: {
			},
			//asynchronous: false,
			onSuccess: function(transport) {
				if(transport && transport.responseText) {
					var response = transport.responseText.evalJSON();
					if (!response.error) {
						$('magesms_applied_filters').innerHTML = response.html.appliedFilters;
						$('magesms-marketing-customer').innerHTML = response.html.customers;
						$('magesms-marketing-deleted').innerHTML = response.html.deleted;
						countitSMS.marketingCount = response.html.count;
						countitSMS.count();
						$('messages').innerHTML = '<ul class="messages"><li class="success-msg"><ul><li>' + Translator.translate('Filter has been reset.') + '</li></ul></li></ul>'
					}
				}
			}
		});
	}
	return false;
}
