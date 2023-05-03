<?php
namespace Vivek\CodilarProject\Model\ModuleControl;
use Magento\Shipping\Model\Rate\Result;
class Shipme extends \Magento\Shipping\Model\Carrier\AbstractCarrier implements
    \Magento\Shipping\Model\Carrier\CarrierInterface {
    protected $_code = 'shipme';
    /**
     * @var \Magento\Shipping\Model\Rate\ResultFactory
     */
    protected $_rateResultFactory;
    /**
     * @var \Magento\Quote\Model\Quote\Address\RateResult\MethodFactory
     */
    protected $_rateMethodFactory;
    public function __construct(
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Quote\Model\Quote\Address\RateResult\ErrorFactory
        $rateErrorFactory,
        \Psr\Log\LoggerInterface $logger,
        \Magento\Shipping\Model\Rate\ResultFactory $rateResultFactory,
        \Magento\Quote\Model\Quote\Address\RateResult\MethodFactory
        $rateMethodFactory,
        array $data = []
    ) {
        $this->_rateResultFactory = $rateResultFactory;
        $this->_rateMethodFactory = $rateMethodFactory;
        parent::__construct($scopeConfig, $rateErrorFactory, $logger,
            $data);
    }
    public function
    collectRates(\Magento\Quote\Model\Quote\Address\RateRequest $request) {
        if (!$this->getConfigFlag('active')) {
            return false;
        }
        $result = $this->_rateResultFactory->create();
//Check if express method is enabled
        if ($this->getConfigData('express_enabled')) {
            $method = $this->_rateMethodFactory->create();
            $result->append($method);
        }


        return $result;
    }
    public function getAllowedMethods() {
        return ['shipme' => $this->getConfigData('name')];
    }
    public function isTrackingAvailable()
    {
        return true;
    }
}
