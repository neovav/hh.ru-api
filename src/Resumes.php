<?php
namespace HHruApi;

/**
 * Class for working with resumes on portal hh.ru
 */
class Resumes
{
    private $api;

    /**
     * Constructor of the Resumes class
     *
     * @param Api $api
     */
    public function __construct(Api $api)
    {
        $this->api = $api;
    }
}