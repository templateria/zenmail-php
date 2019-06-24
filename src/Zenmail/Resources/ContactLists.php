<?php

namespace Zenmail\Resources;

use Zenmail\Http;

/**
 * Lists are a way to group your contacts
 */
class ContactLists
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

    /**
     * Returns all Lists optionally matching $query filter.
     * 
     * @param array $query
     * 
     * @return mixed Zenmail\Data\ContactList|Zenmail\Collection
     */
    public function find($query = '')
    {
        $args = [];

        if ($query) {
            $args['name'] = $query;
        }

        return $this->http->api('ContactList', 'GET', "/v1/accounts/{$this->config['account_id']}/lists", $args);
    }

    /**
     * Returns a single List.
     * 
     * @param $id int List ID or email address.
     * 
     * @param Zenmail\Data\ContactList
     */
    public function get($id)
    {
        return $this->http->api('ContactList', 'GET', "/v1/accounts/{$this->config['account_id']}/lists/{$id}");
    }

    /**
     * Deletes a List.
     * 
     * @param $id int List ID.
     * 
     * @return void
     */
    public function delete($id)
    {
        return $this->http->api('ContactList', 'DELETE', "/v1/accounts/{$this->config['account_id']}/lists/{$id}");
    }

    /**
     * Updates a List
     * 
     * @param $id int List ID.
     */
    public function update($id, array $data)
    {
        return $this->http->api('ContactList', 'PATCH', "/v1/accounts/{$this->config['account_id']}/lists/{$id}", ['data' => $data]);
    }

    /**
    * Creates a List
    */
    public function create($data)
    {
        return $this->http->api('ContactList', 'POST', "/v1/accounts/{$this->config['account_id']}/lists", ['data' => $data]);
    }

    /**
     * Adds a Contact to a List. Will create the Contact if it doesn't already exist.
     */
    public function append($id, array $data)
    {
        return $this->http->api('ContactList', 'POST', "/v1/accounts/{$this->config['account_id']}/lists/{$id}/contacts", ['data' => $data]);
    }
}