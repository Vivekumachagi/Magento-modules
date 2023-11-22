<?php

namespace Codilar\Wishlist\Controller\Index;

use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Customer\Model\Session;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\Result\Json;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\Message\ManagerInterface;
use Magento\Wishlist\Model\WishlistFactory;

class AddToWishlist extends Action
{
    protected $productRepository;
    protected $wishlistFactory;
    protected $customerSession;
    protected $jsonResultFactory;

    public function __construct(
        Context                    $context,
        ProductRepositoryInterface $productRepository,
        WishlistFactory            $wishlistFactory,
        Session                    $customerSession,
        JsonFactory                $jsonResultFactory,
        ManagerInterface $messageManager
    )
    {
        parent::__construct($context);
        $this->productRepository = $productRepository;
        $this->wishlistFactory = $wishlistFactory;
        $this->customerSession = $customerSession;
        $this->jsonResultFactory = $jsonResultFactory;
        $this->messageManager = $messageManager;
    }

    /**
     * @return Json
     */
    public function execute()
    {
        $productId = $this->getRequest()->getParam('product');
        $result = $this->jsonResultFactory->create();
        try {
            $product = $this->productRepository->getById($productId);
            if (!$product->getId()) {
                throw new \Exception(__('Product not found.'));
            }
            if (!$this->customerSession->isLoggedIn()) {
                throw new \Exception(__('You must be logged in to add products to your wishlist.'));
            }
            $wishlist = $this->wishlistFactory->create()->loadByCustomerId($this->customerSession->getCustomerId(), true);
            $wishlist->addNewItem($product);
            $wishlist->save();
            $this->messageManager->addSuccessMessage(__('Product moved to the wishlist successfully.'));
            $result->setData(['success' => true]);
        } catch (\Exception $e) {
            $result->setData(['success' => false, 'message' => $e->getMessage()]);
        }
        return $result;
    }
}
