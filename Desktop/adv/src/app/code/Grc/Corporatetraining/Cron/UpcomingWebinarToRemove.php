<?php

namespace Grc\Corporatetraining\Cron;

use Exception;
use Grc\Corporatetraining\Helper\DateTimeZone;
use Grc\Corporatetraining\Logger\CronLogger;
use Magento\Backend\Block\Template\Context;
use Magento\Catalog\Api\CategoryLinkManagementInterface;
use Magento\Catalog\Api\CategoryLinkRepositoryInterface;
use Magento\Catalog\Api\CategoryRepositoryInterface;
use Magento\Catalog\Model\CategoryRepository;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Stdlib\DateTime\TimezoneInterface;
use Magento\Framework\View\Element\Template;
use Magento\Store\Model\ScopeInterface;
use Magento\Store\Model\StoreManagerInterface;

class UpcomingWebinarToRemove extends Template
{
    /**
     * @var CollectionFactory
     */
    protected $_productCollectionFactory;
    /**
     * @var TimezoneInterface
     */
    protected $_localeDate;
    /**
     * @var CategoryLinkRepositoryInterface
     */
    protected $categoryLinkRepository;
    /**
     * @var CategoryRepository
     */
    protected $categoryRepository;
    /**
     * @var CategoryLinkManagementInterface
     */
    private $categoryLinkManagement;
    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;
    /**
     * @var StoreManagerInterface
     */
    private $storeManager;
    /**
     * @var int
     */
    private $storeId;

    /**
     * @var DateTimeZone
     */
    private $dateTimeZone;
    /**
     * @var CronLogger
     */
    private $cronLogger;

    /**
     * @param CategoryLinkManagementInterface $categoryLinkManagement
     * @param CategoryRepositoryInterface $categoryRepository
     * @param CategoryLinkRepositoryInterface $categoryLinkRepository
     * @param TimezoneInterface $localeDate
     * @param Context $context
     * @param CollectionFactory $productCollectionFactory
     * @param ScopeConfigInterface $scopeConfig
     * @param StoreManagerInterface $storeManager
     * @param DateTimeZone $dateTimeZone
     * @param CronLogger $cronLogger
     * @throws NoSuchEntityException
     */

    public function __construct(
        CategoryLinkManagementInterface $categoryLinkManagement,
        CategoryRepositoryInterface     $categoryRepository,
        CategoryLinkRepositoryInterface $categoryLinkRepository,
        TimezoneInterface               $localeDate,
        Context                         $context,
        CollectionFactory               $productCollectionFactory,
        ScopeConfigInterface            $scopeConfig,
        StoreManagerInterface           $storeManager,
        DateTimeZone                    $dateTimeZone,
        CronLogger                      $cronLogger
    )
    {
        $this->categoryLinkManagement = $categoryLinkManagement;
        $this->categoryRepository = $categoryRepository;
        $this->categoryLinkRepository = $categoryLinkRepository;
        $this->_localeDate = $localeDate;
        $this->_productCollectionFactory = $productCollectionFactory;
        $this->scopeConfig = $scopeConfig;
        $this->storeManager = $storeManager;
        $this->storeId = $this->storeManager->getStore()->getId();
        $this->dateTimeZone = $dateTimeZone;
        parent::__construct($context);
        $this->cronLogger = $cronLogger;
    }

    /**
     * @return void
     */
    public function getProductCollection()
    {
        $upcomingWebinarId = $this
            ->scopeConfig
            ->getValue(
                'upcomingWebinarToRemove/general/categories',
                ScopeInterface::SCOPE_STORE,
                $this->storeId
            );
        $recordedWebinarId = $this
            ->scopeConfig
            ->getValue(
                'upcomingWebinarToRemove/general/recordedCategory',
                ScopeInterface::SCOPE_STORE,
                $this->storeId
            );
        $collection = $this->_productCollectionFactory->create();
        $collection->addAttributeToSelect('*');
        $collection->addCategoriesFilter(['in' => $upcomingWebinarId]);
        $date = $this->dateTimeZone->getTimeAccordingToTimeZone();
        foreach ($collection as $values) {
            $webinarEndDate = $this->dateTimeZone->getDateTimeAccordingToTimeZone($values->getWebinarEndDate());
            if (strtotime($date) > strtotime($webinarEndDate)) {
                $categories = $values->getCategoryIds();
                $removeUpcomingCategory = array_diff($categories, array($upcomingWebinarId));
                $removeUpcomingCategory[] = $recordedWebinarId;
                $finalCategory = array_unique($removeUpcomingCategory);
                $this->assignedProductToCategory($values->getSku(), $finalCategory);
            }
        }
    }

    /**
     * @param string $productSku
     * @param array $categoryIds
     * @return bool
     */
    public function assignedProductToCategory(string $productSku, array $categoryIds): bool
    {
        $hasProductAssignedSuccess = false;
        try {
            $this->cronLogger->log(500, 'cron executed for sku' . json_encode($productSku));
            $hasProductAssignedSuccess = $this->categoryLinkManagement->assignProductToCategories($productSku, $categoryIds);
        } catch (Exception $exception) {
            $this->cronLogger->log(500, 'cron not executed');
        }
        return $hasProductAssignedSuccess;
    }
}
