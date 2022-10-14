<?php

namespace Vivek\Form\Block;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Vivek\Form\Model\ResourceModel\Cars\CollectionFactory as ViewCollectionFactory;
use Vivek\Form\Model\CarsFactory as ModelFactory;
use Vivek\Form\Model\CarsRepository as CarRepository;

class Form extends Template
{

   
    protected $_viewCollectionFactory = null;

    protected $searchCriteria;


    public function __construct(
        Context $context,
        ViewCollectionFactory $viewCollectionFactory,
        ModelFactory $modelFactory,
        CarRepository $CarRepository,
        \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteria,
        array $data = []
    ) {
         parent::__construct($context, $data);
        $this->_viewCollectionFactory  = $viewCollectionFactory;
        $this->modelFactory = $modelFactory;
        $this->CarRepository = $CarRepository;
        $this->searchCriteria = $searchCriteria;
       
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

    public function getAddCarPostUrl() {
        return $this->getUrl('form/data/add');
    }
    
    public function getCustomerById()
    {
        $customerId=$this->getRequest()->getParams('id');
       return $this->modelFactory->create()->load($customerId);
    }
}
