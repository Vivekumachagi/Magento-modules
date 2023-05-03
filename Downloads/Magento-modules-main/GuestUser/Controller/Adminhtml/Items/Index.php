<?php

namespace Grc\GuestUser\Controller\Adminhtml\Items;

class Index extends \Grc\Onsitetraining\Controller\Adminhtml\Items
{
    /**
     * Items list.
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('guest_user::test');
        $resultPage->getConfig()->getTitle()->prepend(__('Test Items'));
        $resultPage->addBreadcrumb(__('Test'), __('Test'));
        $resultPage->addBreadcrumb(__('Items'), __('Items'));
        return $resultPage;
    }
}