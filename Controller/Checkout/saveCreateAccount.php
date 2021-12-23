<?php

namespace Boostsales\CustomCheckout\Controller\Checkout;

use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\Result\ForwardFactory;
use Magento\Framework\View\LayoutFactory;
use Magento\Checkout\Model\Cart;
use Magento\Framework\App\Action\Action;
use Magento\Customer\Model\Session;

class saveCreateAccount extends Action
{
    protected $resultForwardFactory;
    protected $layoutFactory;
    protected $cart;
    protected $customerSession;

    public function __construct(
        Context $context,
        ForwardFactory $resultForwardFactory,
        LayoutFactory $layoutFactory,
        Cart $cart,
        Session $customerSession
    )
    {
        $this->resultForwardFactory = $resultForwardFactory;
        $this->layoutFactory = $layoutFactory;
        $this->cart = $cart;
        $this->customerSession = $customerSession;

        parent::__construct($context);
    }

    public function execute()
    {
        $createCustomer = $this->getRequest()->getParam('payload');
        if(!empty($createCustomer)){
            $passwrd = $createCustomer['accountPass'];
            if(!empty($passwrd) && strlen($passwrd) > 0){
                $secret_key = "f75c0fa7-5609-4645-bb7b-6aed5ad030f2";
                $key = hash('sha256', $secret_key);
                $iv = substr(hash('sha256', '4ebd0208-8328-5d69-8c44-ec50939c0967'), 0, 16);
                $encrptPass = openssl_encrypt($passwrd,'AES-256-CBC',$key, OPENSSL_RAW_DATA, $iv);
                $this->customerSession->setCustomerPass($encrptPass);
            }
        }
    }
}