<?php

namespace Codilar\HomePage\Block;

use Codilar\Catalog\Helper\Data;
use Grc\Corporatetraining\Helper\DateTimeZone;
use Magento\Catalog\Helper\Category;
use Magento\Catalog\Model\CategoryFactory;
use Magento\Catalog\Model\CategoryRepository;
use Magento\Catalog\Model\Product;
use Magento\Catalog\Model\ResourceModel\Product\Collection;
use Magento\ConfigurableProduct\Model\Product\Type\Configurable;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\View\Element\Template;
use Magento\Store\Model\ScopeInterface;
use Magento\Store\Model\StoreManagerInterface;

class HomePage extends Template
{
    /**
     * @var Category
     */
    private $category;
    /**
     * @var CategoryRepository
     */
    private $categoryRepository;
    /**
     * @var Collection
     */
    private $collection;
    /**
     * @var StoreManagerInterface
     */
    private $storeManager;
    /**
     * @var Configurable
     */
    private $configurable;
    /**
     * @var Product
     */
    private $product;
    /**
     * @var DateTimeZone
     */
    private $dateTimeZone;
    /**
     * @var Data
     */
    private $date;
    /**
     * @var CategoryFactory
     */
    private $categoryFactory;
    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;
    /**
     * @var int
     */
    private $storeId;

    /**
     * @param Template\Context $context
     * @param CategoryFactory $categoryFactory
     * @param Category $category
     * @param CategoryRepository $categoryRepository
     * @param Collection $collection
     * @param StoreManagerInterface $storeManager
     * @param Configurable $configurable
     * @param Product $product
     * @param DateTimeZone $dateTimeZone
     * @param Data $date
     * @param array $data \
     */

    public function __construct(Template\Context      $context,
                                ScopeConfigInterface  $scopeConfig,
                                StoreManagerInterface $storeManager,
                                CategoryFactory       $categoryFactory,
                                Category              $category,
                                CategoryRepository    $categoryRepository,
                                Collection            $collection,
                                Configurable          $configurable,
                                Product               $product,
                                DateTimeZone          $dateTimeZone,
                                Data                  $date,
                                array                 $data = [])
    {
        parent::__construct($context, $data);
        $this->scopeConfig = $scopeConfig;
        $this->storeManager = $storeManager;
        $this->storeId = $this->storeManager->getStore()->getId();
        $this->categoryFactory = $categoryFactory;
        $this->category = $category;
        $this->categoryRepository = $categoryRepository;
        $this->collection = $collection;
        $this->configurable = $configurable;
        $this->product = $product;
        $this->dateTimeZone = $dateTimeZone;
        $this->date = $date;
    }

    /**
     * @return CategoryFactory
     */
    public function getCategoryFactory(): CategoryFactory
    {
        return $this->categoryFactory;
    }

    /**
     * @return Category
     */
    public function getCategory(): Category
    {
        return $this->category;
    }

    /**
     * @return CategoryRepository
     */
    public function getCategoryRepository(): CategoryRepository
    {
        return $this->categoryRepository;
    }

    /**
     * @return Collection
     */
    public function getCollection(): Collection
    {
        return $this->collection;
    }

    /**
     * @return StoreManagerInterface
     */
    public function getStoreManager(): StoreManagerInterface
    {
        return $this->storeManager;
    }

    /**
     * @return DateTimeZone
     */
    public function getDateTimeZone(): DateTimeZone
    {
        return $this->dateTimeZone;
    }

    /**
     * @return Data
     */
    public function getDate(): Data
    {
        return $this->date;
    }

    /**
     * @return Configurable
     */
    public function getConfigurable(): Configurable
    {
        return $this->configurable;
    }

    /**
     * @return Product
     */
    public function getProduct(): Product
    {
        return $this->product;
    }

    /**
     * @return mixed
     */
    public function getWebinarCategoryId()
    {
        return $this
            ->scopeConfig
            ->getValue(
                'upcomingWebinarToRemove/general/webinar',
                ScopeInterface::SCOPE_STORE,
                $this->storeId
            );
    }

    /**
     * @return mixed
     */
    public function getSeminarCategoryId()
    {
        return $this
            ->scopeConfig
            ->getValue(
                'upcomingWebinarToRemove/general/seminar',
                ScopeInterface::SCOPE_STORE,
                $this->storeId
            );

    }
}
