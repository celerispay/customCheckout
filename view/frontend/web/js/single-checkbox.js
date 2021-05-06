define([
    'Magento_Ui/js/form/element/single-checkbox',
    'jquery',
    'Boostsales_CustomCheckout/js/action/save-invoice-email'
], function(AbstractField, $, saveInvoice) {
    'use strict';

    return AbstractField.extend({

        initObservable: function() {
            return this._super().observe(['invoiceEmail'])
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
            $("div[name='shippingAddress.checkout_invoice_email']").after("<div class='control inp-invoice-email'><input type='text' name='shippingAddress.checkout_invoice_email' class='input-text invoice-email' data-bind='change: saveInvoiceEmail'></div>");
            $('.input-text.invoice-email').on('change', () => { this.saveInvoiceEmail($('.input-text.invoice-email').val()); });
        },
        hideInputField: function() {
            $('.inp-invoice-email').detach();
        },
        saveInvoiceEmail: function(email) {
            saveInvoice.save(email);
        }
    });
});