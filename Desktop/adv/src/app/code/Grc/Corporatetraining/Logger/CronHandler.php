<?php

namespace Grc\Corporatetraining\Logger;

use Magento\Framework\Logger\Handler\Base;
use Monolog\Logger;

/**
 * Class CronHandler
 * @package Codilar\Catalog\Logger
 */
class CronHandler extends Base
{
    protected $loggerType = Logger::INFO;

    protected $fileName = '/var/log/cronLogger.log';
}