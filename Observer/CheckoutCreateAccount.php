<?php

namespace Boostsales\CustomCheckout\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Observer;
use Magento\Sales\Api\Data\OrderInterface;
use Magento\Sales\Api\OrderRepositoryInterface;
use Magento\Sales\Api\OrderCustomerManagementInterface;
use Magento\Sales\Model\OrderFactory;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Customer\Model\CustomerFactory;
use Magento\Customer\Model\Session;
use Magento\Framework\Api\SearchCriteriaBuilder;

class CheckoutCreateAccount implements ObserverInterface{

    protected $orderRepository;
    protected $storeManagerInterface;
    protected $customerFactory;
    protected $customerSession;
    protected $searchCriteriaBuilder;

    public function __construct(
        OrderRepositoryInterface $orderRepository,
        OrderCustomerManagementInterface $orderCustomerManagementInterface,
        OrderFactory $orderFactory,
        StoreManagerInterface $storeManagerInterface,
        CustomerFactory $customerFactory,
        Session $customerSession,
        SearchCriteriaBuilder $searchCriteriaBuilder
    )
    {
        $this->orderRepository = $orderRepository;
        $this->customerSession = $customerSession;
        $this->customerFactory = $customerFactory;
        $this->storeManagerInterface = $storeManagerInterface;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;

    }

    public function execute(Observer $observer){
        if(empty($this->customerSession->getCustomerPass())){
            return $this;
        }
        $orderData = $observer->getEvent()->getOrder();
        $store = $this->storeManagerInterface->getStore();
        $websiteId = $this->storeManagerInterface->getStore()->getWebsiteId();
        $customer = $this->customerFactory->create();
        $customer->setWebsiteId($websiteId);
        $passwrd = $this->customerSession->getCustomerPass();
        $secret_key = "f75c0fa7-5609-4645-bb7b-6aed5ad030f2";
        $key = hash('sha256', $secret_key);
        $iv = substr(hash('sha256', '4ebd0208-8328-5d69-8c44-ec50939c0967'), 0, 16);
        $decrpPasswrd = openssl_decrypt($passwrd,'AES-256-CBC',$key, OPENSSL_RAW_DATA, $iv);
        if(!$customer->getId() && is_null($customer->getEmail())){
            $customer->setWebsiteId($websiteId)
                    ->setStore($store)
                    ->setFirstname($orderData->getCustomerFirstName())
                    ->setLastname($orderData->getCustomerLastname())
                    ->setEmail($orderData->getCustomerEmail())
                    ->setPassword($decrpPasswrd);
            $customer->save();
            $orderData->setCustomerIsGuest(0);
            $orderData->setCustomerId($customer->getId());
        }
    }
}