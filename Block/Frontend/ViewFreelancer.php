<?php

namespace Yudiz\Freelancer\Block\FrontEnd;

class ViewFreelancer extends \Magento\Framework\View\Element\Template
{
    public $freelancerFactory;
    public $imageCollection;

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Yudiz\Freelancer\Model\FreelancerFactory $freelancerFactory,
        \Yudiz\Freelancer\Model\ResourceModel\Image\CollectionFactory $imageCollection,
        array $data = []
    ) {
        $this->freelancerFactory = $freelancerFactory;
        $this->imageCollection = $imageCollection;
        parent::__construct($context, $data);
    }

    public function getviewFreelancer()
    {
        $freelancerSlug = $this->getRequest()->getParam('details');
        $collection = $this->freelancerFactory->create()->getCollection()
                    ->addFieldToFilter('slug', $freelancerSlug);
        if ($collection->getSize()) {
            $freelancerId = $collection->getFirstItem()->getEntityId();
        }
        return $this->freelancerFactory->create()->load($freelancerId);
    }

    public function getViewMultipleImages()
    {
        $imageId = $this->getRequest()->getParam('id');
        $imgcollection = $this->imageCollection->create()
                        ->addFieldToFilter('freelancer_id', $imageId);
        return $imgcollection;
    }
}
