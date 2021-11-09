/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
/*global define*/
define(
        [
            'ko',
            'jquery',
            'underscore',
            'Magento_Checkout/js/model/quote',
            'Magento_Checkout/js/model/checkout-data-resolver',
            'Magento_Checkout/js/checkout-data',
            'Magento_Ui/js/model/messageList',
        ],
        function (ko, $, _, quote, checkoutDataResolver, checkoutData, globalMessageList, config) {
            "use strict";
            var shippingRates = ko.observableArray([]);
            var shippingCarriers = ko.observableArray([]);
            var messageContainer = messageContainer || globalMessageList;
            return {
                isLoading: ko.observable(false),
                /**
                 * Set shipping rates
                 *
                 * @param ratesData
                 */
                setShippingRates: function (ratesData) {
                    if (typeof window.tssValuesConfig.tssstatus != 'undefined') {
                        if (window.tssValuesConfig.tssstatus != 0) {
                            if ($('body').hasClass('checkout-index-index')) {
                                var selectedPostcode = quote.shippingAddress().postcode;

                                var addresId = quote.shippingAddress().customerAddressId;
                                if ($('#co-shipping-form'))
                                {
                                    var postcodeId = "#" + $("#co-shipping-form input[name=postcode]").attr('id');
                                }
                                else if ($('#opc-new-shipping-address'))
                                {
                                    var postcodeId = "#" + $("#opc-new-shipping-address input[name=postcode]").attr('id');
                                }
                                else
                                {
                                    var postcodeId = "#" + $("input[name=postcode]:first").attr('id');
                                }

                                setTimeout(function () {
                                    if (addresId !== null || checkoutData.getSelectedShippingAddress() !== null || $('input' + postcodeId).val() !== '')
                                    {
                                        $('#custom-warning').remove();
                                        $('#custom-success').remove();
                                        $('.address-message-error').remove();

// checking if estimate shipping method api is not null as well as the product type is not virtual product
                                        if (!(ratesData.length) && !(quote.isVirtual())) 
                                        {
                                            $('.address-message-error').remove();
                                            $('.address-message-success').remove();
                                            $('.shipping-address-item.selected-item').addClass('address-error');
                                            $('.shipping-address-item.selected-item').prepend('<div class="address-message-error message message-error error"><div data-ui-id="checkout-cart-validationmessages-message-error" data-bind="text: $data">' + window.tssValuesConfig.tssErrorMessage + '</div></div>');
                                            if ($('input' + postcodeId) && $('input' + postcodeId).val() !== '' && selectedPostcode === $('input' + postcodeId).val())
                                            {
                                                $('<div class="message warning custom-warning" id="custom-warning"><span>' + window.tssValuesConfig.tssErrorMessage + '</span></div>').insertAfter($(postcodeId));
                                                $('.shipping-address-item.selected-item .postalCode').text($('input' + postcodeId).val());
                                            }
                                            var message = window.tssValuesConfig.tssErrorMessage;
                                            messageContainer.addErrorMessage({'message':message.replace(/&quot;/g, '\"')});
                                            ratesData = "";
                                            shippingRates(ratesData);
                                            shippingRates.valueHasMutated();
                                            checkoutDataResolver.resolveShippingRates(ratesData);
                                        }
                                        else
                                        {
                                            $('.messages').hide();
                                            $('.address-message-error').remove();
                                            $('.address-message-success').remove();
                                            $('.shipping-address-item.selected-item').removeClass('address-error');
                                            var pinarray = window.tssPin.tssPinArray.split(',');
                                            var pindata = $.map(pinarray, $.trim);
                                            var inputzip = $('input' + postcodeId).val();
                                            if ($.inArray(inputzip, pindata) != -1) {
                                                $('.shipping-address-item.selected-item').prepend('<div class="address-message-success message message-success success"><div data-ui-id="checkout-cart-validationmessages-message-success" data-bind="text: $data">' + window.tssValuesConfig.tssSuccessMessage + '</div></div>');
                                                if ($('input' + postcodeId) && $('input' + postcodeId).val() !== '' && selectedPostcode === $('input' + postcodeId).val())
                                                {
                                                    $('<div class="message success" id="custom-success"><span>' + window.tssValuesConfig.tssSuccessMessage + '</span></div>').insertAfter($(postcodeId));
                                                    $('.shipping-address-item.selected-item .postalCode').text($('input' + postcodeId).val());
                                                    shippingRates(ratesData);
                                                    shippingRates.valueHasMutated();
                                                    checkoutDataResolver.resolveShippingRates(ratesData);
                                                }
                                            }

                                            $('.address-message-error').remove();

                                        }
                                        if (ratesData != "") {
                                            shippingRates(ratesData);
                                            shippingRates.valueHasMutated();
                                            checkoutDataResolver.resolveShippingRates(ratesData);
                                        }
                                    }
                                });
                            }
                        }
                        else {
                            shippingRates(ratesData);
                            shippingRates.valueHasMutated();
                            checkoutDataResolver.resolveShippingRates(ratesData);
                        }
                    }
                    else {
                        shippingRates(ratesData);
                        shippingRates.valueHasMutated();
                        checkoutDataResolver.resolveShippingRates(ratesData);
                    }
                },
                /**
                 * Get shipping rates
                 *
                 * @returns {*}
                 */
                getShippingRates: function () {
                    return shippingRates;
                }
            };
        }
);
