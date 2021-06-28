define([
    'Magento_Checkout/js/action/select-shipping-method',
    'Magento_Checkout/js/model/quote'
], function(selectShippingMethod, quote) {
    'use strict'
    return function(target) {
        target.resolveShippingRates = function(ratesData) {
            if (ratesData.length === 1 && !quote.shippingMethod()) {
                selectShippingMethod(null);
            }
        };
        return target;
    }
});