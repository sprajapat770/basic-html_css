<?php
declare(strict_types=1);
namespace Suraj\Test\Block;

use Magento\Framework\View\Element\Template\Context;

class Display extends \Magento\Framework\View\Element\Template
{
    protected $_data;

    public function __construct(
        Context $context
    ) {
        parent::__construct($context);
    }

    public function sayHello()
    {
        return __('Hello World');
    }
    public function getCustomerData()
    {
        //$this->data = ObjectManager::getInstance()->create(\Suraj\Hello\Model\Data::class);
        //return $this->_data->getCustomerData();
    }
}
