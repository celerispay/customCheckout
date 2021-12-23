define([
    'Magento_Ui/js/form/element/single-checkbox',
    'jquery',
    'Boostsales_CustomCheckout/js/action/save-account'
], function(AbstractField, $, saveAccount) {
    'use strict';

    return AbstractField.extend({

        initObservable: function() {
            return this._super().observe(['createAccount'])
        },
        onCheckedChanged: function(event) {
            this._super();
            if (event == true) {
                this.showInputField();
            } else {
                this.hideInputField();
            }
        },
        showInputField: function() {
            $("div[name='shippingAddress.checkout_create_account']").after("<span data-bind='i18n: 'Company''></span><div class='control inp-create-account'><lable class='create-acc-lbl'><span data-bind='i18n: 'Password''>Password</span></lable><input type='text' name='shippingAddress.checkout_create_account' class='input-text create-account' data-bind='change: ajaxPassword'><lable class='create-acc-lbl'><span data-bind='i18n: Confirm Password'></span></lable><input type='text' name='shippingAddress.checkout_create_account' class='input-text create-account' data-bind='change: ajaxPassword'></div>");
            $('.input-text.create-account').on('change', () => { this.ajaxPassword($('.input-text.create-account').val()); });
        },
        hideInputField: function() {
            $('.inp-create-account').detach();
        },
        ajaxPassword: function(pass) {
            saveAccount.save(pass);
        }
    });
});