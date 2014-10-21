<?php

namespace Wems\Api\ThirdPartyData;

use Guzzle\Http\Client as HttpClient;

class Client
{

    /** @var string */
    protected $url;

    /** @var string */
    protected $object;

    /** @var DataRow[] */
    protected $data;

    /** @var HttpClient */
    protected $httpClient;

    /** @var bool */
    protected $authenticated = false;

    /**
     * @param string $url
     */
    final public function __construct($url)
    {
        $this->url = $url;

        $this->httpClient = new HttpClient($this->url, array(
            'exceptions' => false,
        ));
    }

    /**
     * @param string $username
     * @param string $password
     *
     * @return $this
     */
    final public function setBasicAuth($username, $password)
    {
        $this->httpClient->setDefaultOption('auth', array($username, $password, 'Basic'));

        $this->authenticated = true;

        return $this;
    }

    /**
     * @param string $apiKey
     *
     * @return $this
     */
    final public function setApiKey($apiKey)
    {
        $this->httpClient->setDefaultOption('headers/x-api-key', $apiKey);

        $this->authenticated = true;

        return $this;
    }

    /**
     * @param string $object The object's unique ID
     *
     * @return $this
     */
    final public function setObject($object)
    {
        $this->object = $object;

        return $this;
    }

    /**
     * @param int   $timestamp
     * @param mixed $value
     *
     * @return $this
     */
    final public function addData($timestamp, $value)
    {
        $this->data[] = new DataRow($timestamp, $value);

        return $this;
    }

    /**
     * @return array
     */
    final protected function getData()
    {
        $data = array();
        foreach ($this->data as $row) {
            $data[] = $row->jsonSerialize();
        }
        return $data;
    }

    /**
     * @return string
     */
    final protected function getPost()
    {
        return json_encode(array(
            'object' => $this->object,
            'data'   => $this->getData(),
        ));
    }

    /**
     * @return Result
     * @throws Exception
     */
    public function send()
    {
        if (!$this->authenticated) {
            throw new Exception(
                'You must setup authentication using either ' . __CLASS__ . '::setBasicAuth or ' . __CLASS__ . '::setApiKey'
            );
        }

        $req = $this->httpClient->post($this->url, null, $this->getPost(), array('exceptions' => false));

        $response = $req->send();

        $status = $response->getStatusCode();
        $body   = $response->getBody(true);

        return new Result($status, $body);
    }

}
