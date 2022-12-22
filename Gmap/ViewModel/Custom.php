<?php
namespace Grc\Gmap\ViewModel;
use Magento\Framework\View\Element\Block\ArgumentInterface;

class Custom extends \Magento\Framework\View\Element\Template implements \Magento\Framework\View\Element\Block\ArgumentInterface
{

    public function __construct(
        \Magento\Framework\Registry $registry,
        \Magento\Catalog\Model\Category $categoryModel
    ) {
        $this->registry = $registry;
        $this->categoryModel = $categoryModel;
    }

    public function getProductCatagory()
    {
        $product = $this->registry->registry('current_product');
        $categories = $product->getCategoryIds(); /*will return category ids array*/
        $arr =[];
        foreach($categories as $category){
            $cat = $this->categoryModel->load($category);
            $arr[]   = $cat->getName();
        }
        return $arr;
    }

}