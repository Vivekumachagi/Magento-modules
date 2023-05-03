<?php

namespace Grc\GuestUser\Model;

use Magento\Framework\Model\AbstractModel;

class GuestUser extends AbstractModel
{
    /**
     * Define resource model
     */
    protected function _construct()
    {
        $this->_init('Grc\GuestUser\Model\ResourceModel\GuestUser');
    }
}