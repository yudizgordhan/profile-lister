<?php

namespace Yudiz\Freelancer\Block\Adminhtml\Freelancer\Edit\Tab;

use Magento\Backend\Block\Widget\Form\Generic;
use Magento\Backend\Block\Widget\Tab\TabInterface;

class Main extends Generic implements TabInterface
{
    protected $_systemStore;

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        \Yudiz\Freelancer\Model\Status $options,
        array $data = []
    ) {
        $this->_options = $options;
        parent::__construct($context, $registry, $formFactory, $data);
    }

    public function getTabLabel()
    {
        return __(' Basic Information');
    }

    public function getTabTitle()
    {
        return __(' Basic Information ');
    }

    public function canShowTab()
    {
        return true;
    }

    public function isHidden()
    {
        return false;
    }

    protected function _prepareForm()
    {
        $dateFormat = $this->_localeDate->getDateFormat(\IntlDateFormatter::SHORT);
        /** @var \Magento\Framework\Data\Form $form */
        $model = $this->_coreRegistry->registry('freelancer_data');
        $form = $this->_formFactory->create();

        $form->setHtmlIdPrefix('freelancer_');
        $fieldset = $form->addFieldset(
            'base_fieldset',
            ['legend' => __(' Basic Information'), 'class' => 'fieldset-wide']
        );
    
        $fieldset->addField('entity_id', 'hidden', ['name' => 'entity_id']);

        $fieldset->addField(
            'full_name',
            'text',
            [
                'name' => 'full_name',
                'label' => __('Full Name'),
                'id' => 'full_name',
                'title' => __('Full Name'),
                'class' => 'required-entry',
                'required' => true,
            ]
        );

        $fieldset->addField(
            'profile_image',
            'image',
            [
                'name' => 'profile_image',
                'label' => __('Profile Image'),
                'title' => __('Profile Image'),
                'required' => true,
                'id'       => 'profile_image',
                'value' => $model->getProfileImage(),
                'note' => 'Allow image type: jpg, jpeg, png'
            ]
        );

        $fieldset->addField(
            'email_id',
            'text',
            [
                'name' => 'email_id',
                'label' => __('Email'),
                'id' => 'email_id',
                'title' => __('Email Address'),
                'class' => 'validate-email',
                'required' => true,
            ]
        );

        $fieldset->addField(
            'mobile_number',
            'text',
            [
                'name' => 'mobile_number',
                'label' => __('Mobile Number'),
                'id' => 'mobile_number',
                'title' => __('Mobile Number'),
                'class'=> 'validate-number',
                'class'=>'validate-phoneLax',
                'required' => true,
            ]
        );

        $fieldset->addField(
            'location_details',
            'textarea',
            [
                'name' => 'location_details',
                'label' => __('Location Details'),
                'required' => true,
                'style' => 'height: 100px;'
            ]
        );

        $fieldset->addField(
            'skill_details',
            'textarea',
            [
                'name' => 'skill_details',
                'label' => __('Skill Details'),
                'required' => true,
                'style' => 'height: 100px;',
            ]
        );

        $fieldset->addField(
            'summary_details',
            'textarea',
            [
                'name' => 'summary_details',
                'label' => __('Summary Details'),
                'required' => true,
                'style' => 'height: 100px;',
            ]
        );

        $fieldset->addField(
            'is_active',
            'select',
            [
                'name' => 'is_active',
                'label' => __('Status'),
                'id' => 'is_active',
                'title' => __('Status'),
                'values' => $this->_options->getOptionArray(),
                'class' => 'status',
                'required' => true,
            ]
        );

        $form->setValues($model->getData());
        $this->setForm($form);
        return parent::_prepareForm();
    }
}
