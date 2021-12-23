define(
    [
        'jquery',
        'Magento_Checkout/js/model/quote',
        'Magento_Customer/js/model/customer',
        'Magento_Checkout/js/model/url-builder',
        'Magento_Checkout/js/model/error-processor',
        'mage/url'
    ],
    function($, quote, customer, urlBuilder, errorProcessor, urlFormatter) {
        'use-strict';

        return {

            save: function(pass) {
                if (pass) {
                    var quoteId = quote.getQuoteId();
                    var isCustomer = customer.isLoggedIn();
                    var url;

                    if (isCustomer) {
                        return true;
                    } else {
                        apiUrl = urlFormatter.build('CustomCheckout/checkout/saveInQuote', { cartId: quoteId });
                    }

                    var payload = {
                        cartId: quoteId,
                        accountPass: pass
                    };

                    if (!payload.accountPass) {
                        return true;
                    }
                    var result = true;

                    $.ajax({
                        showLoader: true,
                        url: apiUrl,
                        data: { payload: payload},
                        type: "POST",
                        dataType: 'json'
                    }).done(function(data) {
                        result = true;
                        console.log('success');
                    }).fail(function(data){
                        result = false;
                        console.log("failed create customer");
                    });
                    return result;
                }
            }
        }
    }
)