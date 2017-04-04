<?php

namespace Hubcash;

/**
 * Class Card
 * @package Hubcash
 */
class Card extends Hubcash
{
    /**
     * @var $CardId string
     */
    public $CardId;

    /**
     * @var $Brand string
     */
    public $Brand;

    /**
     * @var $HolderName string
     */
    public $HolderName;

    /**
     * @var $Document string
     */
    public $Document;

    /**
     * @var $Phone string
     */
    public $Phone;

    /**
     * @var $LastDigits string
     */
    public $LastDigits;

    /**
     * @var $ExpMonth string
     */
    public $ExpMonth;

    /**
     * @var $ExpYear string
     */
    public $ExpYear;

    /**
     * @var $Number string
     */
    public $Number;

    /**
     * @var $SecurityCode string
     */
    public $SecurityCode;

    /**
     * @var $Pages string
     */
    public $Pages;

    /**
     * @var array
     */
    public $_hiddenSet = [
        'CardId',
        'Pages'
    ];

    /**
     * Card constructor
     * @param $code
     * @param $token
     */
    public function __construct($code, $token)
    {
        parent::__construct($code, $token);
        $this->_url .= '/cards';
    }

    /**
     * Creates a new card
     */
    public function create()
    {
        $return = $this->sendRequest(self::REQUEST_POST, $this->_url, $this->getArrayToSend());
        $this->ArrayToObject($return['Card']);
    }


    /**
     * Retrieve Card list using a document
     * @param $document
     * @param null $page
     * @return array
     */
    public function getCards($document, $page = null)
    {
        $url = $this->_url;
        $url .= !empty($page) ? "/document/{$document}?pg={$page}" : "/document/{$document}";

        $return = $this->sendRequest(self::REQUEST_GET, $url);
        $cardsArray = !empty($return['Cards']) ? $return['Cards'] : array();

        /** @var $Cards []Card */
        $Cards = array();

        // Add received cards into array of Card
        foreach ($cardsArray as $key => $card) {
            $Card = new Card($this->_code, $this->_token);
            $Card->ArrayToObject($card);

            $Cards[$key] = $Card;
        }

        return $Cards;
    }

    /**
     * Get details of a Card by identifier
     * @param $id
     */
    public function getCard($id)
    {
        $return = $this->sendRequest(self::REQUEST_GET, $this->_url . "/{$id}");
        $this->ArrayToObject($return['Card']);
    }

    /**
     * Update a Card by identifier
     * @param null $id
     * @throws \Exception
     */
    public function update($id = null)
    {
        // For validate if the object CardId or var is valid
        if (!empty($this->CardId)) {
            $url = $this->_url . "/{$this->CardId}";
        } else {
            // When the CardId in the object is empty
            // check if the id var received with the function is valid
            if (empty($id)) {
                throw new \Exception('CardId is required');
            }
            $url = $this->_url . "/{$id}";
        }

        $return = $this->sendRequest(self::REQUEST_PUT, $url, $this->getArrayToSend());
        $this->ArrayToObject($return['Card']);
    }


    /**
     * Delete a Card by identifier
     * @param null $id
     * @return bool
     * @throws \Exception
     */
    public function delete($id = null)
    {
        // For validate if the object CardId or var is valid
        if (!empty($this->CardId)) {
            $url = $this->_url . "/{$this->CardId}";
        } else {
            // When the CardId in the object is empty
            // check if the id var received with the function is valid
            if (empty($id)) {
                throw new \Exception('CardId is required');
            }
            $url = $this->_url . "/{$id}";
        }

        $this->sendRequest(self::REQUEST_DELETE, $url);
        return true;
    }


    /**
     * @param array $data
     */
    public function ArrayToObject(Array $data)
    {
        $this->CardId = !empty($data['CardId']) ? $data['CardId'] : null;
        $this->Brand = !empty($data['Brand']) ? $data['Brand'] : null;
        $this->HolderName = !empty($data['HolderName']) ? $data['HolderName'] : null;
        $this->LastDigits = !empty($data['LastDigits']) ? $data['LastDigits'] : null;
        $this->ExpMonth = !empty($data['ExpMonth']) ? $data['ExpMonth'] : null;
        $this->ExpYear = !empty($data['ExpYear']) ? $data['ExpYear'] : null;
        $this->Number = !empty($data['ExpYear']) ? $data['ExpYear'] : null;
        $this->SecurityCode = !empty($data['SecurityCode']) ? $data['SecurityCode'] : null;
        $this->Pages = !empty($data['Pages']) ? $data['Pages'] : null;
    }

    /**
     * @param null $obj
     * @return mixed
     */
    public function getArrayToSend($obj = null)
    {
        $arrayToSend['Card'] = parent::getArrayToSend($obj = null);
        return $arrayToSend;
    }

}