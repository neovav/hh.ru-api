<?php
namespace HHruApi;

use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;

/**
 * Class for work with portal hh.ru
 */
class Api
{
    private $client;

    private $oauth;

    private $vacancies;

    private $resumes;

    private $negotiations;

    public $managerId;

    public $employerId;

    const HOST_API = 'api.hh.ru';

    public function __construct(OAuthCredentials &$credentials, Client &$client = null)
    {
        if (!($client instanceof Client)) {
            $client = new Client();
        }
        $this->client = &$client;
        $this->oauth = new OAuth($credentials, $client);
    }

    /**
     * Return class Client
     *
     * @return Client
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * Return class OAuth
     *
     * @return OAuth
     */
    public function getOAuth()
    {
        return $this->oauth;
    }

    /**
     * Return class Vacancies
     *
     * @return Vacancies
     */
    public function getVacancies()
    {
        if (!($this->vacancies instanceof Vacancies)) {
            $this->vacancies = new Vacancies($this);
        }
        return $this->vacancies;
    }

    /**
     * Return class Resumes
     *
     * @return Resumes
     */
    public function getResumes()
    {
        if (!($this->resumes instanceof Resumes)) {
            $this->resumes = new Resumes($this);
        }
        return $this->resumes;
    }

    /**
     * Return class Negotiations
     *
     * @return Negotiations
     */
    public function getNegotiations()
    {
        if (!($this->negotiations instanceof Negotiations)) {
            $this->negotiations = new Negotiations($this);
        }
        return $this->negotiations;
    }

    /**
     * Request to Api hh.ru
     *
     * @param string $url
     * @param array $headers
     * @param string $method
     * @param string $body
     *
     * @return ResponseInterface
     *
     * @throws
     */
    public function request($url, array $headers = array(), $method = 'GET', $body = null)
    {
        $token = $this->oauth->getToken();

        $headers['Authorization'] = "Bearer $token";

        $options = array(
            'headers' => $headers
        );

        if (in_array($method , array('POST', 'PUT'))) {
            $options['body'] = $body;
        }

        var_dump($url);
        var_dump($method);
        var_dump($options);

        return $this->client->request($method, $url, $options);
    }

    /**
     * GET request to Api hh.ru
     *
     * @param string $url
     * @param string $body
     * @param array $headers
     *
     * @return ResponseInterface
     *
     * @throws
     */
    public function requestPost($url, $body, array $headers = array())
    {
        return $this->request($url, $headers, 'POST', $body);
    }
}