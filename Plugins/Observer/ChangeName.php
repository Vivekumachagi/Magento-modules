<?php

namespace Vivek\Plugins\Observer;

class ChangeName  implements \Magento\Framework\Event\ObserverInterface
{

    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $product = $observer->getProduct();
        $originalName = $product->getName('name');
        $modifiedName = $originalName . ' - Observer';
        $product->setName($modifiedName);
    }
}
