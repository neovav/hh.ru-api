<?php
namespace HHruApi;

/**
 * Class for working with personal data on portal hh.ru
 */
class Personal
{
    private $api;

    const QUERY_STRING = '/me';

    /**
     * Constructor of the Vacancies class
     *
     * @param Api $api
     */
    public function __construct(Api $api)
    {
        $this->api = $api;
    }

    /**
     * Get personal data
     *
     * @return array
     *
     * @throws
     */
    public function get()
    {
        $url = 'https://' . Api::HOST_API . self::QUERY_STRING;

        $response = $this->api->request($url);

        $response->getBody()->rewind();
        $body = $response->getBody()->getContents();

        $data = json_decode($body, true);

        if (!is_array($data) || empty($data)) {
            throw new \Exception('Error response personal data');
        }

        return $data;
    }

    /**
     * Change personal data
     *
     * @param PersonalQuery $query
     *
     * @return array
     *
     * @throws
     */
    public function set(PersonalQuery $query)
    {
        $url = 'https://' . Api::HOST_API . self::QUERY_STRING;

        $data = Utils::convertClassToUriQuery($query);

        $headers = ['Content-type' => 'application/x-www-form-urlencoded'];

        $response = $this->api->requestPost($url, $data, $headers);

        $response->getBody()->rewind();
        $body = $response->getBody()->getContents();

        $result = json_decode($body, true);

        if (!is_array($result) || empty($result)) {
            throw new \Exception('Error change personal data');
        }

        return $result;
    }

    /**
     * Get employer address
     *https://github.com/hhru/api/blob/master/docs/employer_addresses.md
     *
     * @param int $employerId
     *
     * @return array
     *
     * @throws
     */
    public function getAddress(int $employerId): array
    {
        $url = 'https://' . Api::HOST_API . "/employers/$employerId/addresses";

        $response = $this->api->request($url);

        $response->getBody()->rewind();
        $body = $response->getBody()->getContents();

        $data = json_decode($body, true);

        if (!is_array($data) || empty($data)) {
            throw new \Exception('Error response get address');
        }

        return $data;
    }
}