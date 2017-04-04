<?php

namespace Hubcash;

/**
 * Class Item
 * @package Hubcash
 */
class Item
{
    /**
     * @var $ItemId string
     */
    public $ItemId;

    /**
     * @var $Name string
     */
    public $Name;

    /**
     * @var $Description string
     */
    public $Description;

    /**
     * @var $Amount integer
     */
    public $Amount;

    /**
     * @var $Qty integer
     */
    public $Qty;

    /**
     * @var array
     */
    public $_hiddenSet = [
        'ItemId'
    ];

    /**
     * @param array $data
     */
    public function ArrayToObject(Array $data)
    {
        $this->ItemId = !empty($data['ItemId']) ? $data['ItemId'] : null;
        $this->Name = !empty($data['Name']) ? $data['Name'] : null;
        $this->Description = !empty($data['Description']) ? $data['Description'] : null;
        $this->Amount = !empty($data['Amount']) ? $data['Amount'] : null;
        $this->Qty = !empty($data['Qty']) ? $data['Qty'] : null;
    }
}