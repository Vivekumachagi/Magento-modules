<?php

namespace Codilar\HomePage\Controller\Index;

use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\Result\Json;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\View\Result\PageFactory;

class Seminar implements HttpPostActionInterface
{
    /**
     * @var JsonFactory
     */
    private $jsonFactory;
    /**
     * @var PageFactory
     */
    private $pageFactory;

    /**
     * @param JsonFactory $jsonFactory
     * @param PageFactory $pageFactory
     */
    public function __construct(
        JsonFactory $jsonFactory,
        PageFactory $pageFactory
    )
    {
        $this->jsonFactory = $jsonFactory;
        $this->pageFactory = $pageFactory;
    }

    /**
     * @return Json
     */
    public function execute()
    {
        $result = $this->jsonFactory->create();
        $resultPage = $this->pageFactory->create();
        $block = $resultPage->getLayout()
            ->createBlock('Codilar\HomePage\Block\HomePage')
            ->setTemplate('Codilar_HomePage::upcomingseminar.phtml')
            ->toHtml();
        $result->setData(['upcomingseminar' => $block]);
        return $result;
    }
}
