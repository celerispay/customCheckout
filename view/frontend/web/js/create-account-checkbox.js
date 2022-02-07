define([
    'Magento_Ui/js/form/element/single-checkbox',
    'jquery',
    'Boostsales_CustomCheckout/js/action/save-account'
], function(AbstractField, $, saveAccount) {
    'use strict';

    return AbstractField.extend({

        initObservable: function() {
            return this._super().observe({isShowCreateUser: false})
        },
        onCheckedChanged: function(event) {
            this._super();

            if (isShowCreateUser()) {
                this.showInputField();
            } else {
                this.hideInputField();
            }
        },
        showInputField: function() {
            if(this.isShowCreateUser()){
                return true;
            }else {
                return false;
            }
        },
        checkPasswordField: function(){
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

        ajaxPassword: function(pass) {
            saveAccount.save(pass);
        }
    });
});