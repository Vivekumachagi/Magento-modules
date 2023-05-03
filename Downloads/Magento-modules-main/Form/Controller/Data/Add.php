<?php

namespace Vivek\Form\Controller\Data;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Vivek\Form\Api\CarsRepositoryInterface;
use Vivek\Form\Api\Data\CarsInterface;

class Add extends Action
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
        $info = $this->getRequest()->getParams();
        $name = $info['author_name'];
        $email = $info['email'];
        $desc = $info['description'];

        $this->_carsModel->setName($name);
        $this->_carsModel->setEmail($email);
        $this->_carsModel->setDesc($desc);

        try {
            $this->_carsRepository->save($this->_carsModel);
            $this->messageManager->addSuccessMessage("data saved successfully!");
        } catch (\Exception $exception) {
            $this->messageManager->addErrorMessage(__("Error saving data"));
         
        }

        $redirect = $this->resultRedirectFactory->create();
        $redirect->setPath('form');
        return $redirect;
    }
}
