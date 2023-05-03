<?php

namespace Codilar\Catalog\Plugin\Product\ProductList;

use Magento\Catalog\Block\Product\ProductList\Toolbar as ProductData;

/**
 * Class Toolbar
 */
class Toolbar
{
    /**
     * Set SortBy order for filter price
     *
     * @param ProductData $subject
     * @param $result
     * @param $collection
     * @return mixed|void
     */
    public function afterSetCollection(ProductData $subject, $result, $collection)
    {
        $currentOrder = $subject->getCurrentOrder();
        if ($currentOrder) {
            if ($currentOrder == "filter_price") {
                $direction = $subject->getCurrentDirection();
                $collection->setOrder('filter_price '. $direction);
            }
            return $collection;
        }
    }
}
