<?php

namespace Vivek\CodilarProject\Controller\Index;

use Magento\Customer\Model\Session;
use Magento\Framework\App\Action\Context;
use Magento\Store\Model\ScopeInterface;

class Route extends \Magento\Framework\App\Action\Action
{

//    const XML_PATH_EXTENSION_ENABLED = 'moduleenable/general/enabled/';
    protected $_resultPageFactory;
    protected $_customerSession;
    private $scopeConfig;


    public function __construct(
        Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        Session $customerSession
    )

    {
        $this->_resultPageFactory = $resultPageFactory;
        $this->_customerSession = $customerSession;
        parent::__construct($context);

    }


    public function execute()
    {


            $redirect = $this->resultRedirectFactory->create();
            $redirect->setPath('customer/account/login');
            return $redirect;


    }

//    public function getConfigValue($field, $storeId = null)
//    {
//        return $this->scopeConfig->getValue(
//            $field, ScopeInterface::SCOPE_STORE, $storeId
//        );
//    }
//
//    private function moduleEnabled()
//    {
//        return (bool)$this->getConfigValue(
//            self::XML_PATH_EXTENSION_ENABLED,
//            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
//        );
//    }


}
