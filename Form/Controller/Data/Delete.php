<?php

namespace Vivek\Form\Controller\Data;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Vivek\Form\Api\CarsRepositoryInterface;
use Vivek\Form\Api\Data\CarsInterface;


class Delete extends Action
{
    protected $_pageFactory;
    protected $_carsRepository;
    protected $_carsModel;


    public function __construct(
        Context $context,
        PageFactory $pageFactory,
        CarsRepositoryInterface $carsRepository,
        CarsInterface $carsInterface
    ) {
        $this->_pageFactory = $pageFactory;
        $this->_carsRepository = $carsRepository;
        $this->_carsModel = $carsInterface;
        return parent::__construct($context);
    }

    public function execute()
    {
        $id = $_GET['id'];

        try {
            $this->_carsRepository->deleteById($id);
            $this->messageManager->addSuccessMessage("data deleted successfully!");
        } catch (\Exception $exception) {
            $this->messageManager->addErrorMessage(__("Error deleting data"));
        }
        $redirect = $this->resultRedirectFactory->create();
        $redirect->setPath('form');
        return $redirect;
    }
}
