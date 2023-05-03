<?php

/**
 * Grid Grid Collection.
 * @category    Webkul
 * @author      Webkul Software Private Limited
 */
namespace Vivek\Grid\Model\ResourceModel\Grid;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = 'id';
    /**
     * Define resource model.
     */
    protected function _construct()
    {
        $this->_init('Vivek\Grid\Model\Grid', 'Vivek\Grid\Model\ResourceModel\Grid');
    }
}