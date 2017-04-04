<?php

namespace Hubcash;

/**
 * Class Address
 * @package Hubcash
 */
class Address extends Hubcash
{
    /**
     * @var $AddressId string
     */
    public $AddressId;

    /**
     * @var $City string
     */
    public $City;

    /**
     * @var $Complement string
     */
    public $Complement;

    /**
     * @var $Country string
     */
    public $Country;

    /**
     * @var $District string
     */
    public $District;

    /**
     * @var $Number string
     */
    public $Number;

    /**
     * @var $State string
     */
    public $State;

    /**
     * @var $Street string
     */
    public $Street;

    /**
     * @var $ZipCode string
     */
    public $ZipCode;

    /**
     * @var array
     */
    public $_hiddenSet = [
        'AddressId'
    ];

    /**
     * @param array $data
     */
    public function ArrayToObject(Array $data)
    {
        $this->AddressId = !empty($data['AddressId']) ? $data['AddressId'] : null;
        $this->City = !empty($data['City']) ? $data['City'] : null;
        $this->Complement = !empty($data['Complement']) ? $data['Complement'] : null;
        $this->Country = !empty($data['Country']) ? $data['Country'] : null;
        $this->District = !empty($data['District']) ? $data['District'] : null;
        $this->Number = !empty($data['Number']) ? $data['Number'] : null;
        $this->State = !empty($data['State']) ? $data['State'] : null;
        $this->Street = !empty($data['Street']) ? $data['Street'] : null;
        $this->ZipCode = !empty($data['ZipCode']) ? $data['ZipCode'] : null;
    }
}