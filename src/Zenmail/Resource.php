<?php

namespace Zenmail;

class Resource
{
    /**
     * @property array Configuration data for the HTTP client.
     */
    protected $config;

    /**
     * @property Zenmail\Http HTTP client.
     */
    protected $http;

    /**
     * Class constructor.
     * 
     * @param array $config Configuration object with Guzzle options and a Zenmail API token.
     * 
     * @return void
     */
    public function __construct($config)
    {
        $this->config = $config;
        $this->http   = new Http($config);
    }
}