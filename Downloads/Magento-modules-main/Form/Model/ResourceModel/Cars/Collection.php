<?php
namespace Vivek\Form\Model\ResourceModel\Cars;

use Vivek\Form\Model\Cars as Model;
use Vivek\Form\Model\ResourceModel\Cars as ResourceModel;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    
    protected function _construct() 
    {
        $this->_init(Model::class, ResourceModel::class);
    }
}