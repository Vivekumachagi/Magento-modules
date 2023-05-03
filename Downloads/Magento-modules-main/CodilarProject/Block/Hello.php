<?php

namespace Vivek\CodilarProject\Block;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Vivek\CodilarProject\Model\ResourceModel\Cars\CollectionFactory as ViewCollectionFactory;
use Vivek\CodilarProject\Model\CarsFactory as ModelFactory;
use Vivek\CodilarProject\Model\CarsRepository as CarRepository;

class Hello extends Template
{
    protected $_viewCollectionFactory = null;
    protected $searchCriteria;
    private $resultRedirectFactory;

    public function __construct(
        Context $context,
        ViewCollectionFactory $viewCollectionFactory,
        ModelFactory $modelFactory,
        CarRepository $CarRepository,
        \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteria,
        array $data = []
    )
    {
        parent::__construct($context, $data);
        $this->_viewCollectionFactory = $viewCollectionFactory;
        $this->modelFactory = $modelFactory;
        $this->CarRepository = $CarRepository;
        $this->searchCriteria = $searchCriteria;

    }
    public function getvalue()
    {

        $value =  $this->_scopeConfig->getValue('moduleenable/general/enable', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
            return $value;

    }



    public function fetch()
    {
        $searchCriteriaBuilder = $this->searchCriteria->create();
        $list = $this->CarRepository->getList($searchCriteriaBuilder);
        return $list->getItems();
    }

    public function getCollection()
    {
        // return $this->getUrl('form/data/Getlist');
        // $val = $this->getId();
        // $viewCollection = $this->_viewCollec tionFactory->create();
        // $viewCollection->addFieldToSelect('*')->load();
        // return $viewCollection->getItems();
    }
    public function routeToHome()
    {
        return $this->getUrl('codilarproject/index/route');

    }

    public function delete()
    {
        return $this->getUrl('form/data/delete');
    }

    public function edit()
    {
        return $this->getUrl('form/index/edit');
    }

    public function editAuther()
    {
        return $this->getUrl('form/data/edit');
    }

    public function getAddCarPostUrl()
    {

        return $this->getUrl('codilarproject/data/add');
    }

    public function getCustomerById()
    {

        $customerId = $this->getRequest()->getParams('id');
        return $this->modelFactory->create()->load($customerId);
    }
}
