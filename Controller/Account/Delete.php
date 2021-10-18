<?php
namespace Yudiz\Freelancer\Controller\Account;

use Magento\Customer\Controller\AbstractAccount;
use Magento\Framework\App\Action\Context;
use Magento\Customer\Model\Session;

class Delete extends AbstractAccount
{
    public $freelancerFactory;
    public $customerSession;
    public $messageManager;
    protected $datahelper;

    public function __construct(
        Context $context,
        \Yudiz\Freelancer\Model\FreelancerFactory $freelancerFactory,
        Session $customerSession,
        \Magento\Framework\Json\Helper\Data $jsonData,
        \Yudiz\Freelancer\Helper\Data $datahelper,
        \Magento\Framework\Message\ManagerInterface $messageManager,
        \Magento\Framework\Controller\Result\ForwardFactory $forwardFactory
    ) {
        $this->freelancerFactory = $freelancerFactory;
        $this->customerSession = $customerSession;
        $this->jsonData = $jsonData;
        $this->messageManager = $messageManager;
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
        $freelancerId = $this->getRequest()->getParam('id');
        $model = $this->freelancerFactory->create()->load($freelancerId);
        $model->delete();
        $msg=__('You have successfully deleted your freelancer profile.');
        $success=1;
        $this->messageManager->addSuccess(__('You have successfully deleted your freelancer profile.'));

        $this->getResponse()->setHeader('Content-type', 'application/javascript');
        $this->getResponse()->setBody(
            $this->jsonData->jsonEncode([
                'success' => $success,
                'message' => $msg
            ])
        );
    }
}
