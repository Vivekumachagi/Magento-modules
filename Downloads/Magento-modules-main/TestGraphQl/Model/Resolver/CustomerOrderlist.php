<?php
declare (strict_types=1);

namespace Vivek\TestGraphQl\Model\Resolver;

use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Exception\GraphQlInputException;
use Magento\Framework\GraphQl\Exception\GraphQlNoSuchEntityException;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;

class CustomerOrderlist implements ResolverInterface
{
    protected $orderRepository;
    protected $searchCriteriaBuilder;
    protected $priceCurrency;

    public function __construct(
        \Magento\Sales\Api\OrderRepositoryInterface $orderRepository,
        \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder,
        \Magento\Framework\Pricing\PriceCurrencyInterface $priceCurrency
    )
    {
        $this->orderRepository = $orderRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->priceCurrency = $priceCurrency;
    }

    /**
     * @inheritdoc
     */
    public function resolve(
        Field $field,
        $context,
        ResolveInfo $info,
        array $value = null,
        array $args = null
    )
    {
        $customerId = $this->getCustomerId($args);
        $customerOrderData = $this->getCustomerOrderData($customerId);
        return $customerOrderData;
    }

    /**
     * @param array $args
     * @return int
     * @throws GraphQlInputException
     */
    private function getCustomerId(array $args): int
    {
        if (!isset($args['customer_id'])) {
            throw new GraphQlInputException(__('Customer id should be specified'));
        }
        return (int)$args['customer_id'];
    }

    /**
     * @param int $customerId
     * @return array
     * @throws GraphQlNoSuchEntityException
     */
    private function getCustomerOrderData(int $customerId): array
    {
        try {
          $searchCriteria = $this->searchCriteriaBuilder->addFilter('customer_id', $customerId, 'eq')->create();
            $orderList = $this->orderRepository->getList($searchCriteria);
            $customerOrder = [];
            foreach ($orderList as $order) {
                $order_id = $order->getId();
                $customerOrder[$order_id]['increment_id'] = $order->getIncrementId();
                $customerOrder[$order_id]['customer_name'] = $order->getCustomerFirstname() . ' ' . $order->getCustomerLastname();
                $customerOrder[$order_id]['grand_total'] = $this->priceCurrency->convertAndFormat($order->getGrandTotal(), false);
                $customerOrder[$order_id]['qty'] = $order->getTotalQtyOrdered();
                $customerOrder[$order_id]['shipping_method'] = $order->getShippingMethod();
            }
        } catch (NoSuchEntityException $e) {
            throw new GraphQlNoSuchEntityException(__($e->getMessage()), $e);
        }
        var_dump($customerOrder);
        die;
        return $customerOrder[1];
    }
}
