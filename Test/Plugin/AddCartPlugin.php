<?php

namespace Suraj\Test\Plugin;

use Magento\Checkout\Model\Cart;
use Magento\Customer\Model\Session;
use Magento\Framework\App\Http\Context as AuthContext;

class AddCartPlugin
{

    /**Aut
     * MyObserver constructor.
     * @param Session $session
     * @param AuthContext $auth
     */
    protected $customerSession;
    protected $httpAuth;
    protected $productPrice;
    protected $productQty;
    public function __construct(Session $session,AuthContext $auth){
        $this->httpAuth = $auth;
        $this->customerSession = $session;
    }

  /*  public function beforeupdateItems(Cart $subject, $data){
        $quote = $subject->getQuote();

        $allItems = $quote->getAllItems();
        foreach ($allItems as $key => $item){
            $basePrice =  $item->getBasePrice();
            $qty = $item->getQty();
            if ($qty<=1 && $basePrice < 20){
                $basePrice = ($basePrice/100)*95;
                $item->setPrice($basePrice);
               // $item->save();
            }
        }
        return [$data];
    }*/
  /*  public function aroundupdateItems(Cart $subject, callable $calleble, $argum){
        $result = $calleble($argum);
        $quote = $result->getQuote();
        $allItems = $quote->getAllItems();
        foreach ($allItems as $key => $item){
            $basePrice =  $item->getBasePrice();
            $qty = $item->getQty();
            if ($qty<=1 && $basePrice < 20){
                $basePrice = ($basePrice/100)*95;
                $item->setFinalPrice($basePrice);
                $item->save();
            }
        }
        return $result;
    }
  */
    public function afterUpdateItems(Cart $subject, $result){
        $quote = $subject->getQuote();
        $allItems = $quote->getAllItems();
        foreach ($allItems as $key => $item){
           $basePrice =  $item->getBasePrice();
           $qty = $item->getQty();
           if ($qty<=1 && $basePrice < 20){
               $basePrice = ($basePrice/100)*95;
               //$item->setFinalPrice($basePrice);
               //$item->save();
           }
        }
        return $result;
    }
}
