<?php

namespace Vivek\AddText\Block;

class Text extends \Magento\Framework\View\Element\Template
{

    // public $scopeConfig;

    // public function __construct(
    //     \Magento\Framework\View\Element\Template\Context $context
    // ) {
    //     parent::__construct($context);
    // }   


    public function getvalue()
    {
         
        $value =  $this->_scopeConfig->getValue('helloworld/general/enable', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        $configText = $this->_scopeConfig->getValue('helloworld/general/display_text', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        if ($value == 1) {
            return $configText;
        } else return " ";
    }
  
}
