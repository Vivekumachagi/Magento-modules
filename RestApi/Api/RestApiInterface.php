<?php

namespace Vivek\RestApi\Api;

use phpDocumentor\Reflection\Types\Collection;


interface RestApiInterface
{
    /**
     * Get all posts.
     *
     * @return array
     */
      public function getAllPosts();

    /**
     * Filter posts by id.
     *
     * @param int $id
     * @return array
     */
    public function getAllPost(int $id) : array;

    /**
     * @param int $id
     * @return mixed
     */
    public function getById(int $id);

    /**
     * GET product by its ID
     *
     * @api
     * @param string $id
     * @return \Magento\Catalog\Api\Data\ProductInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getProductById($id);

    /**
     * @param $id
     * @return mixed
     */
    public function getApiData(int $id);

    /**
     * @param $id
     * @return mixed
     */
    public function getProductsById(int $id);

}
