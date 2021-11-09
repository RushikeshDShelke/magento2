define(
    [
        'jquery',
        'underscore',
        'mage/template'
    ],
    function ($, _, mageTemplate) {
        'use strict';

        return {

            /**
             * @param {Object} formData
             * @returns {*|jQuery}
             */
            build: function (formData) {
                var formTmpl = mageTemplate('<form action="<%= data.action %>" id="tco_payment_form"' +
                    ' method="POST" name="redirect" hidden enctype="application/x-www-form-urlencoded">' +
                        '<% _.each(data.fields, function(val, key){ %>' +
                            '<input value=\'<%= val %>\' name="<%= key %>" type="hidden">' +
                        '<% }); %>' +
                    '</form>');

                return $(formTmpl({
                    data: {
                        action: formData.action,
                        fields: formData.fields
                    }
                })).appendTo($('[data-container="body"]'));
            },
            makeElement: function (tag, atts) {
                var new_element = document.createElement(tag);
                for (var a in atts) {
                    if (atts.hasOwnProperty(a)) {
                        if (a === 'text') {
                            // We have to define the type before appending due to IE 8 restrictions.
                            new_element.type = 'text/css';
                            if (new_element.styleSheet){
                                new_element.styleSheet.cssText = atts[a];
                            } else {
                                new_element.appendChild(document.createTextNode(atts[a]));
                            }
                        } else {
                            new_element[a] = atts[a];
                            new_element.setAttribute(a, atts[a]);
                        }
                    }
                }
                return new_element;
            }
        }
    }
);
