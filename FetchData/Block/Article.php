<?php
namespace Vivek\FetchData\Block;

use \Magento\Framework\View\Element\Template;
use \Magento\Framework\View\Element\Template\Context;
use \Vivek\FetchData\Model\ResourceModel\View\CollectionFactory as ViewCollectionFactory;

class Article extends Template
{
    /**
     * CollectionFactory
     * @var null|CollectionFactory
     */
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
        /** @var ViewCollection $viewCollection */
        $viewCollection = $this->_viewCollectionFactory ->create();
        $viewCollection->addFieldToSelect('*')->load();
        return $viewCollection->getItems();
    }

    /**
     * For a given post, returns its url
     * @param Post $post
     * @return string
     */
    public function getArticleUrl($viewId) {
         return $this->getUrl('blog/index/view/'.$viewId, ['_secure' => true]);
    }

}