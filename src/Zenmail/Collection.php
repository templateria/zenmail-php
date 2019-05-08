<?php

namespace Zenmail;

use SplObjectStorage;

class Collection extends SplObjectStorage
{
    /**
     * Pagination data returned by the API.
     * 
     * @param first_page
     * @param last_page
     * @param page_size
     * @param total_items
     * @param order_by
     * @param order
     * @param filters
     * @param current_page_items
     * @param starts_at
     * @param ends_at
     */
    protected $pagination = [];

    /**
     * Sets the pagination data.
     * 
     * @return void
     */
    public function setPaginationData($data)
    {
        $this->pagination = $data;
    }

    /**
     * Returns the pagination data of the request that this collection represents.
     * 
     * @see $pagination
     * 
     * @return array Pagination data.
     */
    public function getPaginationData()
    {
        return $this->pagination;
    }

    /**
     * Returns the ID of the object returned by the API to be used by SplObjectStorage as key.
     * 
     * @return string Object ID
     */
    public function getHash($object)
    {
        return (string) $object->id;
    }
}