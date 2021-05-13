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

            save: function(email) {
                if (email) {
                    var quoteId = quote.getQuoteId();
                    var isCustomer = customer.isLoggedIn();
                    var url;

                    if (isCustomer) {
                        apiUrl = urlBuilder.createUrl('/carts/mine/set-invoice-email', {});
                    } else {
                        apiUrl = urlBuilder.createUrl('/guest-carts/:cartId/set-invoice-email', { cartId: quoteId });
                    }

                    var payload = {
                        cartId: quoteId,
                        checkoutInvoiceEmail: {
                            checkoutInvoiceEmail: email
                        }
                    };

                    if (!payload.checkoutInvoiceEmail.checkoutInvoiceEmail) {
                        return true;
                    }
                    var result = true;

                    $.ajax({
                        url: urlFormatter.build(apiUrl),
                        data: JSON.stringify(payload),
                        global: false,
                        contentType: 'application/json',
                        type: 'PUT',
                        async: false
                    }).done(
                        function(response) {
                            console.log(response);
                            result = true;
                        }
                    ).fail(
                        function(response) {
                            console.log(response);
                            result = false;
                            errorProcessor.process(response);
                        }
                    );
                    return result;
                }
            }
        }
    }
)