<?php 
namespace Boostsales\CustomCheckout\Model\Data;

use Boostsales\CustomCheckout\Api\Data\InvoiceInterface;
use Magento\Framework\Api\AbstractExtensibleObject;

class Invoice extends AbstractExtensibleObject implements InvoiceInterface
{
    /*
    * Get Invoice email
    *   
    * @return string|null 
    */

    public function getCheckoutInvoiceEmail(){
        return $this->_get('checkout_invoice_email');
    }

    /*
    * set Invoice email
    *
    * @param string $checkoutInvoiceEmail
    *
    * @return void
    */

    public function setCheckoutInvoiceEmail(string $checkoutInvoiceEmail){
        return $this->setData('checkout_invoice_email',$checkoutInvoiceEmail);
    }

     /*
    * Get Po Number
    *   
    * @return string|null 
    */
    public function getPoNumber(){
        return $this->_get('po_number');
    } 

    /*
    * set Po Number
    *
    * @param string $poNumber
    *
    * @return void
    *
    */
    public function setPoNumber(string $poNumber){
        return $this->setData('po_number',$poNumber);
    }
}