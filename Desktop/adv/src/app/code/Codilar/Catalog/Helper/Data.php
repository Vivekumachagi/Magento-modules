<?php

namespace Codilar\Catalog\Helper;

use Grc\Corporatetraining\Helper\DateTimeZone;
use Magento\Catalog\Model\Product\Option;
use Magento\Directory\Model\Currency;
use Magento\Eav\Api\AttributeSetRepositoryInterface;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Class Data
 */
class Data extends AbstractHelper
{
    const WEBINAR = 'Webinar';

    const SEMINAR = "Seminar";

    const ONE_DIAL_ONE_ATTENDEE = "live";

    const RECORDED_VERSION = "recorded";

    const RECORDED_USB_DRIVE = "recorded_usb";
    /**
     * @var Option
     */
    private $productOption;
    /**
     * @var AttributeSetRepositoryInterface
     */
    private $attributeSetRepository;

    /**
     * @var DateTimeZone
     */
    private $dateTimeZoneHelper;

    /**
     * @var Currency
     */
    private $currencySymbol;

    /**
     * @param Context $context
     * @param Option $productOption
     * @param AttributeSetRepositoryInterface $attributeSetRepository
     * @param DateTimeZone $dateTimeZoneHelper
     * @param Currency $currencySymbol
     */
    public function __construct(
        Context                         $context,
        Option                          $productOption,
        AttributeSetRepositoryInterface $attributeSetRepository,
        DateTimeZone                    $dateTimeZoneHelper,
        Currency                        $currencySymbol
    )
    {
        $this->productOption = $productOption;
        $this->attributeSetRepository = $attributeSetRepository;
        $this->dateTimeZoneHelper = $dateTimeZoneHelper;
        $this->currencySymbol = $currencySymbol;
        parent::__construct($context);
    }

    /**
     * Get the lowest price from customizable options of products
     *
     * @param $product
     * @return float
     * @throws NoSuchEntityException
     */
    public function getCustomizableOptions($product)
    {
        $attributeSetId = $product->getAttributeSetId();
        $attributeSet = $this->attributeSetRepository->get($attributeSetId)->getAttributeSetName();
        $optionsData = $this->productOption->getProductOptionCollection($product);
        $webinarEndDate = $product->getWebinarEndDate();
        $webEndTime = $this->dateTimeZoneHelper->getDateTimeAccordingToTimeZone($webinarEndDate);
        $currentDate = $this->dateTimeZoneHelper->getTimeAccordingToTimeZone();
        $price = [];
        if (count($optionsData) != 0) {
            foreach ($optionsData as $option) {
                $optionValues = $option->getValues();
                if (!empty($optionValues)) {
                    if ($attributeSet === self::WEBINAR) {
                        if ((strtotime($webEndTime) >= strtotime($currentDate)) &&
                            $option->getAttendeeType() === self::ONE_DIAL_ONE_ATTENDEE) {
                            foreach ($optionValues as $values) {
                                $optionTypeId = $values->getOptionTypeId();
                                $price[$optionTypeId] = $values->getPrice();
                            }
                        } elseif ((strtotime($webEndTime) < strtotime($currentDate)) &&
                            ($option->getAttendeeType() === self::RECORDED_VERSION ||
                                $option->getAttendeeType() === self::RECORDED_USB_DRIVE)) {
                            foreach ($optionValues as $values) {
                                $optionTypeId = $values->getOptionTypeId();
                                $price[$optionTypeId] = $values->getPrice();
                            }
                        }
                    } elseif ($attributeSet === self::SEMINAR) {
                        foreach ($optionValues as $values) {
                            $optionTypeId = $values->getOptionTypeId();
                            $price[$optionTypeId] = $values->getPrice();
                        }
                    }
                }
            }
            if ($price) {
                return min($price);
            }
        }
        return 0;
    }

    /**
     * Get product currency symbol
     *
     * @return string
     */
    public function getProductCurrencySymbol()
    {
        return $this->currencySymbol->getCurrencySymbol();
    }
}
