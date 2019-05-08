<?php

namespace Zenmail\Resources;

use Zenmail\Http;

/**
 * Contacts are all the people you want to send mail to.
 */
class Contacts
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
     * Returns all Contacts matching $query filter.
     * 
     * Unless specified otherwise in $query, only *active* contacts will be returned.
     * 
     * @param array $query
     * 
     * @return mixed Zenmail\Data\Contact|Zenmail\Collection
     */
    public function find($query)
    {
        return $this->http->api('Contact', 'GET', "/v1/accounts/{$this->config['account_id']}/contacts", ['query' => $query]);
    }

    /**
     * Returns a single contact.
     * 
     * @param $id int|string Contact ID or email address.
     * 
     * @param Zenmail\Data\Contact
     */
    public function get($id)
    {
        if (strpos($id, '@') === false) {
            return $this->http->api('Contact', 'GET', "/v1/accounts/{$this->config['account_id']}/contacts/{$id}");
        }

        $result = $this->http->api('Contact', 'GET', "/v1/accounts/{$this->config['account_id']}/contacts", ['query' => ['email' => $id]]);

        // only one match for an email search
        if (get_class($result) == 'Zenmail\\Collection') {
            foreach ($result as $object) {
                if ($object->email === $id) {
                    return $object;
                }
            }
            return $result->current();
        }

        return $result;
    }

    /**
     * Deletes a Contact.
     * 
     * @param $id int Contact ID.
     * 
     * @return void
     */
    public function delete($id)
    {
        return $this->http->api('Contact', 'DELETE', "/v1/accounts/{$this->config['account_id']}/contacts/{$id}");
    }

    /**
     * Updates a Contact
     * 
     * @param $id int Contact ID.
     */
    public function update($id, array $data)
    {
        return $this->http->api('Contact', 'PATCH', "/v1/accounts/{$this->config['account_id']}/contacts/{$id}", ['data' => $data]);
    }

    /**
    * Creates a Contact
    */
    public function create($data)
    {
        return $this->http->api('Contact', 'POST', "/v1/accounts/{$this->config['account_id']}/contacts", ['data' => $data]);
    }
}