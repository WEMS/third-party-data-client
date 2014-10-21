<?php

namespace Wems\Api\ThirdPartyData;

class DataRow
{

    /** @var int */
    protected $timestamp;

    /** @var mixed */
    protected $value;

    /**
     * @param int   $timestamp
     * @param mixed $value
     */
    public function __construct($timestamp, $value)
    {
        $this->timestamp = $timestamp;
        $this->value     = $value;
    }

    /**
     * in readiness for php 5.4
     *
     * @return array
     */
    public function jsonSerialize()
    {
        return array(
            'timestamp' => $this->timestamp,
            'value'     => $this->value,
        );
    }

}
