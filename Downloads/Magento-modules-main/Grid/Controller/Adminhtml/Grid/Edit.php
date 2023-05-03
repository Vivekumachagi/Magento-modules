<?php
namespace Vivek\Grid\Controller\Adminhtml\Grid;



class Edit extends \Magento\Backend\App\Action
{
   
    protected $_resultPageFactory;
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->_resultPageFactory = $resultPageFactory;
    }
    public function execute()
    {
        $resultPage = $this->_resultPageFactory->create();
        $resultPage->setActiveMenu('Vivek_Grid::grid_edit');
        return $resultPage;
    }
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Vivek_Grid::grid_edit');
    }
}