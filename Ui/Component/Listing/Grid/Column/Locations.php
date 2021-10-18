<?php
namespace Yudiz\Freelancer\Ui\Component\Listing\Grid\Column;

class Locations extends \Magento\Ui\Component\Listing\Columns\Column
{
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            $fieldName = 'location_details';
            foreach ($dataSource['data']['items'] as &$item) {
                $item[$fieldName] = substr($item[$fieldName], 0, 20).'...';
            }
        }
        return $dataSource;
    }
}
