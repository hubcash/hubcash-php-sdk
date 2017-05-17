<?php

namespace Hubcash;

/**
 * Class Consumer
 * @package Hubcash
 */
class Consumer extends Hubcash
{

    /**
     * @var $ConsumerId string
     */
    public $ConsumerId;

    /**
     * @var $Name string
     */
    public $Name;

    /**
     * @var $Email string
     */
    public $Email;

    /**
     * @var $Birthdate string
     */
    public $Birthdate;

    /**
     * @var $DocumentNumber string
     */
    public $DocumentNumber;

    /**
     * @var $DocumentType string
     */
    public $DocumentType;

    /**
     * @var $Gender string
     */
    public $Gender;

    /**
     * @var $HomePhone string
     */
    public $HomePhone;

    /**
     * @var $MobilePhone string
     */
    public $MobilePhone;

    /**
     * @var $WorkPhone string
     */
    public $WorkPhone;

    /**
     * @var array
     */
    public $_hiddenSet = [
        'ConsumerId'
    ];

    /**
     * @param array $data
     * @return Consumer
     */
    public function ArrayToObject(Array $data)
    {
        $this->ConsumerId = !empty($data['ConsumerId']) ? $data['ConsumerId'] : null;
        $this->Name = !empty($data['Name']) ? $data['Name'] : null;
        $this->Email = !empty($data['Email']) ? $data['Email'] : null;
        $this->Birthdate = !empty($data['Birthdate']) ? $data['Birthdate'] : null;
        $this->DocumentNumber = !empty($data['DocumentNumber']) ? $data['DocumentNumber'] : null;
        $this->DocumentType = !empty($data['DocumentType']) ? $data['DocumentType'] : null;
        $this->Gender = !empty($data['Gender']) ? $data['Gender'] : null;
        $this->HomePhone = !empty($data['HomePhone']) ? $data['HomePhone'] : null;
        $this->MobilePhone = !empty($data['MobilePhone']) ? $data['MobilePhone'] : null;
        $this->WorkPhone = !empty($data['WorkPhone']) ? $data['WorkPhone'] : null;
        return $this;
    }
}