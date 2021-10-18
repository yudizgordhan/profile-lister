<?php

namespace Yudiz\Freelancer\Block\Adminhtml\Freelancer\Edit\Tab;

use Magento\Backend\Block\Widget\Form\Generic;
use Magento\Backend\Block\Widget\Tab\TabInterface;
use Magento\Store\Model\StoreManagerInterface;

class CoverImage extends Generic implements TabInterface
{
    public $_systemStore;
    public $_coreRegistry;
    public $_storeManager;
    public $imageCollection;
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        \Magento\Store\Model\System\Store $systemStore,
        \Yudiz\Freelancer\Model\ResourceModel\Image\CollectionFactory $imageCollection,
        StoreManagerInterface $storemanager,
        array $data = []
    ) {
        $this->_coreRegistry = $registry;
        $this->_systemStore = $systemStore;
        $this->imageCollection = $imageCollection;
        parent::__construct($context, $registry, $formFactory, $data);
    }
    public function getTabLabel()
    {
        return __(' Freelancer Cover Image');
    }
    public function getTabTitle()
    {
        return __(' Freelancer Cover Image ');
    }
    public function canShowTab()
    {
        return true;
    }
    public function isHidden()
    {
        return false;
    }
    public function _prepareForm()
    {
        $mediaDirectory = $this->_storeManager->getStore()
            ->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
        $model = $this->_coreRegistry->registry('freelancer_data');
        $form = $this->_formFactory->create();
        $form->setHtmlIdPrefix('freelancer_');
        $fieldset = $form->addFieldset(
            'base_fieldset',
            ['legend' => __(' Freelancer Cover Image'), 'class' => 'fieldset-wide']
        );
        $fieldset->addField('entity_id', 'hidden', ['name' => 'entity_id']);
        $freelancerId = $model->getEntityId();
        $imgcollection = $this->imageCollection->create()->addFieldToFilter('freelancer_id', $freelancerId);
        return $imgcollection;
    }
    public function getFormHtml()
    {
        $html = parent::getFormHtml();
        $html .= $this->setTemplate('Yudiz_Freelancer::coverimage.phtml')->toHtml();
        return $html;
    }
}
