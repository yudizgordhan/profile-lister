<?php

namespace Yudiz\Freelancer\Block\Frontend;

use Magento\Customer\Model\Session;

class FreelancerCollection extends \Magento\Framework\View\Element\Template
{
    public $freelancerCollection;
    public $customerSession;

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Yudiz\Freelancer\Model\ResourceModel\Freelancer\CollectionFactory $freelancerCollection,
        \Magento\Framework\Message\ManagerInterface $messageManager,
        Session $customerSession,
        array $data = []
    ) {
        $this->customerSession = $customerSession;
        $this->freelancerCollection = $freelancerCollection;
        $this->messageManager = $messageManager;
        parent::__construct($context, $data);
    }

    public function getFreelancers()
    {
        $customerId = $this->customerSession->getCustomerId();
        $page = ($this->getRequest()->getParam('p'))? $this->getRequest()->getParam('p') : 1;
        $limit = ($this->getRequest()->getParam('limit'))? $this->getRequest()->getParam('limit') : 20;
        $collection = $this->freelancerCollection->create()
                        ->addFieldToFilter('user_id', ['neq' => $customerId])
                        ->addFieldToFilter('is_active', 1)
                        ->setPageSize($limit)
                        ->setCurPage($page);

        if ($collection && count($collection)) {
            return $collection;
        } else {
            $this->messageManager->addNoticeMessage(__('No Any Freelancer List Available.'));
        }
    }

    protected function _prepareLayout()
    {
        parent::_prepareLayout();
        if ($this->getFreelancers()) {
            $pager = $this->getLayout()->createBlock(\Magento\Theme\Block\Html\Pager::class, 'freelancer.list.pager')
                                    ->setAvailableLimit([12=>12,24=>24,36=>36,48=>48])
                                    ->setShowPerPage(true)
                                    ->setCollection($this->getFreelancers());
            $this->setChild('pager', $pager);
            $this->getFreelancers()->load();
        }

        return $this;
    }
    
    public function getPagerHtml()
    {
        return $this->getChildHtml('pager');
    }
}
