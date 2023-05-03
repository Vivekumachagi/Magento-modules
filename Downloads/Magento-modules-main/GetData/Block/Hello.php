<?php

namespace Vivek\GetData\Block;

use \Magento\Framework\View\Element\Template;
use \Magento\Framework\View\Element\Template\Context;
use \Vivek\GetData\Model\ResourceModel\View\CollectionFactory as ViewCollectionFactory;

class Hello extends \Magento\Framework\View\Element\Template
{

    public function getText()
    {
        return "Hello World";
    }

    public function number()
    {
        return "1234567890";
    }

    protected $_viewCollectionFactory = null;


    public function __construct(
        Context $context,
        ViewCollectionFactory $viewCollectionFactory,
        array $data = []
    ) {
        $this->_viewCollectionFactory  = $viewCollectionFactory;
        parent::__construct($context, $data);
    }


    public function getCollection()
    {

        $viewCollection = $this->_viewCollectionFactory->create();
        $viewCollection->addFieldToSelect('*')->load();
        return $viewCollection->getItems();
    }


    public function getArticleUrl($viewId)
    {
        return $this->getUrl('blog/index/view/' . $viewId, ['_secure' => true]);
    }
}
