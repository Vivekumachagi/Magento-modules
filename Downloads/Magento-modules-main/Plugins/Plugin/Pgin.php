<?php

namespace Vivek\Plugins\Plugin;

class Pgin
{

    // public function aftergetName(\Magento\Catalog\Model\Product $product, $name)
    // {
    //     return 'plugin working' . $name;
    // }
    public function beforesetName(\Magento\Catalog\Model\Product $product,$name)
    {
        return "before setname ".$name;
    }
}
