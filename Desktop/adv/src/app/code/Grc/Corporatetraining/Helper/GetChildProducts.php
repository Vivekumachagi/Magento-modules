<?php

namespace Grc\Corporatetraining\Helper;

use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Catalog\Model\Product;
use Magento\Customer\Model\Session;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Store\Model\StoreManagerInterface;

class GetChildProducts extends AbstractHelper
{
    /**
     * @var ProductRepositoryInterface
     */
    protected $_productRepositoryInterface;
    /**
     * @var Product
     */
    protected $_products;
    /**
     * @var StoreManagerInterface
     */
    protected $_storeManager;
    /**
     * @var Session
     */
    protected $_customerSession;

    public function __construct(Product $_products, StoreManagerInterface $_storeManager ,Session $customerSession, ProductRepositoryInterface $productRepositoryInterface)
    {
        $this->_products = $_products;
        $this->_storeManager = $_storeManager;
        $this->_customerSession = $customerSession;
        $this->_productRepositoryInterface = $productRepositoryInterface;
    }

    /**
     * @param $productId
     * @return false|\Magento\Catalog\Api\Data\ProductInterface
     */
    public function getProductCollection($productId)
    {
        try {
            $product = $this->_productRepositoryInterface->get($productId);
            return $product;
        } catch (NoSuchEntityException $e) {
            return false;
        }
    }

    /**
     * @param $parentId
     * @return Product
     */
    public function getChildProductsAttribute($parentId)
    {
        return $this->_products->load($parentId);
    }

    /**
     * @return StoreManagerInterface
     */
    public function getSroreManagerInterface()
    {
        return $this->_storeManager;
    }

    /**
     * @return bool
     */
    public function isCustomerLoggedIn()
    {
        return $this->_customerSession->isLoggedIn();
    }
}
