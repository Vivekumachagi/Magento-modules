<?php

namespace Vivek\Plugins\Preferences;

class Product extends \Magento\Catalog\Model\Product
{
    public function getName()
    {
        return "preference working" . $this->_getData(self::NAME);
    }
}
