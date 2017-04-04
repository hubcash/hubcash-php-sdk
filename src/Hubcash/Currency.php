<?php

namespace Hubcash;

/**
 * Class Currency
 * @package Hubcash
 */
class Currency extends Hubcash
{
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
    protected $_hiddenSet = [
        'CurrencyId'
    ];

    /**
     * Currency constructor.
     * @param $code
     * @param $token
     */
    public function __construct($code, $token)
    {
        parent::__construct($code, $token);
        $this->_url .= '/currencies';
    }

    /**
     * Retrieve currencies list
     * @return array
     */
    public function getCurrencies()
    {
        $return = $this->sendRequest(self::REQUEST_GET, $this->_url);
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