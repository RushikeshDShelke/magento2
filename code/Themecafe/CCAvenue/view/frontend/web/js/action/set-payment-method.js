/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
define(
        [
            'jquery',
            'Magento_Checkout/js/model/quote',
            'Magento_Customer/js/customer-data',
            'Magento_Checkout/js/model/url-builder',
            'mage/storage',
            'Magento_Checkout/js/model/error-processor',
            'Magento_Customer/js/model/customer',
            'Magento_Checkout/js/model/full-screen-loader',
            'Themecafe_CCAvenue/js/form/form-builder',
        ],
        function ($, quote, customerData, urlBuilder, storage, errorProcessor, customer, fullScreenLoader, formBuilder) {
            'use strict';

            return function (messageContainer) {

                var serviceUrl,form,
                        payload,
                        paymentData = quote.paymentMethod();
                var email;
                if (!customer.isLoggedIn()) {
                    email = quote.guestEmail;
                } else {
                    email = customer.customerData.email;
                }
		if(window.checkoutConfig.payment.ccavenue.integrationType != 'redirect'){
		/*for IFRAME */
			/**
                 * Checkout for guest and registered customer.
                 */
                if (!customer.isLoggedIn()) {
                    serviceUrl = urlBuilder.createUrl('/guest-carts/:cartId/selected-payment-method', {
                        cartId: quote.getQuoteId()
                    });
                    payload = {
                        cartId: quote.getQuoteId(),
                        method: paymentData
                    };
                } else {
                    serviceUrl = urlBuilder.createUrl('/carts/mine/selected-payment-method', {});
                    payload = {
                        cartId: quote.getQuoteId(),
                        method: paymentData
                    };
                }

                fullScreenLoader.startLoader();

                return storage.put(
                        serviceUrl, JSON.stringify(payload)
                        ).done(
                        function () {
                            customerData.invalidate(['cart']);
                            var url = window.checkoutConfig.payment.ccavenue.redirectUrl;
                            if (url.split('?').length > 1) {
                                $.mage.redirect(url +'&email=' + email);
                            } else {
                                $.mage.redirect(url +'?email=' + email);
                            }

                            //$.mage.redirect(url.build('ccavenue/ccavenue/redirect/'));
                        }
                ).fail(
                        function (response) {
                            errorProcessor.process(response, messageContainer);
                            fullScreenLoader.stopLoader();
                        }
                );

		}
		else{
		/*for REDIRECT */
		 serviceUrl = window.checkoutConfig.payment.ccavenue.redirectUrl + '?email=' + email;
                fullScreenLoader.startLoader();
                //console.log(serviceUrl);

                $.ajax({
                    url: serviceUrl,
                    type: 'post',
                    context: this,
                    data: {isAjax: 1},
                    dataType: 'json',
                    success: function (response) {
                        if ($.type(response) === 'object' && !$.isEmptyObject(response)) {
                            fullScreenLoader.stopLoader();
                           
                           
                            /*CUSTOM FORM CHECKOUT AS WELL AS REDIRECTION*/
                            $('#tco_payment_form').remove();
                             form = formBuilder.build(
                             {
                             action: response.url,
                             fields: response.fields
                             }
                             );
                             console.log('salma' + form);
                             customerData.invalidate(['cart']);
                             form.submit();
                        } else {
                            fullScreenLoader.stopLoader();
//                            alert({
//                                content: $.mage.__('Sorry, something went wrong. Please try again.')
//                            });
                        }
                    },
                    error: function (response) {
                        fullScreenLoader.stopLoader();
//                        alert({
//                            content: $.mage.__('Sorry, something went wrong. Please try again later.')
//                        });
                    }
                });
		}
                

//                var serviceUrl,
//                        email,
//                        form;
//
//                if (!customer.isLoggedIn()) {
//                    email = quote.guestEmail;
//                } else {
//                    email = customer.customerData.email;
//                }
//                window.top.location = window.checkoutConfig.payment.ccavenue.redirectUrl ;
//                return;
//                serviceUrl = window.checkoutConfig.payment.ccavenue.redirectUrl + '?email=' + email;
//                fullScreenLoader.startLoader();
//                console.log(serviceUrl);

                /* $.ajax({
                 url: serviceUrl,
                 type: 'post',
                 context: this,
                 data: {isAjax: 1},
                 dataType: 'json',
                 success: function (response) {
                 if ($.type(response) === 'object' && !$.isEmptyObject(response)) {
                 fullScreenLoader.stopLoader();
                 *//*IFRAME INJECT CODE STARTS HERE*/
                /*$("#paymentFrame").attr("src", response.url);
                 window.addEventListener('message', function (e) {
                 $("#paymentFrame").css("height", e.data['newHeight'] + 'px');
                 }, false);
                 $("#paymentFrame").show();
                 
                 *//*CUSTOM FORM CHECKOUT AS WELL AS REDIRECTION*/
                /*$('#tco_payment_form').remove();
                 form = formBuilder.build(
                 {
                 action: response.url,
                 fields: response.fields
                 }
                 );
                 console.log('salma' + form);
                 customerData.invalidate(['cart']);
                 form.submit();*/
                /*
                 } else {
                 fullScreenLoader.stopLoader();
                 //                            alert({
                 //                                content: $.mage.__('Sorry, something went wrong. Please try again.')
                 //                            });
                 }
                 },
                 error: function (response) {
                 fullScreenLoader.stopLoader();
                 //                        alert({
                 //                            content: $.mage.__('Sorry, something went wrong. Please try again later.')
                 //                        });
                 }
                 });*/
            };
        }
);
