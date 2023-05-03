<?php

namespace Grc\GuestUser\Model\ResourceModel;

class GuestUser extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * Define main table
     */
    protected function _construct()
    {
        $this->_init('grc_download_brochure_guestuser', 'id');
    }
}