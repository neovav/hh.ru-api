<?php
namespace HHruApi;

/**
 * Class for query list negotiations
 */
class NegotiationsQueryForList
{
    public $page;
    public $per_page;
    public $order_by;
    public $order = 'asc';
    public $vacancy_id;
    public $status;
    public $has_updates = false;
}