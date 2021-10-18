<?php
namespace Yudiz\Freelancer\Controller\Adminhtml\Freelancer;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;

class Delete extends Action
{
    public $freelancerFactory;
    
    public function __construct(
        Context $context,
        \Yudiz\Freelancer\Model\FreelancerFactory $freelancerFactory
    ) {
        $this->freelancerFactory = $freelancerFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $id = $this->getRequest()->getParam('id');
        try {
            $blogModel = $this->freelancerFactory->create();
            $blogModel->load($id);
            $blogModel->delete();
            $this->messageManager->addSuccessMessage(__('You deleted the Freelancer Details.'));
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        }
        return $resultRedirect->setPath('*/*/');
    }

    public function _isAllowed()
    {
        return $this->_authorization->isAllowed('Yudiz_Freelancer::delete');
    }
}
