<?php

namespace Vivek\CodilarProject\Controller\Data;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Result\PageFactory;
use Magento\Ui\Component\MassAction\Filter;
use Vivek\CodilarProject\Api\CarsRepositoryInterface;
use Vivek\CodilarProject\Api\Data\CarsInterface;
use Magento\Customer\Model\Session;
use Vivek\Grid\Model\ResourceModel\Grid\CollectionFactory;

class Add extends Action
{
    protected $_pageFactory;
    protected $_carsRepository;
    protected $_carsModel;
    protected $_customerSession;
    private $searchCriteriaBuilder;
    /**
     * Massactions filter.​_
     * @var Filter
     */
    protected $_filter;

    /**
     * @var CollectionFactory
     */
    protected $_collectionFactory;
    /**
     * @var \Magento\Framework\Api\SearchCriteriaBuilder
     */


    /**
     * @param Context $context
     * @param PageFactory $pageFactory
     * @param CarsRepositoryInterface $carsRepository
     * @param Session $customerSession
     * @param \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteria
     * @param CarsInterface $carsInterface
     * @param Filter $filter
     * @param CollectionFactory $collectionFactory
     */

    public function __construct(
        Context $context,
        PageFactory $pageFactory,
        CarsRepositoryInterface $carsRepository,
        Session $customerSession,
        \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteria,
        CarsInterface $carsInterface,
        Filter $filter,
        CollectionFactory $collectionFactory
    )
    {
        $this->_pageFactory = $pageFactory;
        $this->_carsRepository = $carsRepository;
        $this->_carsModel = $carsInterface;
        $this->_customerSession = $customerSession;
        $this->searchCriteria = $searchCriteria;
        $this->_filter = $filter;
        $this->_collectionFactory = $collectionFactory;
        return parent::__construct($context);
    }

    public function execute()
    {
        $email = $this->_customerSession->getCustomer()->getEmail();
        if ($email == null) {
            $redirect = $this->resultRedirectFactory->create();
            $redirect->setPath('customer/account/login');
            return $redirect;
        } else {
            $info = $this->getRequest()->getParams();
            $datetime = $info['time_period'];

            $name = $info['slot_name'];
            $parts = explode(" ", $datetime);
            $date = $parts[0];
            $time = $parts[1];
            $permission = 0;
            try {
                $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
                $searchCriteriaBuilder = $objectManager->create('Magento\Framework\Api\SearchCriteriaBuilder');
                $searchCriteria = $searchCriteriaBuilder->addFilter('booking_id', '%%', 'like')->create();
                $values = $this->_carsRepository->getList($searchCriteria);
                $item = $values->getItems();
                foreach ($item as $data) {
                    $compare = $data['date'] . " " . $data['time_details'];
                    if ($compare == $datetime) {
                        $permission = 1;
                    } else {
                        $permission = 0;
                    }
                }
                if ($permission == 1) {
                    $this->messageManager->addErrorMessage(__("slot you choosen already booked"));
                } else {
                    $this->_carsModel->setDate($date);
                    $this->_carsModel->setTime($time);
                    try {
                        $this->_carsRepository->save($this->_carsModel);
                        $this->messageManager->addSuccessMessage("data saved successfully!");
                    } catch (\Exception $exception) {
                        $this->messageManager->addErrorMessage(__("Error saving data"));
                    }
                }
                $redirect = $this->resultRedirectFactory->create();
                $redirect->setPath('codilarproject');
                return $redirect;

            } catch (NoSuchEntityException $e) {

            }

        }


//        $email = $this->_customerSession->getCustomer()->getEmail();
//
//        $info = $this->getRequest()->getParams();
//        $str = $info['time_period'];
//        $parts = explode(" ", $str);
//        $date = $parts[0];
//        $time = $parts[1];
//        $bookingDetail = $info['time_period'];
//        $value = array($time => $email);
//        $values = serialize($value);
//        $auther = $this->_carsRepository->getByDate($date);
//        var_dump($auther);
//        die;
////        $auther->setDate($date);
////        $auther->setTime($time);
////        $this->_carsModel->setDate($date);
////        $this->_carsModel->setTime($time);
//        try {
//            $this->_carsRepository->save($this->_carsModel);
//
//            $this->messageManager->addSuccessMessage("data saved successfully!");
//        } catch (\Exception $exception) {
//            $this->messageManager->addErrorMessage(__("Error saving data"));
//
//        }
//
//        $redirect = $this->resultRedirectFactory->create();
//        $redirect->setPath('codilarproject');
//        return $redirect;
    }


}
