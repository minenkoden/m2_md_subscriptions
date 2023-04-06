<?php

namespace MD\Subscriptions\Controller\Adminhtml;

use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class Subscription extends \Magento\Backend\App\Action
{
    protected $_resultPageFactory;

    public function __construct(Context $context, PageFactory $resultPageFactory)
    {
        parent::__construct($context);
        $this->_resultPageFactory = $resultPageFactory;
    }

    public function execute()
    {
        die('asdwasd');
        $resultPage = $this->_resultPageFactory->create();
        $resultPage->setActiveMenu('MD_Subscriptions::subscriptions');
        $resultPage->getConfig()->getTitle()->prepend(__('Subscriptions'));
        return $resultPage;
    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('MD_Subscriptions::subscriptions');
    }
}