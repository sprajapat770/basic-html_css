<?php


namespace Suraj\Test\Controller\Adminhtml\HelloWorld;


use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\HttpGetActionInterface;

use Magento\Framework\View\Result\PageFactory;

class Index extends Action implements HttpGetActionInterface
{
    const MENU_ID = 'Suraj_Test::greetings_helloworld';


    /**
     * @var PageFactory
     */
    private $pageFactory;


    /**
     * HelloWorld constructor.
     */
    public function __construct(Context $context,PageFactory $pageFactory)
    {
        parent::__construct($context);
        $this->pageFactory = $pageFactory;
    }

    public function execute()
    {
        $resultPage = $this->pageFactory->create();
        $resultPage->setActiveMenu(static::MENU_ID);
        $resultPage->getConfig()->getTitle()->prepend(__('Hello World'));

        return $resultPage;

    }
}
