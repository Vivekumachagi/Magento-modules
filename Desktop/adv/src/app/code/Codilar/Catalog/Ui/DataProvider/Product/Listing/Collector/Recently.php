<?php

namespace Codilar\Catalog\Ui\DataProvider\Product\Listing\Collector;

use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Api\Data\ProductRenderExtensionFactory;
use Magento\Catalog\Api\Data\ProductRenderInterface;
use Magento\Catalog\Ui\DataProvider\Product\ProductRenderCollectorInterface;

/**
 * Class Recently
 * @package Codilar\Catalog\Ui\DataProvider\Product\Listing\Collector
 */
class Recently implements ProductRenderCollectorInterface
{
    const KEY = "filter_price";

    /**
     * @var ProductRenderExtensionFactory
     */
    private $productRenderExtensionFactory;

    /**
     * Sku constructor.
     * @param ProductRenderExtensionFactory $productRenderExtensionFactory
     */
    public function __construct(
        ProductRenderExtensionFactory $productRenderExtensionFactory
    ) {
        $this->productRenderExtensionFactory = $productRenderExtensionFactory;
    }

    /**
     * @param ProductInterface $product
     * @param ProductRenderInterface $productRender
     * @return void
     */
    public function collect(ProductInterface $product, ProductRenderInterface $productRender)
    {
        $extensionAttributes = $productRender->getExtensionAttributes();

        if (!$extensionAttributes) {
            $extensionAttributes = $this->productRenderExtensionFactory->create();
        }

        if ($filterPrice = $product->getData('filter_price')) {
            $extensionAttributes->setData('filter_price', $filterPrice);
        }

        $productRender->setExtensionAttributes($extensionAttributes);
    }
}
