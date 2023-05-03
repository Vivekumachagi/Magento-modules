<?php
namespace Grc\Corporatetraining\Plugin;
use Magento\Backend\Model\UrlInterface;
use Magento\Framework\App\Cache\Manager;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\Config\Storage\WriterInterface;
use \SY\Attachments\Model\System\Message\Advertisment as subject;

class AdvertismentPlugin extends subject
{
    /**
     * @param ScopeConfigInterface $scopeConfig
     * @param UrlInterface $urlInterface
     * @param WriterInterface $configWriter
     * @param Manager $cacheManager
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig,
        UrlInterface $urlInterface,
        WriterInterface $configWriter,
        Manager $cacheManager
    )
    {
        parent::__construct($scopeConfig, $urlInterface, $configWriter, $cacheManager);
    }

    /**
     * @param subject $subject
     * @param callable $proceed
     * @return void
     */
    public function aroundGetText(subject $subject, callable $proceed)
    {
        return null;
    }

}