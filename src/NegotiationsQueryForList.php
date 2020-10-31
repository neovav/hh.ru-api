<?php
namespace HHruApi;

/**
 * Class for query list negotiations
 */
class NegotiationsQueryForList
{
    public int $page = 0;
    public int $per_page = 100;
    public string $order_by = '';
    public string $order = 'asc';
    public ?int $vacancy_id = null;
    public string $status = '';
    public bool $has_updates = false;
}