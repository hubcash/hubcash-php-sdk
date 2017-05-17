<?php

namespace Hubcash;

/**
 * Class Analyze
 * @package Hubcash
 */
class Analyze
{

    /**
     * @var $AnalyzeId string
     */
    public $AnalyzeId;

    /**
     * @var $Level string
     */
    public $Level;

    /**
     * @var array
     */
    public $Description = array();

    /**
     * @var array
     */
    public $_hiddenSet = [];

    /**
     * @param array $data
     * @return Analyze
     */
    public function ArrayToObject(Array $data)
    {
        $this->AnalyzeId = !empty($data['AnalyzeId']) ? $data['AnalyzeId'] : null;
        $this->Level = !empty($data['Level']) ? $data['Level'] : null;
        $this->Description = !empty($data['Description']) ? $data['Description'] : null;
        return $this;
    }
}