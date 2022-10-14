<?php

namespace Vivek\GetData\Model;

use \Magento\Framework\Model\AbstractModel;
use \Magento\Framework\DataObject\IdentityInterface;
use \Vivek\GetData\Api\Data\ViewInterface;


class View extends AbstractModel implements ViewInterface, IdentityInterface
{
    const CACHE_TAG = 'vivek_mymodule_view';

    protected function _construct()
    {
        $this->_init('Vivek\GetData\Model\ResourceModel\View');
    }


    public function getTitle()
    {
        return $this->getData(self::TITLE);
    }


    public function getContent()
    {
        return $this->getData(self::CONTENT);
    }


    public function getCreatedAt()
    {
        return $this->getData(self::CREATED_AT);
    }


    public function getId()
    {
        return $this->getData(self::ARTICLE_ID);
    }


    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }


    public function setTitle($title)
    {
        return $this->setData(self::TITLE, $title);
    }

    public function setContent($content)
    {
        return $this->setData(self::CONTENT, $content);
    }


    public function setCreatedAt($createdAt)
    {
        return $this->setData(self::CREATED_AT, $createdAt);
    }

    public function setId($id)
    {
        return $this->setData(self::ARTICLE_ID, $id);
    }
}
