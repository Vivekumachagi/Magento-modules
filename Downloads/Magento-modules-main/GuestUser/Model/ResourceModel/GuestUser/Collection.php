<?php

namespace Grc\GuestUser\Model\ResourceModel\GuestUser;
 
class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected $_idFieldName = 'id';
    /**
     * Define model & resource model
     */
    protected function _construct()
    {
        $this->_init(
            'Grc\GuestUser\Model\GuestUser',
            'Grc\GuestUser\Model\ResourceModel\GuestUser'
        );
    }
}