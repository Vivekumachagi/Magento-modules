<?php

namespace Vivek\GetData\Model\ResourceModel;

use \Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class View extends AbstractDb
{
    protected function _construct()
    {
        $this->_init('form_data', 'id');
    }
}
