<?php

/**
 * Grid Grid Model.
 * @category  Webkul
 * @package   Webkul_Grid
 * @author    Webkul
 * @copyright Copyright (c) 2010-2017 Webkul Software Private Limited (https://webkul.com)
 * @license   https://store.webkul.com/license.html
 */
namespace Vivek\RestApi\Model;

use Vivek\RestApi\Api\Data\ViewInterface;

class Grid extends \Magento\Framework\Model\AbstractModel implements ViewInterface
{
    /**
     * CMS page cache tag.
     */
    const CACHE_TAG = 'wk_grid_records';

    /**
     * @var string
     */
    protected $_cacheTag = 'wk_grid_records';

    /**
     * Prefix of model events names.
            *
     * @var string
     */
    protected $_eventPrefix = 'wk_grid_records';

    /**
     * Initialize resource model.
     */
    protected function _construct()
    {
        $this->_init('Vivek\Grid\Model\ResourceModel\Grid');
    }
    /**
     * Get EntityId.
     *
     * @return int
     */
    public function getId()
    {
        return $this->getData(self::ID);
    }

    /**
     * Set EntityId.
     */
    public function setId($id)
    {
        return $this->setData(self::ID, $id);
    }

    /**
     * Get Title.
     *
     * @return varchar
     */
    public function getName()
    {
        return $this->getData(self::NAME);
    }

    /**
     * Set Title.
     */
    public function setName($name)
    {
        return $this->setData(self::NAME, $name);
    }

    /**
     * Get getContent.
     *
     * @return varchar
     */
    public function getDescription()
    {
        return $this->getData(self::DESC);
    }

    /**
     * Set Content.
     */
    public function setDescription($description)
    {
        return $this->setData(self::DESC, $description);
    }


    /**
     * Get IsActive.
     *
     * @return varchar
     */
    public function getEmail()
    {
        return $this->getData(self::EMAIL);
    }

    /**
     * Set IsActive.
     */
    public function setEmail($email)
    {
        return $this->setData(self::EMAIL, $email);
    }


}
