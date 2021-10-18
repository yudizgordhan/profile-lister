<?php
namespace Yudiz\Freelancer\Controller\Account;

use Magento\Customer\Controller\AbstractAccount;
use Magento\Framework\App\Action\Context;

class Deleteimage extends AbstractAccount
{
    public $imageFactory;
    public $freelancerFactory;
    protected $datahelper;

    public function __construct(
        Context $context,
        \Yudiz\Freelancer\Model\ImageFactory $imageFactory,
        \Yudiz\Freelancer\Helper\Data $datahelper,
        \Yudiz\Freelancer\Model\FreelancerFactory $freelancerFactory,
        \Magento\Framework\Json\Helper\Data $jsonData,
        \Magento\Framework\Controller\Result\ForwardFactory $forwardFactory
    ) {
        $this->imageFactory = $imageFactory;
        $this->freelancerFactory = $freelancerFactory;
        $this->jsonData = $jsonData;
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
        $imageId = $this->getRequest()->getParam('id');
        $model = $this->imageFactory->create()->load($imageId);
        $model->delete();
        $success=1;
        $this->getResponse()->setHeader('Content-type', 'application/javascript');
        $this->getResponse()->setBody(
            $this->jsonData->jsonEncode([
                    'success' => $success
            ])
        );
    }
}
