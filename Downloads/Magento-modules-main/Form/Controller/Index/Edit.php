<?php

namespace Vivek\Form\Controller\Index;

use Magento\Framework\App\Action\Context;

class Edit extends \Magento\Framework\App\Action\Action
{
    protected $_resultPageFactory;
    public function __construct(Context $context, \Magento\Framework\View\Result\PageFactory $resultPageFactory)
    {
        $this->_resultPageFactory = $resultPageFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        return $this->_resultPageFactory->create();
        //  if($this->isCorrect()){
        //    return $this->_resultPageFactory->create();
        //  }
        //  else{

        //  }

        // }
        //     public function isCorrect(){
        //         $id=$this->getRequest()->getParams('id');
        //         if($id){
        //             if($this->modelFactory->create()->load($id)->getId()){
        //                 return true;
        //             }
        //         }
        //         else{   
        //             return false;
        //         }


    }
}
