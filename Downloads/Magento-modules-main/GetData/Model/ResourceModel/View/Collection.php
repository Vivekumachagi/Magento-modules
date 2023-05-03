<?php

namespace Vivek\GetData\Model\ResourceModel\View;

use \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{

    protected function _construct()
    {
        $this->_init(\Vivek\GetData\Model\View::class, \Vivek\GetData\Model\ResourceModel\View::class);
    }
}
