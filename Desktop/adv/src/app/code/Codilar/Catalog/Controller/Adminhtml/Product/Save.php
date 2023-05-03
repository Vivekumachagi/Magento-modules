<?php
/**
 *
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Codilar\Catalog\Controller\Adminhtml\Product;

use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Catalog\Api\CategoryLinkManagementInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Catalog\Model\Product\Copier;
use Magento\Catalog\Model\Product\TypeTransitionManager;
use Magento\Framework\App\Action\HttpPostActionInterface as HttpPostActionInterface;
use Magento\Backend\App\Action;
use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Controller\Adminhtml\Product;
use Magento\Framework\Escaper;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Catalog\Controller\Adminhtml\Product\Save as ProductSave;
use Psr\Log\LoggerInterface;
use Magento\Catalog\Controller\Adminhtml\Product\Initialization\Helper;
use Codilar\Catalog\Helper\Data;

/**
 * Class Save
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class Save extends ProductSave
{
    /**
     * @var Helper;
     */
    protected $initializationHelper;

    /**
     * @var Copier
     */
    protected $productCopier;

    /**
     * @var TypeTransitionManager
     */
    protected $productTypeManager;

    /**
     * @var CategoryLinkManagementInterface
     */
    protected $categoryLinkManagement;

    /**
     * @var ProductRepositoryInterface
     */
    protected $productRepository;

    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * @var Escaper|null
     */
    private $escaper;

    /**
     * @var null|LoggerInterface
     */
    private $logger;

    /**
     * @var Data
     */
    public $customizableOptionHelper;

    /**
     * Save constructor.
     *
     * @param Context $context
     * @param Builder $productBuilder
     * @param Helper $initializationHelper
     * @param Copier $productCopier
     * @param TypeTransitionManager $productTypeManager
     * @param ProductRepositoryInterface $productRepository
     * @param Escaper|null $escaper
     * @param LoggerInterface|null $logger
     * @param Data $customizableOptionHelper
     */
    public function __construct(
        Context $context,
        Product\Builder $productBuilder,
        Helper $initializationHelper,
        Copier $productCopier,
        TypeTransitionManager $productTypeManager,
        ProductRepositoryInterface $productRepository,
        Escaper $escaper = null,
        LoggerInterface $logger = null,
        Data $customizableOptionHelper
    ) {
        parent::__construct($context, $productBuilder, $initializationHelper, $productCopier, $productTypeManager, $productRepository);
        $this->escaper = $escaper ?? $this->_objectManager->get(Escaper::class);
        $this->logger = $logger ?? $this->_objectManager->get(LoggerInterface::class);
        $this->customizableOptionHelper = $customizableOptionHelper;
    }

    /**
     * Save product action
     *
     * @return Redirect
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     * @throws NoSuchEntityException
     */
    public function execute()
    {
        $storeId = $this->getRequest()->getParam('store', 0);
        $store = $this->getStoreManager()->getStore($storeId);
        $this->getStoreManager()->setCurrentStore($store->getCode());
        $redirectBack = $this->getRequest()->getParam('back', false);
        $productId = $this->getRequest()->getParam('id');
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();
        $productAttributeSetId = $this->getRequest()->getParam('set');
        $productTypeId = $this->getRequest()->getParam('type');
        if ($data) {
            try {
                $product = $this->initializationHelper->initialize(
                    $this->productBuilder->build($this->getRequest())
                );
                $this->productTypeManager->processProduct($product);
                if (isset($data['product'][$product->getIdFieldName()])) {
                    throw new \Magento\Framework\Exception\LocalizedException(
                        __('The product was unable to be saved. Please try again.')
                    );
                }

                $originalSku = $product->getSku();
                $canSaveCustomOptions = $product->getCanSaveCustomOptions();
                $product->save();

                $filterPrice = $this->customizableOptionHelper->getCustomizableOptions($product);
                $product->setData('filter_price', $filterPrice);
                $product->save();

                $this->handleImageRemoveError($data, $product->getId());
                $this->getCategoryLinkManagement()->assignProductToCategories(
                    $product->getSku(),
                    $product->getCategoryIds()
                );
                $productId = $product->getEntityId();
                $productAttributeSetId = $product->getAttributeSetId();
                $productTypeId = $product->getTypeId();
                $extendedData = $data;
                $extendedData['can_save_custom_options'] = $canSaveCustomOptions;
                $this->copyToStores($extendedData, $productId);
                $this->messageManager->addSuccessMessage(__('You saved the product.'));
                $this->getDataPersistor()->clear('catalog_product');
                if ($product->getSku() != $originalSku) {
                    $this->messageManager->addNoticeMessage(
                        __(
                            'SKU for product %1 has been changed to %2.',
                            $this->escaper->escapeHtml($product->getName()),
                            $this->escaper->escapeHtml($product->getSku())
                        )
                    );
                }
                $this->_eventManager->dispatch(
                    'controller_action_catalog_product_save_entity_after',
                    ['controller' => $this, 'product' => $product]
                );

                if ($redirectBack === 'duplicate') {
                    $product->unsetData('quantity_and_stock_status');
                    $newProduct = $this->productCopier->copy($product);
                    $this->checkUniqueAttributes($product);
                    $this->messageManager->addSuccessMessage(__('You duplicated the product.'));
                }
            } catch (\Magento\Framework\Exception\LocalizedException $e) {
                $this->logger->critical($e);
                $this->messageManager->addExceptionMessage($e);
                $data = isset($product) ? $this->persistMediaData($product, $data) : $data;
                $this->getDataPersistor()->set('catalog_product', $data);
                $redirectBack = $productId ? true : 'new';
            } catch (\Exception $e) {
                $this->logger->critical($e);
                $this->messageManager->addErrorMessage($e->getMessage());
                $data = isset($product) ? $this->persistMediaData($product, $data) : $data;
                $this->getDataPersistor()->set('catalog_product', $data);
                $redirectBack = $productId ? true : 'new';
            }
        } else {
            $resultRedirect->setPath('catalog/*/', ['store' => $storeId]);
            $this->messageManager->addErrorMessage('No data to save');
            return $resultRedirect;
        }

        if ($redirectBack === 'new') {
            $resultRedirect->setPath(
                'catalog/*/new',
                ['set' => $productAttributeSetId, 'type' => $productTypeId]
            );
        } elseif ($redirectBack === 'duplicate' && isset($newProduct)) {
            $resultRedirect->setPath(
                'catalog/*/edit',
                ['id' => $newProduct->getEntityId(), 'back' => null, '_current' => true]
            );
        } elseif ($redirectBack) {
            $resultRedirect->setPath(
                'catalog/*/edit',
                ['id' => $productId, '_current' => true, 'set' => $productAttributeSetId]
            );
        } else {
            $resultRedirect->setPath('catalog/*/', ['store' => $storeId]);
        }
        return $resultRedirect;
    }

    /**
     * Notify customer when image was not deleted in specific case.
     *
     * TODO: temporary workaround must be eliminated in MAGETWO-45306
     *
     * @param array $postData
     * @param int $productId
     * @return void
     */
    private function handleImageRemoveError($postData, $productId)
    {
        if (isset($postData['product']['media_gallery']['images'])) {
            $removedImagesAmount = 0;
            foreach ($postData['product']['media_gallery']['images'] as $image) {
                if (!empty($image['removed'])) {
                    $removedImagesAmount++;
                }
            }
            if ($removedImagesAmount) {
                $expectedImagesAmount = count($postData['product']['media_gallery']['images']) - $removedImagesAmount;
                $product = $this->productRepository->getById($productId);
                $images = $product->getMediaGallery('images');
                if (is_array($images) && $expectedImagesAmount != count($images)) {
                    $this->messageManager->addNoticeMessage(
                        __('The image cannot be removed as it has been assigned to the other image role')
                    );
                }
            }
        }
    }

    /**
     * Get categoryLinkManagement in a backward compatible way.
     *
     * @return CategoryLinkManagementInterface
     */
    private function getCategoryLinkManagement()
    {
        if (null === $this->categoryLinkManagement) {
            $this->categoryLinkManagement = \Magento\Framework\App\ObjectManager::getInstance()
                ->get(CategoryLinkManagementInterface::class);
        }
        return $this->categoryLinkManagement;
    }

    /**
     * Get storeManager in a backward compatible way.
     *
     * @return StoreManagerInterface
     * @deprecated 101.0.0
     */
    private function getStoreManager()
    {
        if (null === $this->storeManager) {
            $this->storeManager = \Magento\Framework\App\ObjectManager::getInstance()
                ->get(\Magento\Store\Model\StoreManagerInterface::class);
        }
        return $this->storeManager;
    }

    /**
     * Persist media gallery on error, in order to show already saved images on next run.
     *
     * @param ProductInterface $product
     * @param array $data
     * @return array
     */
    private function persistMediaData(ProductInterface $product, array $data)
    {
        $mediaGallery = $product->getData('media_gallery');
        if (!empty($mediaGallery['images'])) {
            foreach ($mediaGallery['images'] as $key => $image) {
                if (!isset($image['new_file'])) {
                    //Remove duplicates.
                    unset($mediaGallery['images'][$key]);
                }
            }
            $data['product']['media_gallery'] = $mediaGallery;
            $fields = [
                'image',
                'small_image',
                'thumbnail',
                'swatch_image',
            ];
            foreach ($fields as $field) {
                $data['product'][$field] = $product->getData($field);
            }
        }

        return $data;
    }

    /**
     * Check unique attributes and add error to message manager
     *
     * @param \Magento\Catalog\Model\Product $product
     */
    private function checkUniqueAttributes(\Magento\Catalog\Model\Product $product)
    {
        $uniqueLabels = [];
        foreach ($product->getAttributes() as $attribute) {
            if ($attribute->getIsUnique() && $attribute->getIsUserDefined()
                && $product->getData($attribute->getAttributeCode()) !== null
            ) {
                $uniqueLabels[] = $attribute->getDefaultFrontendLabel();
            }
        }
        if ($uniqueLabels) {
            $uniqueLabels = implode('", "', $uniqueLabels);
            $this->messageManager->addErrorMessage(__('The value of attribute(s) "%1" must be unique', $uniqueLabels));
        }
    }
}
