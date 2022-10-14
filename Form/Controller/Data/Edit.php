<?php

namespace Vivek\Form\Controller\Data;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\View\Result\PageFactory;
use Vivek\Form\Api\CarsRepositoryInterface;
use Vivek\Form\Api\Data\CarsInterface;

class Edit extends Action
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
        $id = $info['author_id'];
        $name = $info['author_name'];
        $email = $info['email'];
        $desc = $info['description'];
        $auther = $this->_carsRepository->getById($id);
        $auther->setName($name);
        $auther->setEmail($email);
        $auther->setDesc($desc);

        try {
            $this->_carsRepository->save($auther);
            $this->messageManager->addSuccessMessage("data edited successfully!");
        } catch (CouldNotSaveException $e) {
            echo $e->getMessage();
            $this->messageManager->addErrorMessage(__("Error editing data"));
        }
        $redirect = $this->resultRedirectFactory->create();
        $redirect->setPath('form');
        return $redirect;
    }
}
