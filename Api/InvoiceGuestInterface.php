<?php 

namespace Boostsales\CustomCheckout\Api;

use Magento\Sales\Model\Order;
use Boostsales\CustomCheckout\Api\Data\InvoiceInterface;
/**
 * interface CustomFieldInterdace
 *
 * @api
 */
interface InvoiceGuestInterface 
{
    /**
     * @param string $cartId
     * 
     * @param Boostsales\CustomCheckout\Api\Data\InvoiceInterface $checkoutInvoiceEmail
     * 
     * @return Boostsales\CustomCheckout\Api\Data\InvoiceInterface
     */
    public function save(string $cartId, InvoiceInterface $checkoutInvoiceEmail);

}