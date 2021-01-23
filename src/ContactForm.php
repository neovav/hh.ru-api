<?php
namespace HHruApi;

/**
 */
class ContactForm
{
    /**
     *      values:
     *          home
     *          work
     *          cell
     *          email
     */
    public string $type = 'cell';

    /**
     * @var string|string[] $value
     *      array(
     *          'country' => string,
     *          'city'  => string,
     *          'number' => string,
     *          'formatted' => string
     * )
     * if type email, then $value = 'address@subdomain.rootdomain'
     */
    public $value;

    public bool $preferred = false;

    public string $comment = '';
}