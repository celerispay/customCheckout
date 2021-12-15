<?php

namespace Boostsales\CustomCheckout\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Observer;
use Psr\Log\LoggerInterface;

class InvoiceEmailSender implements ObserverInterface
{
        /**
     * @var LoggerInterface
     */
    protected $logger;

    public function __construct(
        LoggerInterface $logger
    ) {
        $this->logger = $logger;
    }

    public function execute(Observer $observer){
        $invoice = $observer->getEvent()->getInvoice();
        $order = $invoice->getOrder();
        $templateId = 'sales_email_invoice_guest_template';
        $fromEmail = 'info@antratek.com';
        $fromName = 'Antratek Electronics';
        try {
            $from = ['email' => $fromEmail, 'name' => $fromName];
            $this->inlineTranslation->suspend();

            $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
            $templateOptions = [
                'area' => \Magento\Framework\App\Area::AREA_FRONTEND,
                'store' => $invoice->getStore()->getId()
            ];
            $templateVars = [
                'order' => $order,
                'order_id' => $order->getId(),
                'invoice' => $invoice,
                'invoice_id' => $invoice->getId(),
                'comment' => $invoice->getCustomerNoteNotify() ? $invoice->getCustomerNote() : '',
                'billing' => $order->getBillingAddress(),
                'store' => $order->getStore(),
                'formattedShippingAddress' => $order->getShippingAddress($order),
                'formattedBillingAddress' => $order->getBillingAddress($order),
                'order_data' => [
                    'customer_name' => $order->getCustomerName(),
                    'is_not_virtual' => $order->getIsNotVirtual(),
                    'email_customer_note' => $order->getEmailCustomerNote(),
                    'frontend_status_label' => $order->getFrontendStatusLabel()
                ]
            ];
            $transport = $this->transportBuilder->setTemplateIdentifier($templateId, $storeScope)
                ->setTemplateOptions($templateOptions)
                ->setTemplateVars($templateVars)
                ->setFrom($from)
                ->addTo($order->getCheckoutInvoiceEmail())
                ->getTransport();
            $transport->sendMessage();
            $this->inlineTranslation->resume();
        } catch (\Exception $e) {
            $this->logger->info($e->getMessage());
        }
    }
}