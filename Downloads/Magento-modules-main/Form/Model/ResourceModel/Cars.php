<?php

namespace Vivek\Form\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Cars extends AbstractDb
{
    protected function _construct()
    {
        $this->_init('form_data', 'id');
    }
}



