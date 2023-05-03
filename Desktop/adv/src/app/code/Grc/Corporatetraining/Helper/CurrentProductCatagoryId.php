<?php
namespace Grc\Corporatetraining\Helper;

use Magento\Catalog\Api\CategoryRepositoryInterface;
use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Eav\Api\AttributeSetRepositoryInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;   
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Registry;
use Magento\Store\Model\ScopeInterface;
use Magento\Store\Model\StoreManagerInterface;

class CurrentProductCatagoryId extends AbstractHelper
{
    /**
     * @var Registry
     */
    protected $_registry;
    /**
     * @var ProductRepositoryInterface
     */
    protected $_productRepository;
    /**
     * @var AttributeSetRepositoryInterface
     */
    protected $attributeSetRepository;
    /**
     * @var CategoryRepositoryInterface
     */
    private $categoryRepository;
    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    public function __construct(Context $context, ProductRepositoryInterface $productRepository, AttributeSetRepositoryInterface $attributeSetRepository, Registry $registry, CategoryRepositoryInterface $categoryRepository, ScopeConfigInterface $scopeConfig, StoreManagerInterface $storeManager)
    {
        parent::__construct($context);
        $this->_registry = $registry;
        $this->_productRepository = $productRepository;
        $this->attributeSetRepository = $attributeSetRepository;
        $this->categoryRepository = $categoryRepository;
        $this->scopeConfig = $scopeConfig;
        $this->storeManager = $storeManager;
    }

    /**
     * @return mixed
     */
    public function _prepareLayout()
    {
        return parent::_prepareLayout();
    }

    /**
     * @return mixed|null]
     */
    public function getCurrentCategory()
    {
        return $this->_registry->registry('current_category');
    }

    /**
     * @return mixed|null
     */
    public function getCurrentProduct()
    {
        return $this->_registry->registry('current_product');
    }

    /**
     * @param $sku
     * @return ProductInterface
     * @throws NoSuchEntityException
     */
    public function getProductBySku($sku)
    {
        return $this->_productRepository->get($sku);
    }

    /**
     * @param $attributeSetId
     * @return string
     * @throws NoSuchEntityException
     */
    public function getAttributeSetName($attributeSetId)
    {
        $attributeSet = $this->attributeSetRepository->get($attributeSetId);
        return $attributeSet->getAttributeSetName();
    }

    /**
     * @param $categoryId
     * @return string|null
     * @throws NoSuchEntityException
     */
    public function getCategoryUrlKey($categoryId)
    {
        return $this->categoryRepository->get($categoryId)->getUrlKey();
    }

    /**
     * @return string|null
     * @throws NoSuchEntityException
     */
    public function getUpcomingWeinarUrlKey()
    {
        $storeId = $this->storeManager->getStore()->getId();
        $catagoryName = $this->scopeConfig->getValue('upcomingwebinartoremove/general/categories', ScopeInterface::SCOPE_STORE, $storeId);
        return $this->getCategoryUrlKey($catagoryName);
    }

    /**
     * @return string|null
     * @throws NoSuchEntityException
     */
    public function getRecordedWebinarUrlKey()
    {
        $storeId = $this->storeManager->getStore()->getId();
        $catagoryName = $this->scopeConfig->getValue('upcomingWebinarToRemove/general/recordedCategory', ScopeInterface::SCOPE_STORE, $storeId);
        return $this->getCategoryUrlKey($catagoryName);
    }
}

