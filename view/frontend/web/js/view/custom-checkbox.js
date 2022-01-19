define(
    [
        'Magento_Ui/js/form/element/abstract',
        'jquery'
    ],
    function(Component, $) {
        'use strict';
        return Component.extend({
            initialize: function() {
                this._super();
                return this;
            },

            click: function(data, event) {
                this.change(event.target.value);
                return true;
            },

            change: function(value) {
                if (value === 'company') {
                    $('div[name="shippingAddress.company"]').show();
                    $('div[name="shippingAddress.dept_extra_info"]').show();
                    $('div[name="billingAddress.company"]').show();
                    $('div[name="billingAddress.dept_extra_info"]').show();
                    $('div[name="shippingAddress.custom_attributes.customer_taxvat"]').show();
                } else if (value === 'private') {
                    $('div[name="shippingAddress.company"]').hide();
                    $('div[name="shippingAddress.dept_extra_info"]').hide();
                    $('div[name="billingAddress.company"]').hide();
                    $('div[name="billingAddress.dept_extra_info"]').hide();
                    $('div[name="shippingAddress.custom_attributes.customer_taxvat"]').hide();
                }
            }
        });
    }
);