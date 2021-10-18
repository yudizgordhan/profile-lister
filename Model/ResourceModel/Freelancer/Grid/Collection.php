<?php
namespace Yudiz\Freelancer\Model\ResourceModel\Freelancer\Grid;

use Magento\Framework\Api\Search\SearchResultInterface;
use Magento\Framework\Search\AggregationInterface;
use Yudiz\Freelancer\Model\ResourceModel\Freelancer\Collection as FreelancerCollection;
use Magento\Framework\Data\Collection\EntityFactoryInterface;
use Psr\Log\LoggerInterface;
use Magento\Framework\Data\Collection\Db\FetchStrategyInterface;
use Magento\Framework\Event\ManagerInterface;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Collection extends FreelancerCollection implements SearchResultInterface
{
    /**
     * Resource initialization
     * @param EntityFactoryInterface   $entityFactory,
     * @param LoggerInterface          $logger,
     * @param FetchStrategyInterface   $fetchStrategy,
     * @param ManagerInterface         $eventManager,
     * @param String                   $mainTable,
     * @param String                   $eventPrefix,
     * @param String                   $eventObject,
     * @param String                   $resourceModel,
     * @param $model = 'Magento\Framework\View\Element\UiComponent\DataProvider\Document',
     * @param $connection = null,
     * @param AbstractDb              $resource = null
     * @return $this
     */

    public function __construct(
        EntityFactoryInterface $entityFactory,
        LoggerInterface $logger,
        FetchStrategyInterface $fetchStrategy,
        ManagerInterface $eventManager,
        $mainTable,
        $resourceModel,
        $model = \Magento\Framework\View\Element\UiComponent\DataProvider\Document::class,
        \Magento\Framework\DB\Adapter\AdapterInterface $connection = null,
        AbstractDb $resource = null
    ) {
        parent::__construct(
            $entityFactory,
            $logger,
            $fetchStrategy,
            $eventManager,
            $connection,
            $resource
        );
        $this->_init($model, $resourceModel);
        $this->setMainTable($mainTable);
    }

    public function getAggregations()
    {
        return $this->aggregations;
    }

    public function setAggregations($aggregations)
    {
        $this->aggregations = $aggregations;
    }

    public function getSearchCriteria()
    {
        return null;
    }
    
    public function setSearchCriteria(
        \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria = null
    ) {
        return $this;
    }

    public function getTotalCount()
    {
        return $this->getSize();
    }

    public function setTotalCount($totalCount)
    {
        return $this;
    }

    public function setItems(array $items = null)
    {
        return $this;
    }
    protected function _renderFiltersBefore()
    {
        $cgfTable = $this->getTable('customer_grid_flat');
        $this->getSelect()->joinLeft(
            $cgfTable.' as cgf',
            'main_table.user_id = cgf.entity_id',
            [
                'user_name'=>'cgf.name'
            ]
        );
        parent::_renderFiltersBefore();
    }
    
    protected function _initSelect()
    {
        $this->addFilterToMap('user_name', 'cgf.name');
        parent::_initSelect();
    }
}
