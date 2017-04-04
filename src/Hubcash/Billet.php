<?php

namespace Hubcash;

/**
 * Class Billet
 * @package Hubcash
 */
class Billet
{
    /**
     * @var $BilletId string
     */
    public $BilletId;

    /**
     * @var $OurNumber string
     */
    public $OurNumber;

    /**
     * @var array
     */
    public $Instructions = array();

    /**
     * @var $ExpiresIn integer
     */
    public $ExpiresIn;

    /**
     * @var $Digitable string
     */
    public $Digitable;

    /**
     * @var $Image string
     */
    public $Image;

    /**
     * @var array
     */
    public $_hiddenSet = [
        'BilletId',
        'Digitable',
        'Image'
    ];

    /**
     * @param array $data
     */
    public function ArrayToObject(Array $data)
    {
        $this->BilletId = !empty($data['BilletId']) ? $data['BilletId'] : null;
        $this->OurNumber = !empty($data['OurNumber']) ? $data['OurNumber'] : null;
        $this->Instructions = !empty($data['Instructions']) ? $data['Instructions'] : null;
        $this->ExpiresIn = !empty($data['ExpiresIn']) ? $data['ExpiresIn'] : null;
        $this->Digitable = !empty($data['Digitable']) ? $data['Digitable'] : null;
        $this->Image = !empty($data['Image']) ? $data['Image'] : null;
    }
}