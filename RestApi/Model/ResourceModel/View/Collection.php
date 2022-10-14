<?php

/**
 * Grid Grid Collection.
 * @category    Webkul
 * @author      Webkul Software Private Limited
 */
namespace Vivek\RestApi\Model\ResourceModel\View;

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
        $this->_init('Vivek\RestApi\Model\View', 'Vivek\RestApi\Model\ResourceModel\View');
    }
}
