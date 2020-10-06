<?php

namespace Suraj\Test\Observer;

use Magento\Customer\Model\Session;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\App\Http\Context as AuthContext;
class MyObserver implements ObserverInterface{

    /**Aut
     * MyObserver constructor.
     * @param Session $session
     * @param AuthContext $auth
     */
    protected $session;
    protected $auth;
    public function __construct(Session $session,AuthContext $auth)
    {
        $this->auth = $auth;
        $this->session = $session;
    }

    public function execute(Observer $observer)
    {
        if($this->session->isLoggedIn()) {
            $product = $observer->getEvent()->getProduct();
            $quantity = $product->getData('cart_qty');
            $price = $product->getData('price');
            if ($quantity <= 1 && $price < "50") {
                $price = ($price / 100) * 95;
                $product->setPrice($price);
            }
        }
/*
        $islogged =   $this->auth->getValue(\Magento\Customer\Model\Context::CONTEXT_AUTH);
        if ($islogged){
        }
        else{
            echo "not Logged in";
        }*/
    }
}
