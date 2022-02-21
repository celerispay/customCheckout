<?php
namespace Boostsales\CustomCheckout\Block\Checkout;
use Magento\Customer\Model\Session;

class FieldProcessor
{

    protected $customerSession;

    public function __construct(
        Session $customerSession
    ) {
        $this->customerSession = $customerSession;
    }

    /**
     * Checkout LayoutProcessor after process plugin.
     *
     * @param \Magento\Checkout\Block\Checkout\LayoutProcessor $processor
     * @param array $jsLayout
     * @return array
     */
    public function afterProcess(\Magento\Checkout\Block\Checkout\LayoutProcessor $processor, $jsLayout)
    {
        $jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']['shippingAddress']['children']['customer-email']['children']['before-login-form']['children']['custom_check'] = [
            'component' => 'Boostsales_CustomCheckout/js/view/custom-checkbox',
            'config' => [
                'customScope' => 'shippingAddress.custom_check',
                'template' => 'ui/form/field',
                'elementTmpl' => 'Boostsales_CustomCheckout/custom-checkout-checkbox',
                'options' => [],
                'id' => 'custom-check'
            ],
            'dataScope' => 'custom_check',
            'provider' => 'checkoutProvider',
            'visible' => true,
            'label' => __('Address Type'),
            'validation' => [],
            'sortOrder' => 0,
            'id' => 'custom-check'
        ];
        $jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']['shippingAddress']['children']['shipping-address-fieldset']['children']['invoice_email_check'] = [
            'component' => 'Magento_Ui/js/form/element/abstract',
            'config' => [
                'customScope' => 'shippingAddress.invoice_email_check',
                'template' => 'ui/form/field',
                'elementTmpl' => 'ui/form/element/checkbox',
                'options' => [],
                'id' => 'invoice_email_check'
            ],
            'dataScope' => 'invoice_email_check',
            'provider' => 'checkoutProvider',
            'visible' => true,
            'label' => __('Please send the invoice to another email address'),
            'validation' => [],
            'sortOrder' => 3,
            'id' => 'invoice_email_check'
        ];

        $paymentLayout = $jsLayout['components']['checkout']['children']['steps']['children']['billing-step']['children']['payment']['children'];

        if (isset($paymentLayout['afterMethods']['children']['billing-address-form'])) {
            $jsLayout['components']['checkout']['children']['steps']['children']['billing-step']['children']['payment']['children']['beforeMethods']['children']['billing-address-form']
                = $paymentLayout['afterMethods']['children']['billing-address-form'];

            unset($jsLayout['components']['checkout']['children']['steps']['children']['billing-step']['children']['payment']['children']['afterMethods']['children']['billing-address-form']);
        }
        if ($this->customerSession->isLoggedIn()) {
            unset($jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']['shippingAddress']['children']['before-form']['children']['checkout_create_account']);
        }

        return $jsLayout;
    }
}
