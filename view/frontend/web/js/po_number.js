define(
    [
        'ko',
        'jquery',
        'uiComponent',
        'mage/url'
    ],
    function(ko, $, Component, url) {
        'use strict';
        return Component.extend({
            defaults: {
                template: 'Boostsales_CustomCheckout/po_number'
            },
            initObservable: function() {

                this._super()
                    .observe({
                        po_number: ko.observable('')
                    });
                this.po_number.subscribe(function(po_number) {
                    var linkUrls = url.build('CustomCheckout/checkout/saveInQuote');
                    $.ajax({
                        showLoader: true,
                        url: linkUrls,
                        data: { po_number: po_number },
                        type: "POST",
                        dataType: 'json'
                    }).done(function(data) {
                        console.log('success');
                    });
                });
                return this;
            }
        });
    }
);