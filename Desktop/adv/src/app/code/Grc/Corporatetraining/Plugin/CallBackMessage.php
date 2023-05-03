<?php

namespace Grc\Corporatetraining\Plugin;

use SY\Callback\Controller\Post\Save as Subject;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
class CallBackMessage extends \SY\Callback\Controller\Post\Save
{
    protected $_resultPageFactory;
    public function __construct(Context $context, PageFactory $resultPageFactory)
    {
        parent::__construct($context, $resultPageFactory);
    }

    /**
     * @param Subject $subject
     * @param callable $proceed
     * @return \Magento\Framework\Controller\Result\Redirect
     */
    public function aroundExecute(Subject $subject, callable $proceed){
        $resultRedirect = $this->resultRedirectFactory->create();
        $model = $this->_objectManager->create('SY\\Callback\\Model\\Request');
        $params = $this->getRequest()->getPostValue();
        if($this->getRequest()->getParam('is_product') != "1"){
            unset($params['product_id']);
        }
        $model->setData($params);
        try {
            $model->save();
            $this->messageManager->addSuccess(__('Our representative will get back to you shortly.'));
        } catch (\Exception $e) {
            $this->messageManager->addException($e, __('Something went wrong.'));
        }
        return $resultRedirect->setPath($this->_redirect->getRefererUrl());
    }
}