<?php
namespace BWMagento\BlockCustomerLogin\Helper;

use BwMagento\Core\Helper\AbstractData;

class Data extends AbstractData
{
    const XML_PATH_BLOCK_CUSTOMER_LOGIN = 'block_customer_login/';
    const XML_PATH_BLOCK_CUSTOMER_LOGIN_ENABLE = 'enable';
    const XML_PATH_BLOCK_CUSTOMER_LOGIN_DEFAULT_ERROR_MESSAGE = 'default_error_message';

    public function getGeneralConfig($code, $storeId = null)
    {
        return $this->getConfigValue(self::XML_PATH_BLOCK_CUSTOMER_LOGIN .'general/'. $code, $storeId);
    }

    public function isModuleEnable() {
        return $this->getGeneralConfig(self::XML_PATH_BLOCK_CUSTOMER_LOGIN_ENABLE);
    }

    public function getDefaultErrorMessage() {
        return $this->getGeneralConfig(self::XML_PATH_BLOCK_CUSTOMER_LOGIN_DEFAULT_ERROR_MESSAGE);
    }
}
