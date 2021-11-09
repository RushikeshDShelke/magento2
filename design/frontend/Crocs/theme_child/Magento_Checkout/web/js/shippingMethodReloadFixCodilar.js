requirejs([
    'jquery',
    'Magento_Checkout/js/model/quote',
    'Magento_Checkout/js/model/shipping-rate-registry'
], function($, quote, rateRegistry){
    var reloadShippingMethod = function() {
        var address = quote.shippingAddress();
        if (!address) {
            return setTimeout(function() {
                reloadShippingMethod();
            }, 1000);
        } else if ($("#shipping-method-buttons-container").length) {
            return true;
        }
        rateRegistry.set(address.getKey(), null);
        rateRegistry.set(address.getCacheKey(), null);
        quote.shippingAddress(address);
        setTimeout(function () {
            reloadShippingMethod();
        }, 2000);
    };
    reloadShippingMethod();
});