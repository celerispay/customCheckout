define([
    'Magento_Checkout/js/action/select-shipping-method'
], function(selectShippingMethod) {
    'use strict'
    return function(target) {
        target.resolveShippingRates = function(ratesData) {
            selectShippingMethod(null);
        };
        return target;
    }
});