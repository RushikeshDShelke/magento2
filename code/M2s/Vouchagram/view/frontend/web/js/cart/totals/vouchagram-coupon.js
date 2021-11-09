
define(
    [
       'jquery',
       'Magento_Checkout/js/view/summary/abstract-total',
       'Magento_Checkout/js/model/quote',
       'Magento_Checkout/js/model/totals',
       'Magento_Catalog/js/price-utils'
    ],
    function ($,Component,quote,totals,priceUtils) {
        "use strict";
        return Component.extend({
            defaults: {
                template: 'M2s_Vouchagram/checkout/summary/vouchagram-coupon'
            },
            totals: quote.getTotals(),
            isDisplayedCoupondiscountTotal : function () {
                var price = 0;
                price = totals.getSegment('coupondiscount_total').value;
                if (price) {
                    return true;
                } else {
                    return false;
                }
               
            },
            getCoupondiscountTotal : function () {
                var price = 0;
                price = totals.getSegment('coupondiscount_total').value;
                return this.getFormattedPrice(price);
            },

            getCoupondiscountLabel : function () {
                return totals.getSegment('coupondiscount_total').title;
            }
         });
    }
);