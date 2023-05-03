<?php

namespace Vivek\RestApi\Model;


use Magento\Framework\Mview\ViewInterfaceFactory;
use Vivek\RestApi\Model\RestApiFactory;
use Vivek\RestApi\Model\ResourceModel\View\CollectionFactory;

class RestApi implements \Vivek\RestApi\Api\RestApiInterface
{
    private $fruits = [];

    public function __construct(
        \Magento\Catalog\Api\ProductRepositoryInterface $productRepository,
        ViewInterfaceFactory $productInterfaceFactory, array $fruits = [])
    {
        $this->productInterfaceFactory = $productInterfaceFactory;
        $this->productRepository = $productRepository;
        $this->fruits = $fruits;
    }

    /**
     *
     * private $posts = [
     * [
     * "id" => 1,
     * "title" => "My Post 1",
     * "categories" => ["my posts", "custom posts"],
     * "description" => "Lorem Ipsum is simply dummy text of the printing and typesetting ind"
     * ],
     * [
     * "id" => 2,
     * "title" => "My Post 2",
     * "categories" => ["my posts", "custom post2"],
     * "description" => "Lorem Ipsum is simply dummy text of the printing and typesetting ind"
     *
     * ]
     * ];
     *
     * /**
     * @var \Magento\Catalog\Api\ProductRepositoryInterface
     */

    protected $productRepository;
    const SEVERE_ERROR = 0;
    const SUCCESS = 1;
    const LOCAL_ERROR = 2;
    protected $_testApiFactory;
    private $ViewInterfaceFactory;

    /**
     * get test Api data.
     *
     * @param int $id
     *
     * @return array
     * @api
     *
     */
    public function getApiData(int $id)
    {
        var_dump($this->fruits);
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance(); // Instance of object manager
        $resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
        $connection = $resource->getConnection();
        $tableName = $resource->getTableName('form_data');
        $select = $connection->select()
            ->from(
                ['p' => $tableName]);
        $data = $connection->fetchAll($select);
        if (empty($data)) {
            return [];
        }
        $postData = [];
        foreach ($data as $post) {

            if ($id == $post['id']) {
                $postData [] = $post;
                break;
            }
        }
        return $postData;

//        try {
//            $model = $this->_testApiFactory
//                ->create();
//            if (!$model->getId()) {
//                throw new \Magento\Framework\Exception\LocalizedException(
//                    __('no data found')
//                );
//            }
//            return $model;
//        } catch (\Magento\Framework\Exception\LocalizedException $e) {
//            $returnArray['error'] = $e->getMessage();
//            $returnArray['status'] = 0;
//            $this->getJsonResponse(
//                $returnArray
//            );
//        } catch (\Exception $e) {
//            $this->createLog($e);
//            $returnArray['error'] = __('unable to process request');
//            $returnArray['status'] = 2;
//            $this->getJsonResponse(
//                $returnArray
//            );
//        }
    }

    /**
     * {@inheritdoc}
     */
    public function getProductById($id)
    {


        return $this->productRepository->getById($id);

    }

    public function getAllPosts()
    {
        return $this->posts;
    }

    public function getAllPost(int $id): array
    {
        $posts = $this->getAllPosts();

        if (empty($posts)) {
            return [];
        }
        $postData = [];
        foreach ($posts as $post) {

            if ($id == $post['id']) {
                $postData [] = $post;
                break;
            }
        }
        return $postData;

    }

    /**
     *Get Product by its ID
     *
     * @param int $id
     * @return \Vivek\RestApi\Api\Data\ViewInterface
     * @throws NoSuchEntityException
     */
    public function getProductsById(int $id)
    {
        $productInterface = $this->ViewInterfaceFactory->create();
        $product = $this->productRepository->getById($id);
        $productInterface->setId($product->getId());
        $productInterface->setName($product->getName());
        $productInterface->setEmail($product->getEmail());
        $productInterface->setDescription($product->getDescription());
        return $productInterface;

    }


    public function getById(int $id)
    {
        try {
            $model = $this->_testApiFactory
                ->create();
            if (!$model->getId()) {
                throw new \Magento\Framework\Exception\LocalizedException(
                    __('no data found')
                );
            }
            return $model;
        } catch (\Magento\Framework\Exception\LocalizedException $e) {
            $returnArray['error'] = $e->getMessage();
            $returnArray['status'] = 0;
            $this->getJsonResponse(
                $returnArray
            );
        } catch (\Exception $e) {
            $this->createLog($e);
            $returnArray['error'] = __('unable to process request');
            $returnArray['status'] = 2;
            $this->getJsonResponse(
                $returnArray
            );
        }
        // TODO: Implement getById() method.
//        $object = $this->objectFactory->create();
//        $this->objectResourceModel->load($object, $id);
//        if (!$object->getId()) {
//
//            throw new NoSuchEntityException(__('Object with id "%1" does not exist.', $id));
//        }
//        return $object;
    }
}
