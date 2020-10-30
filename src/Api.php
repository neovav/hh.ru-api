<?php
namespace HHruApi;

use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;

/**
 * Class for work with portal hh.ru
 */
class Api
{
    private Client $client;

    private OAuth $oauth;

    private ?Vacancies $vacancies = null;

    private ?Resumes $resumes = null;

    private ?Negotiations $negotiations = null;

    private ?Personal $personal = null;

    public int $managerId;

    public int $employerId;

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
    public function getClient(): Client
    {
        return $this->client;
    }

    /**
     * Return class OAuth
     *
     * @return OAuth
     */
    public function getOAuth(): OAuth
    {
        return $this->oauth;
    }

    /**
     * Return class Vacancies
     *
     * @return Vacancies
     */
    public function getVacancies(): Vacancies
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
    public function getResumes(): Resumes
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
    public function getNegotiations(): Negotiations
    {
        if (!($this->negotiations instanceof Negotiations)) {
            $this->negotiations = new Negotiations($this);
        }
        return $this->negotiations;
    }

    /**
     * Return class Negotiations
     *
     * @return Personal
     */
    public function getPersonal(): Personal
    {
        if (!($this->personal instanceof Personal)) {
            $this->personal = new Personal($this);
        }
        return $this->personal;
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
    public function request(string $url, array $headers = [], string $method = 'GET', string $body = null): ResponseInterface
    {
        $token = $this->oauth->getToken();

        $headers['Authorization'] = "Bearer $token";

        $options = ['headers' => $headers];

        if (in_array($method , ['POST', 'PUT'])) {
            $options['body'] = $body;
        }

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
    public function requestPost(string $url, string $body, array $headers = []): ResponseInterface
    {
        return $this->request($url, $headers, 'POST', $body);
    }
}