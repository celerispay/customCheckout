<?php

namespace Boostsales\CustomCheckout\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Observer;
use Psr\Log\LoggerInterface;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Framework\Translate\Inline\StateInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Sales\Model\Order\Address\Renderer;
use Magento\Payment\Helper\Data as PaymentHelper;

class InvoiceEmailSender implements ObserverInterface
{
    protected $transportBuilder;
    protected $storeManager;
    protected $inlineTranslation;
    protected $addressRenderer;
    protected $paymentHelper;
    protected $_scopeConfig;
    
    const XML_PATH_EMAIL_IDENTITY = 'trans_email/ident_general/email';
    const XML_PATH_EMAIL_NAME = 'trans_email/ident_general/name';
    const XML_PATH_EMAIL_TEMPLATE = 'sales_email/invoice/template';
    const XML_PATH_GUEST_EMAIL_TEMPLATE = 'sales_email/invoice/guest_template';

    public function __construct(
        TransportBuilder $transportBuilder,
        StoreManagerInterface $storeManager,
        StateInterface $state,
	LoggerInterface $logger,
	Renderer $addressRenderer,
	PaymentHelper $paymentHelper,
	\Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
    )
    {
        $this->transportBuilder = $transportBuilder;
        $this->storeManager = $storeManager;
        $this->inlineTranslation = $state;
	$this->logger = $logger;
	$this->addressRenderer = $addressRenderer;
	$this->paymentHelper = $paymentHelper;
	$this->_scopeConfig = $scopeConfig;
    }

    public function execute(Observer $observer){
	
        $invoice = $observer->getEvent()->getInvoice();
	$order = $invoice->getOrder();
	$storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
	if(!$order->getCheckoutInvoiceEmail() || is_null($order->getCheckoutInvoiceEmail())){
		return $this;
	}
        $fromEmail = $this->_scopeConfig->getValue(self::XML_PATH_EMAIL_IDENTITY,$storeScope);
        $fromName = $this->_scopeConfig->getValue(self::XML_PATH_EMAIL_NAME,$storeScope);
	try {	
            $from = ['email' => $fromEmail, 'name' => $fromName];
            $this->inlineTranslation->suspend();
	    if($order->getCustomerIsGuest()){
        	$templateId = $this->_scopeConfig->getValue(self::XML_PATH_GUEST_EMAIL_TEMPLATE,$storeScope);
	    }else{
		$templateId = $this->_scopeConfig->getValue(self::XML_PATH_EMAIL_TEMPLATE,$storeScope);
	    }
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
		'payment_html' => $this->paymentHelper->getInfoBlockHtml($order->getPayment(),$order->getStore()->getStoreId()),
                'store' => $order->getStore(),
                'formattedShippingAddress' => $this->addressRenderer->format($order->getShippingAddress(), 'html'),
                'formattedBillingAddress' => $this->addressRenderer->format($order->getBillingAddress(),'html'),
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
