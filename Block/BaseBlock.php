<?php
/**
 * Copyright © 2015 Unet . All rights reserved.
 */
namespace Unet\DevTool\Block;

use Magento\Framework\UrlFactory;

/**
 * Class BaseBlock
 * @package Unet\DevTool\Block
 */
class BaseBlock extends \Magento\Framework\View\Element\Template
{
    /**
     * @var \Unet\DevTool\Helper\Data
     */
    protected $_devToolHelper;

    /**
     * @var \Magento\Framework\Url
     */
    protected $_urlApp;

    /**
     * @var \Unet\DevTool\Model\Config
     */
    protected $_config;

    /**
     * BaseBlock constructor.
     * @param Context $context
     */
    public function __construct(\Unet\DevTool\Block\Context $context
    ) {
        $this->_devToolHelper = $context->getDevToolHelper();
        $this->_config = $context->getConfig();
        $this->_urlApp = $context->getUrlFactory()->create();
        parent::__construct($context);

    }

    /**
     * Function for getting event details
     * @return array
     */
    public function getEventDetails()
    {
        return $this->_devToolHelper->getEventDetails();
    }

    /**
     * Function for getting current url
     * @return string
     */
    public function getCurrentUrl()
    {
        return $this->_urlApp->getCurrentUrl();
    }

    /**
     * Function for getting controller url for given router path
     * @param string $routePath
     * @return string
     */
    public function getControllerUrl($routePath)
    {

        return $this->_urlApp->getUrl($routePath);
    }

    /**
     * Function for getting current url
     * @param string $path
     * @return string
     */
    public function getConfigValue($path)
    {
        return $this->_config->getCurrentStoreConfigValue($path);
    }

    /**
     * Function canShowDevTool
     * @return bool
     */
    public function canShowDevTool()
    {
        $isEnabled = $this->getConfigValue('devtool/module/is_enabled');
        if ($isEnabled) {
            $allowedIps = $this->getConfigValue('devtool/module/allowed_ip');
            if (is_null($allowedIps)) {
                return true;
            } else {
                $remoteIp = $_SERVER['REMOTE_ADDR'];
                if (strpos($allowedIps, $remoteIp) !== false) {
                    return true;
                }
            }
        }
        return false;
    }

}
