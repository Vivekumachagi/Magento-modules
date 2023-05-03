<?php

namespace Grc\Corporatetraining\Cron;

use Codilar\Catalog\Helper\Data;
use Exception;
use Grc\Corporatetraining\Logger\CronLogger;
use Magento\Backend\Block\Template\Context;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\InputException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\StateException;
use Magento\Framework\View\Element\Template;

/**
 * Class FilterPriceUpdate
 */
class FilterPriceUpdate extends Template
{
    /**
     * @var Data
     */
    public $customizableOptionHelper;
    /**
     * @var CollectionFactory
     */
    protected $_productCollectionFactory;
    /**
     * @var ProductRepositoryInterface
     */
    protected $productRepository;
    /**
     * @var CronLogger
     */
    private $cronLogger;

    /**
     * @param ProductRepositoryInterface $productRepository
     * @param Data $customizableOptionHelper
     * @param Context $context
     * @param CollectionFactory $productCollectionFactory
     */
    public function __construct(
        ProductRepositoryInterface $productRepository,
        Data                       $customizableOptionHelper,
        Context                    $context,
        CollectionFactory          $productCollectionFactory,
        CronLogger                 $cronLogger
    )
    {
        $this->productRepository = $productRepository;
        $this->customizableOptionHelper = $customizableOptionHelper;
        $this->_productCollectionFactory = $productCollectionFactory;
        $this->cronLogger = $cronLogger;
        parent::__construct($context);
    }

    /**
     * Cron for filter price attribute save for product
     *
     * @return void
     * @throws CouldNotSaveException
     * @throws InputException
     * @throws NoSuchEntityException
     * @throws StateException
     */
    public function filterPriceUpdate()
    {
        $collection = $this->_productCollectionFactory->create();
        $collection->addAttributeToSelect('*');
        foreach ($collection as $product) {
            $filterPrice = $this->customizableOptionHelper->getCustomizableOptions($product);
            if ($filterPrice != null) {

                try {
                    $saveProduct = $product->setData('filter_price', $filterPrice);
                    $this->productRepository->save($saveProduct);
                } catch (Exception $exception) {
                    $this->cronLogger->log(500, 'filter_price cron not executed for SKU ' . $product->getSku());
                }
            }
        }
    }
}
