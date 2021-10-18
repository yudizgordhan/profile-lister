<?php

namespace Yudiz\Freelancer\Block\Adminhtml\Freelancer\Edit;

class Tabs extends \Magento\Backend\Block\Widget\Tabs
{
    /**
     * Constructor
     *
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('freelancer_details_edit_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(__('Freelancer Information'));
    }

    protected function _beforeToHtml()
    {
        $this->addTab(
            'basic_info',
            [
                'label' => __('Basic Information'),
                'title' => __('Basic Information'),
                'content' => $this->getLayout()
                    ->createBlock(\Yudiz\Freelancer\Block\Adminhtml\Freelancer\Edit\Tab\Main::class)
                    ->toHtml(),
                'active' => true
            ]
        );
        $this->addTab(
            'cover_image',
            [
                'label' => __('Freelancer Cover Image'),
                'title' => __('Freelancer Cover Image'),
                'content' => $this->getLayout()
                    ->createBlock(\Yudiz\Freelancer\Block\Adminhtml\Freelancer\Edit\Tab\CoverImage::class)
                    ->toHtml(),
                'active' => false
            ]
        );

        return parent::_beforeToHtml();
    }
}
