<?php
namespace Vivek\FetchData\Api\Data;

interface ViewInterface
{
    /**#@+
     * Constants for keys of data array. Identical to the name of the getter in snake case
     */
    const ARTICLE_ID            = 'entity_id';
    const TITLE                 = 'email';
    const CONTENT               = 'externalcorp_external_id';
    const CREATED_AT            = 'group_id';
    /**#@-*/


    /**
     * Get Title
     *
     * @return string|null
     */
    public function getTitle();

    /**
     * Get Content
     *
     * @return string|null
     */
    public function getContent();

    /**
     * Get Created At
     *
     * @return string|null
     */
    public function getCreatedAt();

    /**
     * Get ID
     *
     * @return int|null
     */
    public function getId();

    /**
     * Set Title
     *
     * @param string $title
     * @return $this
     */
    public function setTitle($title);

    /**
     * Set Content
     *
     * @param string $content
     * @return $this
     */
    public function setContent($content);

    /**
     * Set Crated At
     *
     * @param int $createdAt
     * @return $this
     */
    public function setCreatedAt($createdAt);

    /**
     * Set ID
     *
     * @param int $id
     * @return $this
     */
    public function setId($id);
}