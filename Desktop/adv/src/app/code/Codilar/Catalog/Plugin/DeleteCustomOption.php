<?php

namespace Codilar\Catalog\Plugin;

use Magento\Catalog\Api\Data\ProductCustomOptionInterface;
use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Framework\Exception\NoSuchEntityException;

class DeleteCustomOption extends \Magento\Catalog\Model\Product\Option\Repository
{

    /**
     * @param \Magento\Catalog\Model\Product\Option\Repository $subject
     * @param callable $proceed
     * @param ProductCustomOptionInterface $option
     */
    public function aroundSave(\Magento\Catalog\Model\Product\Option\Repository $subject, callable $proceed, ProductCustomOptionInterface $option)
    {
        $productSku = $option->getProductSku();
        /** @var \Magento\Catalog\Model\Product $product */
        $product = $subject->productRepository->get($productSku);
        $metadata = $subject->metadataPool->getMetadata(ProductInterface::class);
        $option->setData('product_id', $product->getData($metadata->getLinkField()));
        $option->setData('store_id', $product->getStoreId());

        if ($option->getOptionId()) {
            $options = $subject->getProductOptions($product);
            $persistedOption = array_filter($options, function ($iOption) use ($option) {
                return $option->getOptionId() == $iOption->getOptionId();
            });

            $persistedOption = reset($persistedOption);

            if (!$persistedOption) {
                throw new NoSuchEntityException();
            }


            $originalValues = $persistedOption->getValues();

            $newValues = $option->getData('values');

            if ($newValues) {
                if (isset($originalValues)) {
                    $newValues = $subject->markRemovedValues($newValues, $originalValues);
                }
                $option->setData('values', $newValues);
            }
        }
        $option->save();
        return $option;
    }
}