<?php
namespace Vivek\DataFetch\Model\ResourceModel\View;

use \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    /**
     * Remittance File Collection Constructor
     * @return void
     */
    protected function _construct()
    {
        $this->_init(\Vivek\DataFetch\Model\View::class, \Vivek\DataFetch\Model\ResourceModel\View::class);
    }   
}