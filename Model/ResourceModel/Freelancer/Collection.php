<?php
namespace Yudiz\Freelancer\Model\ResourceModel\Freelancer;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = 'entity_id';
    /**
     * Define resource model.
     */
    protected function _construct()
    {
        $this->_init(\Yudiz\Freelancer\Model\Freelancer::class, \Yudiz\Freelancer\Model\ResourceModel\Freelancer::class);
        $this->_map['fields']['entity_id'] = 'main_table.entity_id';
    }
}
