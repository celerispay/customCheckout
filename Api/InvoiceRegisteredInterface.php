<?php

namespace Boostsales\CustomCheckout\Api;

use Magento\Sales\Model\Order;
use Boostsales\CustomCheckout\Api\Data\InvoiceInterface;
/**
 * interface InvoiceRegisteredInterface
 *
 * @api
 */
interface InvoiceRegisteredInterface
{
    /**
     * @param int $cartId
     * 
     * @param Boostsales\CustomCheckout\Api\Data\InvoiceInterface $checkoutInvoiceEmail
     * 
     * @return Boostsales\CustomCheckout\Api\Data\InvoiceInterface
     */
    public function save(int $cartId, InvoiceInterface $checkoutInvoiceEmail);
}
