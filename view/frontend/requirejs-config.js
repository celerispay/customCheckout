var config = {
    config: {
        mixins: {
            'Magento_Checkout/js/view/shipping': {
                'Boostsales_CustomCheckout/js/view/shipping-mixin': true
            },
            'Magento_Checkout/js/model/checkout-data-resolver': {
                'Boostsales_CustomCheckout/js/view/checkout-data-resolver-mixin': true
            }
        }
    }
};