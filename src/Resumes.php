<?php
namespace HHruApi;

/**
 * Class for working with resumes on portal hh.ru
 */
class Resumes
{
    const QUERY_SEARCH = '/resumes';

    private Api $api;

    /**
     * Constructor of the Resumes class
     *
     * @param Api $api
     */
    public function __construct(Api $api)
    {
        $this->api = $api;
    }

    /**
     * Searching resumes
     *
     * @param ResumesQuery $query
     *
     * @return array
     *
     * @throws
     */
    public function search(ResumesQuery $query):array
    {
        $url = 'https://' . Api::HOST_API . self::QUERY_SEARCH;

        $queryString = Utils::convertClassToUriQuery($query);

        if (!empty($queryString)) {
            $url .= "?$queryString";
        }

        $headers = ['Content-type' => 'application/x-www-form-urlencoded'];
        $response = $this->api->request($url, $headers);

        $body = $response->getBody()->getContents();

        $data = json_decode($body, true);

        if (!is_array($data) || empty($data)) {
            throw new \Exception('Error response searching vacancies');
        }

        return $data;
    }
}