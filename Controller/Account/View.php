<?php
namespace Yudiz\Freelancer\Controller\Account;

use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class View extends \Magento\Framework\App\Action\Action
{
    protected $datahelper;

    public function __construct(
        Context $context,
        \Yudiz\Freelancer\Helper\Data $datahelper,
        PageFactory $resultPageFactory,
        \Magento\Framework\Controller\Result\ForwardFactory $forwardFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->datahelper = $datahelper;
        $this->_forwardFactory = $forwardFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        //if module not activated
        $isModuleEnable = $this->datahelper->isEnable();
        if (!$isModuleEnable) {
            $resultForward = $this->_forwardFactory->create();
            $resultForward->setController('index');
            $resultForward->forward('defaultNoRoute');
            return $resultForward;
        }
        $resultPage = $this->resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->set(__('Freelancer Profile'));
        $layout = $resultPage->getLayout();
        return $resultPage;
    }
}
