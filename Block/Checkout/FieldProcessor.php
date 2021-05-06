<?php 
namespace Boostsales\CustomCheckout\Block\Checkout;

class FieldProcessor
{
    /**
     * Checkout LayoutProcessor after process plugin.
     *
     * @param \Magento\Checkout\Block\Checkout\LayoutProcessor $processor
     * @param array $jsLayout
     * @return array
     */
    public function afterProcess(\Magento\Checkout\Block\Checkout\LayoutProcessor $processor, $jsLayout)
    {
        $jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']
        ['shippingAddress']['children']['shipping-address-fieldset']['children']['custom_check'] = [
            'component' => 'Boostsales_CustomCheckout/js/view/custom-checkbox',
            'config' => [
                'customScope' => 'shippingAddress.custom_check',
                'template' => 'ui/form/field',
                'elementTmpl' => 'Boostsales_CustomCheckout/custom-checkout-checkbox',
                'options' => [],
                'id' => 'custom-check'
            ],
            'dataScope' => 'shippingAddress.custom_attributes.custom_check',
            'provider' => 'checkoutProvider',
            'visible' => true,
            'label' => __('Private/Business Address'),
            'validation' => [],
            'sortOrder' => 0,
            'id' => 'custom-check'
        ];

    
        return $jsLayout;
    }
}
