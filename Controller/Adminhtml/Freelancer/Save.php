<?php
namespace Yudiz\Freelancer\Controller\Adminhtml\Freelancer;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\HTTP\PhpEnvironment\Request;

class Save extends Action
{
    public $freelancerFactory;
    protected $request;
    protected $datahelper;

    public function __construct(
        Context $context,
        Request $request,
        \Yudiz\Freelancer\Helper\Data $datahelper,
        \Yudiz\Freelancer\Model\FreelancerFactory $freelancerFactory
    ) {
        $this->freelancerFactory = $freelancerFactory;
        $this->request = $request;
        $this->datahelper = $datahelper;
        parent::__construct($context);
    }

    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getParams();
        $model = $this->freelancerFactory->create()->load($data['entity_id']);
        $files = $this->request->getFiles()->toArray(); // same as $_FIELS
        try {
            if (isset($data['entity_id']) && $data['entity_id']) {
                if (isset($files['profile_image']['name']) && $files['profile_image']['name'] != '') {
                    $data['profile_image'] = $this->datahelper->getprofileImage($data);
                } else {
                    $data['profile_image'] = $model->getProfileImage();
                }
                $model = $this->freelancerFactory->create()->load($data['entity_id']);
                $data['slug'] = $this->datahelper->getSlug($data['full_name'], $model);
                if ($this->datahelper->checkEmail($data['email_id'], $data['entity_id'], $model) == false) {
                    $this->messageManager->addErrorMessage(__('Email ID Already exists!'));
                    return $this->_redirect('customer/freelancer/edit', ['id' => $model->getId()]);
                }
                if ($this->datahelper->checkMobile($data['mobile_number'], $data['entity_id'], $model) == false) {
                    $this->messageManager->addErrorMessage(__('Mobile Number Already exists!'));
                    return $this->_redirect('customer/freelancer/edit', ['id' => $model->getId()]);
                }
                $model->setFullName($data['full_name'])
                        ->setEmailId($data['email_id'])
                        ->setMobileNumber($data['mobile_number'])
                        ->setLocationDetails($data['location_details'])
                        ->setProfileImage($data['profile_image'])
                        ->setSkillDetails($data['skill_details'])
                        ->setSummaryDetails($data['summary_details'])
                        ->setIsActive($data['is_active'])
                        ->setSlug($data['slug'])
                        ->save();

                $lastId = $model->getId();
                if (isset($files['multiple_image'][0]['name']) && !empty($files['multiple_image'][0]['name'])) {
                    $this->datahelper->getCoverImage($files, $lastId, $data);
                }
                $this->messageManager->addSuccess(__('You have updated the Freelancer Details successfully.'));
            }
            return $resultRedirect->setPath('*/*/');
        } catch (LocalizedException $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
            return $this->_redirect('customer/freelancer/edit', ['id' => $model->getId()]);
        }
    }

    public function _isAllowed()
    {
        return $this->_authorization->isAllowed('Yudiz_Freelancer::save');
    }
}
