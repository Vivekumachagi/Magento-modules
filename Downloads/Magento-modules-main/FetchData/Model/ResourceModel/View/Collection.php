<?php
namespace Vivek\FetchData\Model\ResourceModel\View;

use \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    /**
     * Remittance File Collection Constructor
     * @return void
     */
    protected function _construct()
    {
        $this->_init(\Vivek\FetchData\Model\View::class, \Vivek\FetchData\Model\ResourceModel\View::class);
    }
}