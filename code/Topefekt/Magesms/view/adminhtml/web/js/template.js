function showPopup(obj) {
	var url = $(obj).href;
	var title = $(obj).title;
	if ($('template_popup') && typeof(Windows) != 'undefined') {
		Windows.focus('template_popup');
		return;
	}
	Dialog._getAjaxContent = function(transport) {
		var response = transport.responseText.evalJSON();
		Dialog.callFunc(response.html, Dialog.parameters);
		if (response.type && response.type == 'marketing') {
			magesms_filter_template_gridJsObject = new varienGrid('magesms_filter_template_grid');
			magesms_filter_template_gridJsObject.rowClickCallback = submitRestoreFilter;
		} else if (response.type && response.type == 'customer') {
			magesms_customer_gridJsObject = new varienGrid('magesms_customer_grid');
		} else {
			magesms_template_gridJsObject = new varienGrid('magesms_template_grid');
			magesms_template_gridJsObject.rowClickCallback = submitRestoreTemplate;
		}
	}
	var dialogWindow = Dialog.info(
		{
			url:url,
			options: {method: 'get'}
		},
		{
			id:'template_popup',
			className: "magento",
			width:600,
			resizable: true,
			title: title,
			draggable:true,
			resizable:true,
			closable:true,
			onClose: closePopup,
			showProgress: true,
		}
	);
}
function closePopup() {
	Windows.close('template_popup');
}
function submitSaveTemplate(form) {
	var type = $('type') ? $('type').value : 0;
	new Ajax.Request(form.action, {
		method: 'post',
		parameters: {
			saveName: $('saveName').value,
			text: $('text').value,
			unicode: $('unicode').checked ? 1 : 0,
			unique: $('unique').checked ? 1 : 0,
			type: type,
		},
		//asynchronous: false,
		onSuccess: function(transport) {
			if(transport && transport.responseText) {
				var response = transport.responseText.evalJSON();
				if (response.error != true) {
					Windows.close('template_popup');
					$('messages').innerHTML = '<ul class="messages"><li class="success-msg"><ul><li>' + Translator.translate('Template has been saved.') + '</li></ul></li></ul>'
				}
			}
		}
	});
}
function submitRemoveTemplate(obj) {
	if (window.confirm(Translator.translate('Are you sure you want to remove the template?'))) {
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
						magesms_template_gridJsObject = new varienGrid('magesms_template_grid');
						magesms_template_gridJsObject.rowClickCallback = submitRestoreTemplate;
				}
			}
		});
	}
	return false;
}
function submitRestoreTemplate(grid, event) {
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
					$('text').value = response.data.template;
					$('unicode').checked = (parseInt(response.data.unicode) ? true : false);
					$('unique').checked = (parseInt(response.data.unique) ? true : false);
					countitSMS.count();
					$('messages').innerHTML = '<ul class="messages"><li class="success-msg"><ul><li>' + Translator.translate('Template has been loaded.') + '</li></ul></li></ul>'
				}
				closePopup();
			}
		}
	});
}
