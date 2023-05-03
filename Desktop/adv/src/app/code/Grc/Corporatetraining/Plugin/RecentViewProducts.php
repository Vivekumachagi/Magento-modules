<?php
namespace Grc\Corporatetraining\Plugin;

use Magento\Reports\Block\Product\AbstractProduct as Subject;

class RecentViewProducts extends \Magento\Reports\Block\Product\AbstractProduct
{
    /**
     * @param Subject $subject
     * @param callable $proceed
     * @return mixed
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function aroundGetItemsCollection(Subject $subject, callable $proceed)
    {
        if ($this->_collection === null) {
            $attributes = $this->_catalogConfig->getProductAttributes();
            $this->_collection = $subject->getModel()->getCollection()->addAttributeToSelect($attributes);
            if ($this->getCustomerId()) {
                $this->_collection->setCustomerId($this->getCustomerId());
            }
            $this->_collection->excludeProductIds(
                $subject->getModel()->getExcludeProductIds()
            )->addUrlRewrite()->setPageSize(
                $subject->getPageSize()
            )->setCurPage(
                1
            );
            /* Price data is added to consider item stock status using price index */
            $this->_collection->addPriceData();
            if ($subject->getCustomerId())
            {
                $ids = $subject->getProductIds();
                if (empty($ids)) {
                    $this->_collection->addIndexFilter();
                } else {
                    $this->_collection->addFilterByIds($ids);
                }
                $this->_collection->setAddedAtOrder()->setVisibility($this->_productVisibility->getVisibleInSiteIds());
            }
        }
        return $this->_collection;
    }
}
