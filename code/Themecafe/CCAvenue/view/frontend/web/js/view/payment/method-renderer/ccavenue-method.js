define(
    [
        'jquery',
        'Magento_Checkout/js/view/payment/default',
        'Magento_Checkout/js/action/set-billing-address',
        'Themecafe_CCAvenue/js/action/set-payment-method',
        'Magento_Checkout/js/action/select-payment-method',
        'Magento_Checkout/js/model/payment/additional-validators'
    ],
    function ($, Component, setBillingAddressAction, setPaymentMethodAction, selectPaymentMethodAction, additionalValidators) {
        'use strict';
        return Component.extend({
            defaults: {
                template: 'Themecafe_CCAvenue/payment/ccavenue'
            },
            initialize: function () {
                var self = this;
                this._super();
                
            },
            continueToCcavenue: function () {
                if ( additionalValidators.validate()) {
                    this.selectPaymentMethod();
                    var setBillingInfo = setBillingAddressAction();
                   // window.top.location = window.checkoutConfig.payment.ccavenue.redirectUrl ;
                    setBillingInfo.done(function() {
//                        $('.paynow').hide();
//                        $('#opc-shipping, li#iwd-opc-shipping-methods, .payment-method-billing-address').addClass('disable-div');
//                        $('#opc-shipping input, #opc-shipping button,li#iwd-opc-shipping-methods input, li#iwd-opc-shipping-methods button, .payment-method-billing-address input,.payment-method-billing-address button').prop('disabled',true);
//                        $(document).on('click','.disable-div',function(e){ e.preventDefault(); });
                        setPaymentMethodAction();
                    });
                    return false;
                }
            }
        });
    }
);