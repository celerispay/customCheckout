<?php 

namespace Boostsales\CustomCheckout\Api\Data;
use Magento\Sales\Model\Order;

/**
 * interface CustomFieldInterdace
 *
 * @api
 */
interface InvoiceInterface 
{
    
    /**
     * Get Invoice Email
     *
     * @return string
     */
    public function getCheckoutInvoiceEmail();


    /**
     * Set Invoice Email
     * @param string $checkoutInvoiceEmail
     * @return void
     */
    public function setCheckoutInvoiceEmail(string $checkoutInvoiceEmail);

        /**
     * Set PO Number Email
     * @param string $poNumber
     * @return void
     */
    public function setPoNumber(string $poNumber);

        /**
     * Get PO Number Email
     *
     * @return string
     */
    public function getPoNumber();
}