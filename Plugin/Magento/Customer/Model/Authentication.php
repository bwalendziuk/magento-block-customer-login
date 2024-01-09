<?php

declare(strict_types=1);

namespace BWMagento\BlockCustomerLogin\Plugin\Magento\Customer\Model;

use BWMagento\BlockCustomerLogin\Helper\Data;
use Magento\Customer\Model\CustomerRegistry;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Phrase;
use Magento\Framework\Stdlib\DateTime\DateTimeFactory;

class Authentication
{
    /**
     * @var CustomerRegistry
     */
    protected $customerRegistry;

    /**
     * @var DateTimeFactory
     */
    private $dateTimeFactory;

    /**
     * @var Data
     */
    private Data $dataHelper;


    public function __construct(CustomerRegistry $customerRegistry, DateTimeFactory $dateTimeFactory, Data $data)
    {
        $this->customerRegistry = $customerRegistry;
        $this->dateTimeFactory = $dateTimeFactory;
        $this->dataHelper = $data;
    }

    /**
     * @throws NoSuchEntityException
     * @throws LocalizedException
     */
    public function afterAuthenticate(
        \Magento\Customer\Model\Authentication $subject,
        $result,
        $customerId,
        $password
    ) {
        if ($result === true && $this->dataHelper->isModuleEnable()) {
            if ($this->customerRegistry->retrieve($customerId)->getData('is_locked_login')) {
                $blockAccountExpires = $this->customerRegistry->retrieve($customerId)->getData('block_account_expires');

                if ($blockAccountExpires) {
                    if (strtotime($blockAccountExpires) > strtotime($this->getCurrentDate())) {
                        throw new LocalizedException(new Phrase($this->dataHelper->getDefaultErrorMessage()));
                    }
                } else {
                    throw new LocalizedException(new Phrase($this->dataHelper->getDefaultErrorMessage()));
                }
            }
        }

        return $result;
    }

    private function getCurrentDate()
    {
        $dateModel = $this->dateTimeFactory->create();
        return $dateModel->gmtDate();
    }
}
