<?php

namespace Zenmail;

use GuzzleHttp\Client as Guzzle;

/**
 * HTTP client based on Guzzle with casting helpers to return objects and collections from Zenmail API.
 */
class Http extends Guzzle
{
    /**
     * Zenmail API endpoint.
     */
    const BASE_URL = 'https://api.templateria.com/';

    /**
     * Default timeout for HTTP requests.
     */
    const TIMEOUT  = 10;

    /**
     * Class constructor. Uses the same options as GuzzleHttp\Client and an additional 'token' key.
     */
    public function __construct(array $config = [])
    {
        parent::__construct(array_merge([
            'base_uri' => self::BASE_URL,
            'timeout'  => self::TIMEOUT,
            'headers'  => [
                'Authorization'   => 'Bearer ' . $config['token'],
                'Accept-Encoding' => 'gzip',
                'Content-Type'    => 'application/json',
                'User-Agent'      => 'PHP-Zenmail/' . self::VERSION,
            ],
            'curl.options' => [
                'CURLOPT_SSLVERSION' => 'CURL_SSLVERSION_TLSv1_2',
            ],
        ], $config));
    }

    /**
     * Casts an object of stdClass to $className.
     * 
     * @param $className Class name that the returning data will be cast into
     * @param $instance  Object that will be cast into $className
     * 
     * @return mixed Instance of $className
     */
    protected function cast($className, $instance)
    {
        return unserialize(sprintf(
            'O:%d:"%s"%s',
            \strlen($className),
            $className,
            strstr(strstr(serialize($instance), '"'), ':')
        ));
    }

    /**
     * Sends a request to the API and casts its result into a data object or collection.
     * 
     * @param $dataClass string Class name that the returning data will be cast into
     * @param $method    string HTTP method
     * @param $endpoint  string API endpoint
     * 
     * @return mixed Returns a single object of $dataClass or a Zenmail\Collection of multiple objects.
     */
    public function api($dataClass, $method, $endpoint, array $options = [])
    {
        $dataClass = 'Zenmail\\Data\\' . $dataClass;

        if (isset($options['data'])) {
            $options['json'] = $options['data'];
            unset($options['data']);
        }

        $response  = json_decode((string) $this->request($method, $endpoint, $options)->getBody());

        if (isset($response->pagination)) {
            $collection = new Collection;
            $collection->setPaginationData(json_decode(json_encode($response->pagination)));
            foreach ($response->items as $item) {
                $collection->attach($this->cast($dataClass, json_decode(json_encode($item))));
            }
            $collection->rewind();
            return $collection;
        }

        return new $dataClass(json_decode(json_encode($response)));
    }
}