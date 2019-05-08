<?php

namespace Zenmail\Data;

class Contact
{
    /**
     * @property int Contact ID.
     */
    public $id;

    /**
     * @property string Email address.
     */
    public $email;

    /**
     * @property array[Zenmail\Data\List] Lists that this Contact belongs to.
     */
    public $lists;

    /**
     * @property array[int] Shortcut for all List IDs.
    */        
    public $list_ids;

    /**
     * @property array[string] Additional details for this Contact. Keys are Custom Fields tags.
     */
    public $details;

    /**
     * @property mixed Custom Data that can be used freely to create complex personalizations in a Campaign.
     */
    public $custom_data;

    /**
     * @property string How this Contact was added (manual/import).
     */
    public $origin;

    /**
     * All-time statistics, with total counts ('counts' key) and pre-calculated rates ('rates' key).
     * 
     * Counts: opens, clicks, sends, deliveries, bounces, complaints, unsubscriptions.

     * Rates:  open_rate, click_rate, click_to_open_rate, 
     * delivery_rate, unsubscription_rate, complaint_rate, bounce_rate.
     * 
     */
    public $statistics;

    /**
     * @property string Contact status (active, deleted, complained, unsubscribed).
     */
    public $status;

    /**
     * @property string Details of the last time this Contact opened a Campaign.
     */
    public $last_open;

    /**
     * @property string Details of the last time this Contact unsubscribed from a Campaign.
     */
    public $last_unsubscription;

    /**
     * @property DateTime Creation date.
     */
    public $created_at;

    /**
     * @property DateTime Last updated date.
     */
    public $updated_at;
}