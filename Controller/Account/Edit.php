<?php
namespace Yudiz\Freelancer\Controller\Account;

use Magento\Customer\Controller\AbstractAccount;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Customer\Model\Session;

class Edit extends AbstractAccount
{
    public $resultPageFactory;
    public $freelancerFactory;
    public $customerSession;
    public $messageManager;
    protected $datahelper;

    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        \Yudiz\Freelancer\Helper\Data $datahelper,
        \Yudiz\Freelancer\Model\FreelancerFactory $freelancerFactory,
        Session $customerSession,
        \Magento\Framework\Controller\Result\ForwardFactory $forwardFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->resultPageFactory = $resultPageFactory;
        $this->freelancerFactory = $freelancerFactory;
        $this->customerSession = $customerSession;
        $this->_forwardFactory = $forwardFactory;
        $this->datahelper = $datahelper;
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
        $freelancerId = $this->getRequest()->getParam('id');
        $resultPage = $this->resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->set(__('Edit Freelancer Profile'));
        $layout = $resultPage->getLayout();
        return $resultPage;
    }
}
