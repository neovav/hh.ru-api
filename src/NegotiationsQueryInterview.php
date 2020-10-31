<?php
namespace HHruApi;

/**
 * Class for query list negotiations
 */
class NegotiationsQueryInterview
{
    public string $message = '';
    public bool $send_sms = false;
    public ?int $address_id = null;
}