<?php 

namespace Boostsales\CustomCheckout\Block\Order;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Framework\Registry;
use Magento\Sales\Model\Order;
use Boostsales\CustomCheckout\Api\InvoiceGuestInterface;
use Boostsales\CustomCheckout\Api\Data\InvoiceInterface;

class InvoiceEmail extends Template
{

    protected $coreRegistry = null;


    protected $invoiceGuest;

    public function __construct(
        Registry $coreRegistry,
        Context $context,
        InvoiceInterface $invoiceGuest,
        array $data = []
    ){
        $this->coreRegistry = $coreRegistry;
        $this->invoiceGuest = $invoiceGuest;
        parent::__construct($context, $data);
    }

    public function getOrder(){
        return $this->coreRegistry->registry('current_order');
    }

    public function getInvoiceEmail(Order $order){
        if (!$order->getId()) {
                return;
        }
        if($order->getData('checkout_invoice_email')){
            $this->invoiceGuest->setCheckoutInvoiceEmail($order->getData('checkout_invoice_email'));
            return $this->invoiceGuest->getCheckoutInvoiceEmail();
        }else{
            return false;
        }
    }

    public function getPoNumber(Order $order){
        if (!$order->getId()) {
                return;
        }
        if($order->getData('po_number')){
            $this->invoiceGuest->setPoNumber($order->getData('po_number'));
            return $this->invoiceGuest->getPoNumber();
        }else{
            return false;
        }
    }

}