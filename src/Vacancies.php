<?php
namespace HHruApi;

/**
 * Class for working with vacancies on portal hh.ru
 */
class Vacancies
{
    private Api $api;

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
    public function search(VacanciesQuery $query):array
    {
        $url = 'https://' . Api::HOST_API . self::QUERY_SEARCH;

        $queryString = Utils::convertClassToUriQuery($query);

        if (!empty($queryString)) {
            $url .= "?$queryString";
        }

        $headers = ['Content-type' => 'application/x-www-form-urlencoded'];
        $response = $this->api->request($url, $headers);

        $response->getBody()->rewind();
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
    public function getActive(int $employerId, VacanciesQueryActive $query = null): array
    {
        $url = 'https://' . Api::HOST_API . self::QUERY_ACTIVE . "/$employerId/vacancies/active";

        $queryString = Utils::convertClassToUriQuery($query);

        if (!empty($queryString)) {
            $url .= "?$queryString";
        }

        $headers = ['Content-type' => 'application/x-www-form-urlencoded'];
        $response = $this->api->request($url, $headers);

        $response->getBody()->rewind();
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
    public function publicToSite(VacanciesForPublc $form): string
    {
        $url = 'https://'.Api::HOST_API.self::QUERY_PUBLIC;

        $body = Utils::convertClassToJson($form);

        $headers = ['Content-type' => 'application/json'];
        $response = $this->api->requestPost($url, $body, $headers);

        $response->getBody()->rewind();
        $body = $response->getBody()->getContents();

        $data = json_decode($body, true);

        if (empty($data['id'])) {
            throw new \Exception('Error request.');
        }

        return $data['id'];
    }

    /**
     * Get list brands templates
     *
     * @param int $employerId
     *
     * @return array
     *
     * @throws
     */
    public function getListBrandsTemplates(int $employerId): array
    {
        $url = 'https://' . Api::HOST_API . "/employers/$employerId/vacancy_branded_templates";

        $response = $this->api->request($url);

        $response->getBody()->rewind();
        $body = $response->getBody()->getContents();

        $data = json_decode($body, true);

        if (!is_array($data) || empty($data)) {
            throw new \Exception('Error response list templates fo brand');
        }

        return $data;
    }
}