<?php
/**
 * Webkul_Grid Grid Interface.
 *
 * @category    Webkul
 *
 * @author      Webkul Software Private Limited
 */
namespace Vivek\Grid\Api\Data;

interface GridInterface
{
    /**
     * Constants for keys of data array. Identical to the name of the getter in snake case.
     */
    const ID = 'id';
    const NAME = 'author_name';
    const EMAIL = 'email';
    const DESC = 'description';
  
    /**
     * Get EntityId.
     *
     * @return int
     */
    public function getId();

    /**
     * Set EntityId.
     */
    public function setId($id);

    /**
     * Get Title.
     *
     * @return varchar
     */
    public function getName();

    /**
     * Set Title.
     */
    public function setName($name);

    /**
     * Get Content.
     *
     * @return varchar
     */
    public function getEmail();

    /**
     * Set Content.
     */
    public function setEmail($email);

    public function getDescription();

    /**
     * Set Content.
     */
    public function setDescription($description);

 


   

}