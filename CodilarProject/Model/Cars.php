<?php

namespace Vivek\CodilarProject\Model;

use Magento\Framework\Model\AbstractModel;
use Magento\Framework\DataObject\IdentityInterface;
use Vivek\CodilarProject\Api\Data\CarsInterface;

class Cars extends AbstractModel implements CarsInterface, IdentityInterface
{
    const CACHE_TAG = 'vivek_mymodule_view';

    protected function _construct()
    {
        $this->_init('Vivek\CodilarProject\Model\ResourceModel\Cars');
    }

    public function getId()
    {
        return $this->getData(self::ID);
    }

    public function getDate()
    {
        return $this->getData(self::DATE);
    }

    public function getTime()
    {
        return $this->getData(self::TIME);
    }

    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    public function setId($id)
    {
        return $this->setData(self::ID, $id);
    }

    public function setDate($id)
    {
        return $this->setData(self::DATE, $id);
    }

    public function setTime($name)
    {
        return $this->setData(self::TIME, $name);
    }
    public function getItems()
    {

    }

    public function setItems(array $items)
    {

    }



}
