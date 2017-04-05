<?php

namespace Hubcash;

/**
 * Class Rollback
 * @package Hubcash
 */
class Rollback
{

    /**
     * @var $RollbackId string
     */
    public $RollbackId;

    /**
     * @var $Reason string
     */
    public $Reason;

    /**
     * @var $Obs string
     */
    public $Obs;

    /**
     * @var $Date string
     */
    public $Date;

    /**
     * @var array
     */
    public $_hiddenSet = [];

    /**
     * @param array $data
     */
    public function ArrayToObject(Array $data)
    {
        $this->RollbackId = !empty($data['RollbackId']) ? $data['RollbackId'] : null;
        $this->Reason = !empty($data['Reason']) ? $data['Reason'] : null;
        $this->Obs = !empty($data['Obs']) ? $data['Obs'] : null;
        $this->Date = !empty($data['Date']) ? $data['Date'] : null;
    }
}