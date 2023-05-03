<?php
namespace Vivek\Form\Model;

use Magento\Framework\Model\AbstractModel;
use Magento\Framework\DataObject\IdentityInterface;
use Vivek\Form\Api\Data\CarsInterface;

class Cars extends AbstractModel implements CarsInterface, IdentityInterface
{
    const CACHE_TAG = 'vivek_mymodule_view';

    protected function _construct()
    {
        $this->_init('Vivek\Form\Model\ResourceModel\Cars');
    }

    public function getId()
    {
        return $this->getData(self::ID);
    }

    public function getName()
    {
        return $this->getData(self::NAME);
    }

    public function getEmail()
    {
        return $this->getData(self::EMAIL);
    }

    public function getDesc()
    {
        return $this->getData(self::DESC);
    }

    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    public function setId($id)
    {
        return $this->setData(self::ID, $id);
    }

    public function setName($name)
    {
        return $this->setData(self::NAME, $name);
    }

    public function setEmail($email)
    {
        return $this->setData(self::EMAIL, $email);
    }

    public function setDesc($desc)
    {
        return $this->setData(self::DESC, $desc);
    }
    public function getItems()
    {

    }

    public function setItems(array $items)
    {

    }
        
}
