<?php

namespace Yudiz\Freelancer\Block\Adminhtml\Freelancer;

class Edit extends \Magento\Backend\Block\Widget\Form\Container
{
    protected $_coreRegistry = null;

    public function __construct(
        \Magento\Backend\Block\Widget\Context $context,
        \Magento\Framework\Registry $registry,
        array $data = []
    ) {
        $this->_coreRegistry = $registry;
        parent::__construct($context, $data);
    }

    protected function _construct()
    {
        $this->_objectId = 'id';
        $this->_blockGroup = 'Yudiz_Freelancer';
        $this->_controller = 'adminhtml_freelancer';
        parent::_construct();

        $item = $this->_coreRegistry->registry('freelancer_data');
        if ($item->getEntityId()) {
            $this->addButton(
                'delete',
                [
                    'label' => __('Delete'),
                    'onclick' => 'deleteConfirm(' . json_encode(__('Are you sure you want to do this?'))
                        . ',' . json_encode($this->getDeleteUrl()) . ')',
                    'class' => 'scalable delete',
                    'level' => -1
                ]
            );
        }
    }

    public function getDeleteUrl()
    {
        $item = $this->_coreRegistry->registry('freelancer_data');

        return $this->getUrl('customer/freelancer/delete/id/'.$item->getEntityId());
    }
}
