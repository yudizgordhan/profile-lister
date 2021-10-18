<?php
namespace Yudiz\Freelancer\Controller\Lists;

use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class Index extends \Magento\Framework\App\Action\Action
{
    protected $dataHelper;

    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        \Yudiz\Freelancer\Helper\Data $datahelper,
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
        $resultPage->getConfig()->getTitle()->set(__('Freelancers List'));
        $layout = $resultPage->getLayout();
        return $resultPage;
    }
}
