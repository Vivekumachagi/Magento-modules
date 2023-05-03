<?php

namespace Codilar\Catalog\Plugin\Model;

use Magento\Store\Model\StoreManagerInterface;

/**
 * Class Config
 */
class Config
{
    /**
     * @var StoreManagerInterface
     */
    protected $_storeManager;

    /**
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(
        StoreManagerInterface $storeManager
    ) {
        $this->_storeManager = $storeManager;
    }

    /**
     * Attribute Sort By
     *
     * @param \Magento\Catalog\Model\Config $catalogConfig
     * @param $options
     * @return array
     */
    public function afterGetAttributeUsedForSortByArray(\Magento\Catalog\Model\Config $catalogConfig, $options)
    {
        $customOption['filter_price'] = __('Filter Price');
        $options = array_merge($customOption, $options);
        return $options;
    }
}
