<?php 
namespace Boostsales\CustomCheckout\Model;

use Boostsales\CustomCheckout\Api\InvoiceGuestInterface;
use Boostsales\CustomCheckout\Api\Data\InvoiceInterface;
use Magento\Quote\Model\QuoteIdMaskFactory;
use Magento\Quote\Api\CartRepositoryInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Sales\Model\Order;

class InvoiceGuest implements InvoiceGuestInterface
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
    * @param string $cartId
    *
    * @param Boostsales\CustomCheckout\Api\Data\InvoiceInterface $checkoutInvoiceEmail
    *
    * @throws CouldNotSaveException
    * @throws NoSuchEntityException
    */
    public function save(string $cartId,InvoiceInterface $checkoutInvoiceEmail){
        $quoteMaskId = $this->quoteMaskFactory->create()->load($cartId,'masked_id'); 
        $cart = $this->cartRepository->getActive((int)$quoteMaskId->getQuoteId());
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