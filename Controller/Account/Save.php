<?php
namespace Yudiz\Freelancer\Controller\Account;

use Magento\Customer\Controller\AbstractAccount;
use Magento\Framework\App\Action\Context;
use Magento\Customer\Model\Session;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\HTTP\PhpEnvironment\Request;

class Save extends AbstractAccount
{
    public $freelancerFactory;
    public $customerSession;
    public $messageManager;
    protected $request;
    protected $datahelper;

    public function __construct(
        Context $context,
        Request $request,
        \Yudiz\Freelancer\Model\FreelancerFactory $freelancerFactory,
        \Yudiz\Freelancer\Helper\Data $datahelper,
        Session $customerSession,
        \Magento\Framework\Message\ManagerInterface $messageManager,
        \Magento\Framework\Controller\Result\ForwardFactory $forwardFactory
    ) {
        $this->freelancerFactory = $freelancerFactory;
        $this->customerSession = $customerSession;
        $this->datahelper = $datahelper;
        $this->request = $request;
        $this->_forwardFactory = $forwardFactory;
        $this->messageManager = $messageManager;
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
        // get all form data in $data variable using getrequest/getparams
        $data = $this->getRequest()->getParams();
        $customerId = $this->customerSession->getCustomerId();
        $files = $this->request->getFiles()->toArray(); // same as $_FIELS
        $model = $this->freelancerFactory->create(); // Model load of freelancer
        try {
            if (isset($data['id']) && $data['id']) {
                if (isset($files['profile_image']['name']) && $files['profile_image']['name'] != '') {
                    $data['profile_image'] = $this->datahelper->getprofileImage($data);
                } else {
                    $data['profile_image'] = $model->getProfileImage();
                }
                $model = $this->freelancerFactory->create()->load($data['id']);
                $data['slug'] = $this->datahelper->getSlug($data['full_name'], $model);

                if ($this->datahelper->checkEmail($data['email_id'], $data['id'], $model) == false) {
                    $this->messageManager->addErrorMessage(__('Email ID Already exists!'));
                    return $this->_redirect('freelancer/account');
                }
                if ($this->datahelper->checkMobile($data['mobile_number'], $data['id'], $model) == false) {
                    $this->messageManager->addErrorMessage(__('Mobile Number Already exists!'));
                    return $this->_redirect('freelancer/account');
                }
                $model->setFullName($data['full_name'])
                        ->setEmailId($data['email_id'])
                        ->setMobileNumber($data['mobile_number'])
                        ->setLocationDetails($data['location_details'])
                        ->setProfileImage($data['profile_image'])
                        ->setSkillDetails($data['skill_details'])
                        ->setSummaryDetails($data['summary_details'])
                        ->setSlug($data['slug'])
                        ->save();
                $lastId = $model->getId();
                if (isset($files['multiple_image'][0]['name']) && !empty($files['multiple_image'][0]['name'])) {
                    $this->datahelper->getCoverImage($files, $lastId, $data);
                }
                $this->messageManager->addSuccess(__('You have updated freelancer profile details successfully.'));
            } else {
                if (isset($files['profile_image']['name']) && $files['profile_image']['name'] != '') {
                    $data['profile_image'] = $this->datahelper->getprofileImage($data);
                }
                $data['slug'] = $this->datahelper->getSlug($data['full_name'], $model);
                if ($this->datahelper->checkEmail($data['email_id'], -1, $model) == false) {
                    $this->messageManager->addErrorMessage(__('Email ID Already exists!'));
                    return $this->_redirect('freelancer/account');
                }
                if ($this->datahelper->checkMobile($data['mobile_number'], -1, $model) == false) {
                    $this->messageManager->addErrorMessage(__('Mobile Number Already exists!'));
                    return $this->_redirect('freelancer/account');
                }
                $model->setData($data);
                $model->setUserId($customerId);
                $model->save();
                $lastId = $model->getId();
                if (isset($files['multiple_image']) && $files['multiple_image'] != '') {
                    $this->datahelper->getCoverImage($files, $lastId, $data);
                }
                $this->messageManager->addSuccess(__('Freelancer Profile created successfully.'));
            }
            return $this->resultRedirectFactory->create()->setPath('freelancer/account');
        } catch (LocalizedException $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
            return $this->_redirect('freelancer/account');
        }
    }
}
