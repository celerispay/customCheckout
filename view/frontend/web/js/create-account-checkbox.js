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
            $("div[name='shippingAddress.checkout_create_account']").after("<span data-bind='i18n: 'Company''></span> <div class='control inp-create-account'> <div class='first-col password-col'> <lable class='create-acc-lbl'><span data-bind='i18n: 'Password''>Password</span></lable> <input type='password' name='shippingAddress.checkout_create_account' class='input-text create-account pass' data-bind='change: checkPasswordField'> </div> <div class='last-col password-col'> <lable class='create-acc-lbl'><span data-bind='i18n: Confirm Password'>Confirm Password</span></lable> <input type='password' name='shippingAddress.checkout_create_account' class='input-text create-account confirm-pass' data-bind='change: checkPasswordField'> <label class='pass-msg fail'>Not Matched</label> </div> </div>");
            $('.input-text.create-account').on('input', () => { this.checkPasswordField(); });
        },
        checkPasswordField(){
            var pass = $('.input-text.create-account.pass').val().trim();
            var confirmPass = $('.input-text.create-account.confirm-pass').val().trim();
            var passMsg = $('.inp-create-account .pass-msg');
            if(pass.length != 0 && confirmPass.length != 0 &&  pass == confirmPass){
                if(confirmPass.length > 0){
                    passMsg.show();
                }
                passMsg.removeClass('fail').addClass('success').html('Matched');
                this.ajaxPassword(pass);
                $('.input-text.create-account').blur();
            }
            else{
                if(confirmPass.length > 0){
                    passMsg.show();
                }
                passMsg.removeClass('success').addClass('fail').html('Not Matched');
            }
        },
        hideInputField: function() {
            $('.inp-create-account').detach();
        },
        ajaxPassword: function(pass) {
            saveAccount.save(pass);
        }
    });
});