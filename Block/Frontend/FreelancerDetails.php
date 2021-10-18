<?php

namespace Yudiz\Freelancer\Block\Frontend;

use Magento\Customer\Model\Session;

class FreelancerDetails extends \Magento\Framework\View\Element\Template
{
    public $freelancerCollection;
    public $imageCollection;
    public $customerSession;

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Yudiz\Freelancer\Model\ResourceModel\Freelancer\CollectionFactory $freelancerCollection,
        \Yudiz\Freelancer\Model\ResourceModel\Image\CollectionFactory $imageCollection,
        \Magento\Framework\Message\ManagerInterface $messageManager,
        Session $customerSession,
        array $data = []
    ) {
        $this->freelancerCollection = $freelancerCollection;
        $this->imageCollection = $imageCollection;
        $this->customerSession = $customerSession;
        $this->messageManager = $messageManager;
        parent::__construct($context, $data);
    }

    // Get freelancer details using this method
    
    public function getFreelancerlist()
    {
        $customerId = $this->customerSession->getCustomerId();
        $collection = $this->freelancerCollection->create()
                                ->addFieldToFilter('user_id', $customerId);
        return $collection->getFirstItem();
    }

    // Get Multiple Images using this method
    public function getMultipleImage($multiplecollection)
    {
        $entityid = $multiplecollection->getEntityId();
        $imgcollection = $this->imageCollection->create()
                        ->addFieldToFilter('freelancer_id', $entityid);
        return $imgcollection;
    }
}
