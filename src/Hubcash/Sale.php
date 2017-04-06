<?php

namespace Hubcash;

/**
 * Class Sale
 * @package Hubcash
 */
class Sale extends Hubcash
{

    // Sale manager URL
    const SALES_URL = self::ENDPOINT . '/sales';

    // For Sale status
    const STATUS_PROCESSED = 1;
    const STATUS_ANALYZING = 2;
    const STATUS_CAPTURING = 3;
    const STATUS_WAITING_PAYMENT = 4;
    const STATUS_FAIL = 5;
    const STATUS_CANCELED = 6;
    const STATUS_DONE = 7;

    // For Sale methods
    const METHOD_CREDIT = 'Credit';
    const METHOD_DEBIT = 'Debit';
    const METHOD_BILLET = 'Billet';

    /**
     * @var $SaleId string
     */
    public $SaleId;

    /**
     * @var $Ref string
     */
    public $Ref;

    /**
     * @var $Amount integer
     */
    public $Amount;

    /**
     * @var $Quota boolean
     */
    public $Quota;

    /**
     * @var $QuotaQty integer
     */
    public $QuotaQty;

    /**
     * @var $Currency string
     */
    public $Currency;

    /**
     * @var $Method string
     */
    public $Method;

    /**
     * @var $Capture boolean
     */
    public $Capture;

    /**
     * @var $DateCanceled string
     */
    public $DateCanceled;

    /**
     * @var $DateCaptured string
     */
    public $DateCaptured;

    /**
     * @var $DateReversed string
     */
    public $DateReversed;

    /**
     * @var $DateUpdated string
     */
    public $DateUpdated;

    /**
     * @var $DateAdded string
     */
    public $DateAdded;

    /**
     * @var $Consumer Consumer
     */
    public $Consumer;

    /**
     * @var $BillingAddress Address
     */
    public $BillingAddress;

    /**
     * @var $ShippingAddress Address
     */
    public $ShippingAddress;

    /**
     * @var $Items []Item
     */
    public $Items;

    /**
     * @var $Card Card
     */
    public $Card;

    /**
     * @var $Billet Billet
     */
    public $Billet;

    /**
     * @var $Analyze []Analyze
     */
    public $Analyze = array();

    /**
     * @var $Rollback []Rollback
     */
    public $Rollback = array();

    /**
     * @var $History []History
     */
    public $History = array();

    /**
     * @var $Status integer
     */
    public $Status;

    /**
     * @var array
     */
    public $_hiddenSet = [
        'SaleId',
        'DateCanceled',
        'DateCaptured',
        'DateReversed',
        'DateUpdated',
        'DateAdded',
        'Analyze',
        'Rollback',
        'History',
        'Status',
    ];

    /**
     * Sale constructor.
     */
    public function __construct()
    {
        // Add relational objects into the Sale
        $this->Items = array();
        $this->Billet = new Billet();
        $this->Card = new Card();
        $this->Consumer = new Consumer();
        $this->BillingAddress = new Address();
        $this->ShippingAddress = new Address();
    }

    /**
     * Create a new sale
     */
    public function create()
    {
        $return = $this->sendRequest(self::REQUEST_POST, self::SALES_URL, $this->getArrayToSend());
        return $this->ArrayToObject($return['Sale']);
    }

    /**
     * Retrieve Sale list using filters and pagination assets
     * @param null $page
     * @param null $ref
     * @param null $currency
     * @param null $method
     * @param null $capture
     * @param null $status
     * @return array
     */
    public function getSales($page = null, $ref = null, $currency = null, $method = null, $capture = null, $status = null)
    {
        // Build the query from the filters
        $url = self::SALES_URL;
        $params = http_build_query(array(
            'pg' => $page,
            'Ref' => $ref,
            'Currency' => $currency,
            'Method' => $method,
            'Capture' => $capture,
            'Status' => $status
        ));
        $url .= !empty($params) ? '?' . $params : null;

        $return = $this->sendRequest(self::REQUEST_GET, $url);
        $salesArray = !empty($return['Sales']) ? $return['Sales'] : array();

        /** @var $Sales []Sale */
        $Sales = array();

        // Add received sales into array of Sale
        foreach ($salesArray as $key => $sale) {
            $Sale = new Sale($this->_code, $this->_token);
            $Sale->ArrayToObject($sale);
            $Sales[$key] = $Sale;
        }

        return $Sales;
    }


    /**
     * Get details of a Sale by identifier
     * @param $id
     */
    public function getSale($id)
    {
        $return = $this->sendRequest(self::REQUEST_GET, self::SALES_URL . "/{$id}");
        return $this->ArrayToObject($return['Sale']);
    }


