<?php

namespace Hubcash;

/**
 * Class Brand
 * @package Hubcash
 */
class Brand extends Hubcash
{

    // Brand manager URL
    const BRANDS_URL = self::ENDPOINT . '/brands';

    /**
     * @var $BrandId string
     */
    public $BrandId;

    /**
     * @var $Name string
     */
    public $Name;

    /**
     * @var $Image string
     */
    public $Image;

    /**
     * @var $NumberDigits string
     */
    public $NumberDigits;

    /**
     * @var $NumberSecurity string
     */
    public $NumberSecurity;

    /**
     * @var array
     */
    public $_hiddenSet = [
        'BrandId'
    ];

    /**
     * Retrieve brand list
     * @return array
     */
    public function getBrands()
    {
        $return = $this->sendRequest(self::REQUEST_GET, self::BRANDS_URL);
        $brandsArray = !empty($return['Brands']) ? $return['Brands'] : array();

        /** @var $Brands []Brand */
        $Brands = array();

        // Add received brands into array of Brand
        foreach ($brandsArray as $key => $brand) {
            $Brand = new Brand($this->_code, $this->_token);
            $Brand->ArrayToObject($brand);
            $Brands[$key] = $Brand;
        }

        return $Brands;
    }

    /**
     * Retrieve a single brand from a card initial number
     * @param $number
     * @return Brand
     */
    public function getBrandByNumber($number)
    {
        $return = $this->sendRequest(self::REQUEST_GET, self::BRANDS_URL . "/{$number}");
        return $this->ArrayToObject($return['Brand']);
    }

    /**
     * @param array $data
     * @return Brand
     */
    protected function ArrayToObject(Array $data)
    {
        $this->BrandId = !empty($data['BrandId']) ? $data['BrandId'] : null;
        $this->Name = !empty($data['Name']) ? $data['Name'] : null;
        $this->Image = !empty($data['Image']) ? $data['Image'] : null;
        $this->NumberDigits = !empty($data['NumberDigits']) ? $data['NumberDigits'] : null;
        $this->NumberSecurity = !empty($data['NumberSecurity']) ? $data['NumberSecurity'] : null;
        return $this;
    }

}