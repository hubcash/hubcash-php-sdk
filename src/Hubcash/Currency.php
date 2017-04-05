<?php

namespace Hubcash;

/**
 * Class Currency
 * @package Hubcash
 */
class Currency extends Hubcash
{

    // Currency manager URL
    const CURRENCIES_URL = self::ENDPOINT . '/currencies';

    /**
     * @var $CurrencyId string
     */
    public $CurrencyId;

    /**
     * @var $Name string
     */
    public $Name;

    /**
     * @var $SymbolLeft string
     */
    public $SymbolLeft;

    /**
     * @var $SymbolRight string
     */
    public $SymbolRight;

    /**
     * @var $DecimalPlace string
     */
    public $DecimalPlace;

    /**
     * @var array
     */
    public $_hiddenSet = [
        'CurrencyId'
    ];

    /**
     * Retrieve currencies list
     * @return array
     */
    public function getCurrencies()
    {
        $return = $this->sendRequest(self::REQUEST_GET, self::CURRENCIES_URL);
        $currenciesArray = !empty($return['Currencies']) ? $return['Currencies'] : array();

        /** @var $Currencies []Currency */
        $Currencies = array();

        // Add received currencies into array of Currency
        foreach ($currenciesArray as $key => $currency) {
            $Currency = new Currency($this->_code, $this->_token);
            $Currency->ArrayToObject($currency);
            $Currencies[$key] = $Currency;
        }

        return $Currencies;
    }

    /**
     * @param array $data
     */
    protected function ArrayToObject(Array $data)
    {
        $this->CurrencyId = !empty($data['CurrencyId']) ? $data['CurrencyId'] : null;
        $this->Name = !empty($data['Name']) ? $data['Name'] : null;
        $this->SymbolLeft = !empty($data['SymbolLeft']) ? $data['SymbolLeft'] : null;
        $this->SymbolRight = !empty($data['SymbolRight']) ? $data['SymbolRight'] : null;
        $this->DecimalPlace = !empty($data['DecimalPlace']) ? $data['DecimalPlace'] : null;
    }

}