    /**
     * Capture a Sale by identifier
     * @param null $id
     * @throws \Exception
     */
    public function capture($id = null)
    {
        $url = self::SALES_URL . '/capture';
        // For validate if the object SaleId or var is valid
        if (!empty($this->SaleId)) {
            $url .= "/{$this->SaleId}";
        } else {
            // When the SaleId in the object is empty
            // check if the id var received with the function is valid
            if (empty($id)) {
                throw new \Exception('SaleId is required');
            }
            $url .= "/{$id}";
        }

        $return = $this->sendRequest(self::REQUEST_PUT, $url);
        return $this->ArrayToObject($return['Sale']);
    }


    /**
     * @param null $id
     * @throws \Exception
     */
    public function cancel($id = null)
    {
        $url = self::SALES_URL . '/cancel';
        // For validate if the object SaleId or var is valid
        if (!empty($this->SaleId)) {
            $url .= "/{$this->SaleId}";
        } else {
            if (empty($id)) {
                // When the SaleId in the object is empty
                // check if the id var received with the function is valid
                throw new \Exception('SaleId is required');
            }
            $url .= "/{$id}";
        }

        $return = $this->sendRequest(self::REQUEST_PUT, $url);
        return $this->ArrayToObject($return['Sale']);
    }

    /**
     * @param array $data
     */
    protected function ArrayToObject(Array $data)
    {
        $this->SaleId = !empty($data['SaleId']) ? $data['SaleId'] : null;
        $this->Ref = !empty($data['Ref']) ? $data['Ref'] : null;
        $this->Amount = !empty($data['Amount']) ? $data['Amount'] : null;
        $this->Quota = !empty($data['Quota']) ? $data['Quota'] : null;
        $this->QuotaQty = !empty($data['QuotaQty']) ? $data['QuotaQty'] : null;
        $this->Currency = !empty($data['Currency']) ? $data['Currency'] : null;
        $this->Method = !empty($data['Method']) ? $data['Method'] : null;
        $this->Capture = !empty($data['Capture']) ? $data['Capture'] : null;
        $this->DateCanceled = !empty($data['DateCanceled']) ? $data['DateCanceled'] : null;
        $this->DateCaptured = !empty($data['DateCaptured']) ? $data['DateCaptured'] : null;
        $this->DateReversed = !empty($data['DateReversed']) ? $data['DateReversed'] : null;
        $this->DateUpdated = !empty($data['DateUpdated']) ? $data['DateUpdated'] : null;
        $this->DateAdded = !empty($data['DateAdded']) ? $data['DateAdded'] : null;
        $this->Status = !empty($data['Status']) ? $data['Status'] : null;

        // The Sale can contain additional data,
        // provided for another records in the API, with uses his identifiers

        // Add the Consumer
        if (!empty($data['Consumer'])) {
            $this->Consumer->ArrayToObject($data['Consumer']);
        } else {
            unset($this->Consumer);
        }

        // Add the BillingAddress
        if (!empty($data['BillingAddress'])) {
            $this->BillingAddress->ArrayToObject($data['BillingAddress']);
        } else {
            unset($this->BillingAddress);
        }

        // Add the ShippingAddress
        if (!empty($data['ShippingAddress'])) {
            $this->ShippingAddress->ArrayToObject($data['ShippingAddress']);
        } else {
            unset($this->ShippingAddress);
        }

        // Add the Analyze array
        if (!empty($data['Analyze'])) {
            foreach ($data['Analyze'] as $analyze) {
                $Analyze = new Analyze();
                $Analyze->ArrayToObject($analyze);
                $this->Analyze[] = $Analyze;
            }
        } else {
            unset($this->Analyze);
        }

        // Add the Rollback array
        if (!empty($data['Rollback'])) {
            foreach ($data['Rollback'] as $rollback) {
                $Rollback = new Rollback();
                $Rollback->ArrayToObject($rollback);
                $this->Rollback[] = $Rollback;
            }
        } else {
            unset($this->Rollback);
        }

        // Add the History array
        if (!empty($data['History'])) {
            foreach ($data['History'] as $history) {
                $History = new History();
                $History->ArrayToObject($history);
                $this->History[] = $History;
            }
        } else {
            unset($this->History);
        }

        // Add the Items array
        if (!empty($data['Items'])) {
            foreach ($data['Items'] as $item) {
                $Item = new Item();
                $Item->ArrayToObject($item);
                $this->Items[] = $Item;
            }
        } else {
            unset($this->Items);
        }

        // Add the Card
        if (!empty($data['Card'])) {
            $this->Card->ArrayToObject($data['Card']);
        } else {
            unset($this->Card);
        }

        // Add the Billet
        if (!empty($data['Billet'])) {
            $this->Billet->ArrayToObject($data['Billet']);
        } else {
            unset($this->Billet);
        }
    }

}