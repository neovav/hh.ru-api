<?php
namespace HHruApi;

/**
 * Class for working with negotiations on portal hh.ru
 *
 * https://github.com/hhru/api/blob/master/docs/negotiations.md
 */
class Negotiations
{
    private Api $api;

    const QUERY_LIST = '/negotiations';

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
     * Getting list negotiations
     *
     * @param NegotiationsQueryForList $query
     *
     * @return array
     *
     * @throws
     */
    public function getList(NegotiationsQueryForList $query): array
    {
        $url = 'https://' . Api::HOST_API . self::QUERY_LIST;

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