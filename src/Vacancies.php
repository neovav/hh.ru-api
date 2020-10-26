<?php
namespace HHruApi;

/**
 * Class for working with vacancies on portal hh.ru
 */
class Vacancies
{
    private $api;

    const QUERY_SEARCH = '/vacancies';

    const QUERY_PUBLIC = '/vacancies';

    const QUERY_ACTIVE = '/employers';

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
     * Searching vacancies
     *
     * @param VacanciesQuery $query
     *
     * @return array
     *
     * @throws
     */
    public function search(VacanciesQuery $query)
    {
        $url = 'https://' . Api::HOST_API . self::QUERY_SEARCH;

        $queryString = Utils::convertClassToUriQuery($query);

        if (!empty($queryString)) {
            $url .= "?$queryString";
        }

        $headers = array('Content-type' => 'application/x-www-form-urlencoded');
        $response = $this->api->request($url, $headers);

        $body = $response->getBody()->getContents();

        $data = json_decode($body, true);

        if (!is_array($data) || empty($data)) {
            throw new \Exception('Error response searching vacancies');
        }

        return $data;
    }

    /**
     * Return list active vacancies
     *
     * @param int $employerId
     * @param VacanciesQueryActive $query
     *
     * @return array
     *
     * @throws
     */
    public function getActive($employerId, VacanciesQueryActive $query = null)
    {
        $url = 'https://' . Api::HOST_API . self::QUERY_ACTIVE . "/$employerId/vacancies/active";

        $queryString = Utils::convertClassToUriQuery($query);

        if (!empty($queryString)) {
            $url .= "?$queryString";
        }

        $headers = array('Content-type' => 'application/x-www-form-urlencoded');
        $response = $this->api->request($url, $headers);

        $body = $response->getBody()->getContents();

        $data = json_decode($body, true);

        if (!is_array($data) || empty($data)) {
            throw new \Exception('Error response searching vacancies');
        }

        return $data;
    }

    /**
     * Public vacancies on site hh.ru
     *
     * @param VacanciesForPublc $form
     *
     * @return string
     *
     * @throws
     */
    public function publicToSite(VacanciesForPublc $form)
    {
        $url = 'https://'.Api::HOST_API.self::QUERY_PUBLIC;

        $body = Utils::convertClassToJson($form);

        $headers = array('Content-type' => 'application/json');
        $response = $this->api->requestPost($url, $body, $headers);

        $body = $response->getBody()->getContents();

        $data = json_decode($body, true);

        if (empty($data['id'])) {
            throw new \Exception('Error request.');
        }

        return $data['id'];
    }
}