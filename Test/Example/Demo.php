<?php


namespace Suraj\Test\Example;
use Magento\Customer\Model\Customer as CustomerModel;
use Magento\Customer\Model\ResourceModel\Customer as CustomerResource;

class Demo
{
    public $customer;
    public $resource;
    public function __construct(CustomerModel $customer, CustomerResource $resource){
        $this->customer = $customer;
        $this->resource = $resource;
    }

}
