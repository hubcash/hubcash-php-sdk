<?php

namespace Hubcash;

/**
 * Class NotificationSale
 * @package Hubcash
 */
class NotificationSale
{

    /**
     * @var $SaleId string
     */
    public $SaleId;

    /**
     * @var $Status integer
     */
    public $Status;

    /**
     * @var array
     */
    public $_hiddenSet = [];

    /**
     * @param array $data
     */
    public function ArrayToObject(Array $data)
    {
        $this->SaleId = !empty($data['SaleId']) ? $data['SaleId'] : null;
        $this->Status = !empty($data['Status']) ? $data['Status'] : null;
    }
}