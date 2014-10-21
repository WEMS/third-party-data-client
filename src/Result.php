<?php

namespace Wems\Api\ThirdPartyData;

class Result
{

    /** @var int */
    protected $statusCode;

    /** @var string */
    protected $responseBody;

    /**
     * @param int    $statusCode
     * @param string $responseBody
     */
    public function __construct($statusCode, $responseBody)
    {
        $this->statusCode   = $statusCode;
        $this->responseBody = $responseBody;
    }

    /**
     * @return int
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * @return string
     */
    public function getResponseBody()
    {
        return $this->responseBody;
    }

}
