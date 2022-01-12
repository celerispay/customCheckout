<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Boostsales\CustomCheckout\Model\Sales\Order\Email;

use Magento\Sales\Model\Order;
use Magento\Sales\Model\Order\Email\Sender\InvoiceSender as MageInvoiceSender;

/**
 * Sends order invoice email to the customer.
 *
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class InvoiceSender extends MageInvoiceSender
{

    /**
     * Populate order email template with customer information.
     *
     * @param Order $order
     * @return void
     */
    protected function prepareTemplate(Order $order)
    {
        $this->templateContainer->setTemplateOptions($this->getTemplateOptions());

        if ($order->getCustomerIsGuest()) {
            $templateId = $this->identityContainer->getGuestTemplateId();
            $customerName = $order->getBillingAddress()->getName();
        } else {
            $templateId = $this->identityContainer->getTemplateId();
            $customerName = $order->getCustomerName();
        }
        if(!empty($order->getBillingAddress()->getData['invoice_email'])){
            $customerEmail = $order->getBillingAddress()->getData['invoice_email'];
        }else{
            $customerEmail = $order->getCustomerEmail();
        }
        $this->identityContainer->setCustomerName($customerName);
        $this->identityContainer->setCustomerEmail($customerEmail);
        $this->templateContainer->setTemplateId($templateId);
    }
}
