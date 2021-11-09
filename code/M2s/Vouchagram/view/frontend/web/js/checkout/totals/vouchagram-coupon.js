define(
    [
        'M2s_Vouchagram/js/cart/totals/vouchagram-coupon'
    ],
    function (Component) {
        'use strict';

        return Component.extend({

            /**
             * @override
             */
            isDisplayed: function () {
                return true;
            }
        });
    }
);