<?php

namespace Zenmail\Resources;

use Zenmail\Resource;
use Zenmail\Http;

/**
 * Campaigns are all the people you want to send mail to.
 */
class Campaigns extends Resource
{
    /**
     * Returns all Campaigns matching $query filter.
     * 
     * @param array $query
     * 
     * @return mixed Zenmail\Data\Campaign|Zenmail\Collection
     */
    public function find($query)
    {
        return $this->http->api('Campaign', 'GET', "/v1/accounts/{$this->config['account_id']}/campaigns/emailmarketing", ['query' => $query]);
    }

    /**
     * Returns a single Campaign.
     * 
     * @param $id int|string Campaign ID or email address.
     * 
     * @param Zenmail\Data\Campaign
     */
    public function get($id)
    {
        return $this->http->api('Campaign', 'GET', "/v1/accounts/{$this->config['account_id']}/campaigns/emailmarketing/{$id}");
    }

    /**
     * Deletes a Campaign.
     * 
     * @param $id int Campaign ID.
     * 
     * @return void
     */
    public function delete($id)
    {
        return $this->http->api('Campaign', 'DELETE', "/v1/accounts/{$this->config['account_id']}/campaigns/emailmarketing/{$id}");
    }

    /**
     * Updates a Campaign
     * 
     * @param $id int Campaign ID.
     */
    public function update($id, array $data)
    {
        return $this->http->api('Campaign', 'PATCH', "/v1/accounts/{$this->config['account_id']}/campaigns/emailmarketing/{$id}", ['data' => $data]);
    }

    /**
    * Creates a Campaign
    */
    public function create($data)
    {
        return $this->http->api('Campaign', 'POST', "/v1/accounts/{$this->config['account_id']}/campaigns/emailmarketing", ['data' => $data]);
    }
}