<?php
namespace Ariadne\Client;

use Zend\Http\Client as HttpClient;

class BaseClient
{
    /**
     * Http client
     *
     * @var Client $client
     */
    protected $httpClient;

    /**
     * Set required dependencies
     *
     * @param Client http client
     */
    public function __construct(HttpClient $httpClient)
    {
        $this->httpClient = $httpClient;
    }

}