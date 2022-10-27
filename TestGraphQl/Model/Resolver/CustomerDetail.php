<?php
/**
 * @author       Mohan
 * @copyright    Copyright (c) 2022 (https://mage2db.com)
 * @package      CustomerGraphQl
 */
namespace Vivek\TestGraphQl\Model\Resolver;

use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Exception\GraphQlInputException;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\GraphQl\Exception\GraphQlNoSuchEntityException;
use Magento\Store\Model\StoreManagerInterface;

class CustomerDetail implements ResolverInterface
{

    protected $_customerSession;
    protected $_customerFactory;
    protected $_addressFactory;
    protected $storeManager;

    /**
     * @param Field $field
     * @param \Magento\Framework\GraphQl\Query\Resolver\ContextInterface $context
     * @param ResolveInfo $info
     * @param array|null $value
     * @param array|null $args
     * @return array|\Magento\Framework\GraphQl\Query\Resolver\Value|mixed
     * @throws GraphQlInputException
     */

    public function __construct(

        \Magento\Customer\Model\SessionFactory $customerSession,
        \Magento\Customer\Model\CustomerFactory $customerFactory,
        \Magento\Customer\Model\AddressFactory $addressFactory,
        \Magento\Framework\Url $url,
        StoreManagerInterface $storeManager
    )
    {
        $this->_customerSession = $customerSession->create();
        $this->_customerFactory = $customerFactory;
        $this->_addressFactory  = $addressFactory;
        $this->urlHelper = $url;
        $this->storeManager = $storeManager;

    }

    public function resolve(
        Field $field,
        $context,
        ResolveInfo $info,
        array $value = null,
        array $args = null)
    {
        $currentStoreId = $this->storeManager->getStore()->getId();

        $Customer_Collection = $this->_customerFactory->create()->load($args['id']);
        $data[] = $Customer_Collection->getData()->getName();
        var_dump($data);
        die;

        return $Customer_Collection->getData();
    }
}
