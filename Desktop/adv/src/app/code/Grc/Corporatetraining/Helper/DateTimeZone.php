<?php

namespace Grc\Corporatetraining\Helper;

use DateTime;
use DateTimeZone as TimeZone;
use Grc\Corporatetraining\Logger\CronLogger;
use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Stdlib\DateTime\TimezoneInterface;

class DateTimeZone extends AbstractHelper
{
    const PDT_TIMEZONE = "America/Los_Angeles";
    const EST_TIMEZONE = "America/New_York";
    /**
     * @var TimezoneInterface
     */
    protected $_timezoneInterface;
    /**
     * @var ProductRepositoryInterface
     */
    protected $productRepository;
    /**
     * @var CronLogger
     */
    private $cronLogger;

    /**
     * @param Context $context
     * @param TimezoneInterface $timezoneInterface
     * @param ProductRepositoryInterface $productRepository
     * @param CronLogger $cronLogger
     */
    public function __construct(Context                    $context,
                                TimezoneInterface          $timezoneInterface,
                                ProductRepositoryInterface $productRepository,
                                CronLogger                 $cronLogger)
    {
        parent::__construct($context);
        $this->_timezoneInterface = $timezoneInterface;
        $this->productRepository = $productRepository;
        $this->cronLogger = $cronLogger;
    }

    /**
     * @param $sku
     * @return ProductInterface
     * @throws NoSuchEntityException
     */
    public function getProductBySku($sku): ProductInterface
    {
        return $this->productRepository->get($sku);
    }

    /**
     * @return string
     */
    public function getTimeAccordingToTimeZone(): string
    {
        return $this->_timezoneInterface->date()->format('Y-m-d h:i:s');
    }

    /**
     * @param $webinarDate
     * @param $productBackEndTimeZone
     * @return array
     * @throws \Exception
     */
    public function toDisplayDates($webinarDate, $productBackEndTimeZone): array
    {
        if ($productBackEndTimeZone == "EST") {
            $pdtWebinarDate = $this->getTimePdtTimezone(self::PDT_TIMEZONE, $webinarDate);
            $estWebinarDate = $this->getLocalTimeObject($webinarDate);
        } else {
            $pdtDate = $this->getDateTimeAccordingToTimeZone($webinarDate);
            $pdtWebinarDate = new DateTime($pdtDate, new TimeZone(self::PDT_TIMEZONE));
            $estDateTime = clone $pdtWebinarDate;
            $estWebinarDate = $estDateTime->setTimezone(new TimeZone(self::EST_TIMEZONE));
        }
        return ['est' => $estWebinarDate, 'pdt' => $pdtWebinarDate];
    }

    /**
     * @param $timezone
     * @param $date
     * @return \DateTime
     * @throws \Exception
     */
    public function getTimePdtTimezone($timezone, $date): DateTime
    {
        return $this->_timezoneInterface->date($date)->setTimezone(new \DateTimeZone($timezone));
    }

    /**
     * @param $date
     * @return DateTime
     * @throws \Exception
     */
    public function getLocalTimeObject($date): DateTime
    {
        return $this->_timezoneInterface->date(new \DateTime($date));
    }

    /**
     * @param $date
     * @return string
     * @throws \Exception
     */
    public function getDateTimeAccordingToTimeZone($date): string
    {
        return $this->_timezoneInterface->date(new \DateTime($date))->format('Y-m-d h:i:s');
    }


    /**
     * @param $sku
     * @return void
     */
    public function attendeeTypeEmptyLog($sku)
    {
        $this->cronLogger->log(500, 'Attendee Type not selected for product ' . $sku);
    }
}
