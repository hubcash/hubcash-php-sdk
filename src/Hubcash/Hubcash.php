<?php

namespace Hubcash;

use GuzzleHttp\Client;

/**
 * Class Hubcash
 * @package Hubcash
 */
class Hubcash
{
    // For http request methods
    const REQUEST_GET = 'GET';
    const REQUEST_POST = 'POST';
    const REQUEST_PUT = 'PUT';
    const REQUEST_DELETE = 'DELETE';

    /**
     * API endpoint
     * @var $_url string
     */
    protected $_url = 'https://api.hubcash.com/v1';

    /**
     * The X-Hubcash-Code header
     * @var $_code string
     */
    protected $_code;

    /**
     * The X-Hubcash-Token header
     * @var $_token string
     */
    protected $_token;

    /**
     * @var $_error string
     */
    protected $_error;

    /**
     * @var array
     */
    public $_hiddenSet;

    /**
     * Hubcash constructor.
     * @param $code
     * @param $token
     */
    public function __construct($code, $token)
    {
        $this->_code = $code;
        $this->_token = $token;
    }

    /**
     * @param $type
     * @param $url
     * @param array $body
     * @return mixed
     * @throws \Exception
     */
    protected function sendRequest($type, $url, Array $body = array())
    {
        // Starts the Guzzle client
        /** @var $client \GuzzleHttp\Client */
        $client = new Client();
        $res = $client->request($type, $url, [
            'headers' => [
                'Content-Type' => 'application/json',
                'X-Hubcash-Token' => $this->_token,
                'X-Hubcash-Code' => $this->_code
            ],
            'body' => json_encode($body),
            'http_errors' => false,
        ]);

        // Parse the data into a decoded json
        $data = json_decode($res->getBody(), true);

        if ($res->getStatusCode() != '200') {
            // When the response code is different then 200,
            // we need to handle the errors list and throw in new Exceptions
            if (isset($data['Errors'])) {
                foreach ($data['Errors'] as $error) {
                    if (isset($error['Field']) && isset($error['Description'])) {
                        throw new \Exception($error['Field'] . ': ' . $error['Description']);
                    } else {
                        throw new \Exception('Hubcash invalid request: ' . json_encode($body['Errors']));
                    }
                }
            } else {
                // None Errors has retrieved, but the API
                // response code returned an error
                throw new \Exception('Hubcash invalid request. Please, contact your administrator.');
            }
        }

        // For the http response code 200
        return $data;
    }


    /**
     * @param null $obj
     * @return array
     */
    protected function getArrayToSend($obj = null)
    {
        $ObjToArray = empty($obj) ? get_object_vars($this) : get_object_vars($obj);
        $obj = empty($obj) ? $this : $obj;

        $data = array();
        foreach ($ObjToArray as $key => $value) {

            if (empty($value)) {
                continue;
            }

            // Remove property that start with _ and are in _hiddenSet
            if (substr($key, 0, 1) !== '_' && !in_array($key, $obj->_hiddenSet)) {

                // If is array and object, repeat function again
                if (is_array($value)) {
                    foreach ($value as $key2 => $value2) {
                        if (is_object($value2)) {
                            $value[$key2] = self::getArrayToSend($value2);
                        }
                    }
                }

                if (!is_object($value)) {
                    $data[$key] = $value;
                } else {
                    $data[$key] = self::getArrayToSend($value);
                }
            }
        }

        return $data;
    }

}