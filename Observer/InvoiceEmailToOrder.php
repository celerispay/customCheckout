<?php 

namespace Boostsales\CustomCheckout\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Observer;

class InvoiceEmailToOrder implements ObserverInterface
{
    public function execute(Observer $observer){

        $order = $observer->getEvent()->getOrder();
        $quote = $observer->getEvent()->getQuote();

        $order->setData('checkout_invoice_email',$quote->getData('checkout_invoice_email'));
    }
}