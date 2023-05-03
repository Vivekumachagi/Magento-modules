<?php
namespace Vivek\CodilarProject\Model\ResourceModel\Cars;

use Vivek\CodilarProject\Model\Cars as Model;
use Vivek\CodilarProject\Model\ResourceModel\Cars as ResourceModel;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{

    protected function _construct()
    {
        $this->_init(Model::class, ResourceModel::class);
    }
}
