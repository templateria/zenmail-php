<?php

namespace Zenmail;

class Client
{
    /**
     * Zenmail PHP Client version.
     */
    const VERSION = '0.1.0';

    /**
     * @property array Configuration data for the HTTP client.
     */
    protected $config;

    /**
     * @property array[string] Cached instances of Zenmail\\Resources classes to allow a fluent interface ($zenmail->contacts->get()).
     */
    protected $resources = [];

    /**
     * Maps a property name to a Zenmail\Resources class.
     */
    protected $classMap = [
        'contacts' => 'Zenmail\\Resources\\Contacts'
    ];

    /**
     * Class constructor.
     */
    public function __construct(array $config = [])
    {
        $this->config = $config;
    }

    /**
     * Magic method allowing a fluent interface to access all resources ($zenmail->contacts->get()).
     * 
     * @param string Resource to be returned.
     */
    public function __get($resource)
    {
        if (!isset($this->classMap[$resource])) {
            return null;
        }

        if (!isset($this->resources[$resource])) {
            $className = $this->classMap[$resource];
            $this->resources[$resource] = new $className($this->config);
        }

        return $this->resources[$resource];
    }
}