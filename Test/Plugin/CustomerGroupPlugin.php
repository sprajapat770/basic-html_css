<?php


namespace Suraj\Test\Plugin;


use Magento\Customer\Model\Session;
use Magento\Framework\App\Http\Context as AuthContext;

class CustomerGroupPlugin
{
    /**Aut
    *
    * @param Session $session
    * @param AuthContext $auth
    */
    protected $customerSession;
    protected $httpAuth;

    public function __construct(Session $session,AuthContext $auth)
    {
        $this->httpAuth = $auth;
        $this->customerSession = $session;

    }

    public function afterGetName(\Magento\Catalog\Model\Product $subject, $result){
        if($this->httpAuth->getValue(\Magento\Customer\Model\Context::CONTEXT_AUTH)) {
            $customerGroupId=  $this->customerSession->getCustomer()->getGroupId();
            $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
            $groupCollection = $objectManager->create('\Magento\Customer\Model\Group')->load($customerGroupId);
            $result = $groupCollection->getCustomerGroupCode()." world ".$result;
        }
        return $result;
    }
}
