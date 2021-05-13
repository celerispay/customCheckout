<?php 
namespace Boostsales\CustomCheckout\Model;

use Boostsales\CustomCheckout\Api\InvoiceRegisteredInterface;
use Boostsales\CustomCheckout\Api\Data\InvoiceInterface;
use Magento\Quote\Model\QuoteIdMaskFactory;
use Magento\Quote\Api\CartRepositoryInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Sales\Model\Order;

class InvoiceRegistered implements InvoiceRegisteredInterface
{
    protected $cartRepository;

    protected $quoteMaskFactory;
    
    public function __construct(
        QuoteIdMaskFactory $quoteMaskFactory,
        CartRepositoryInterface $cartRepository
    ){
        $this->cartRepository = $cartRepository;
        $this->quoteMaskFactory = $quoteMaskFactory;
    }

    /*
    * save invoice email to quote
    *
    * @param int $cartId
    *
    * @param Boostsales\CustomCheckout\Api\Data\InvoiceInterface $checkoutInvoiceEmail
    *
    * @throws CouldNotSaveException
    * @throws NoSuchEntityException
    */
    public function save(int $cartId,InvoiceInterface $checkoutInvoiceEmail){
        $cart = $this->cartRepository->getActive($cartId);
        if (!$cart->getItemsCount()) {
            throw new NoSuchEntityException(__('Cart %1 is empty', $cartId));
        }
        try{
            $cart->setData('checkout_invoice_email',
                $checkoutInvoiceEmail->getCheckoutInvoiceEmail()
            );
            $this->cartRepository->save($cart); 
        }catch(\Exception $e){
            throw new CouldNotSaveException(__('Invoice could not be saved!'));
        }
    }
}