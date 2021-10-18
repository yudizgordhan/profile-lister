<?php
namespace Yudiz\Freelancer\Controller\Adminhtml\Freelancer;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Magento\Ui\Component\MassAction\Filter;
use Yudiz\Freelancer\Model\ResourceModel\Freelancer\CollectionFactory;

class MassStatus extends Action
{
    public $collectionFactory;

    public $filter;

    public function __construct(
        Context $context,
        Filter $filter,
        CollectionFactory $collectionFactory
    ) {
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        try {
            $collection = $this->filter->getCollection($this->collectionFactory->create());
            $status = $this->getRequest()->getParam('status');
            $statusLabel = $status ? "enabled" : "disabled";
            $count = 0;
            foreach ($collection as $model) {
                $model->setIsActive($status);
                $model->save();
                $count++;
            }
            $this->messageManager->addSuccess(__('A total of %1 record(s) have been %2.', $count, $statusLabel));
        } catch (\Exception $e) {
            $this->messageManager->addError(__($e->getMessage()));
        }
        return $this->resultFactory->create(ResultFactory::TYPE_REDIRECT)->setPath('*/*/index');
    }

    public function _isAllowed()
    {
        return $this->_authorization->isAllowed('Yudiz_Freelancer::edit');
    }
}
