<?php

namespace Vivek\GetData\Api\Data;

interface ViewInterface
{

    const ARTICLE_ID            = 'entity_id ';
    const TITLE                 = 'dob';
    const CONTENT               = 'email';
    const CREATED_AT            = 'billing_telephone';

    public function getTitle();

    public function getContent();

    public function getCreatedAt();

    public function getId();

    public function setTitle($title);

    public function setContent($content);

    public function setCreatedAt($createdAt);

    public function setId($id);
}
