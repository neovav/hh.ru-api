<?php
namespace HHruApi;

/**
 * Class for working with resumes on portal hh.ru
 */
class Resumes
{
    const QUERY_SEARCH = '/resumes';

    const QUERY_SAVED_SEARCH = '/saved_searches/resumes';

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

    /**
     * Searching resumes
     *
     * @param ResumesQuery $query
     *
     * @return array
     *
     * @throws
     */
    public function createSavedSearch(ResumesQuery $query):array
    {
        $url = 'https://' . Api::HOST_API . self::QUERY_SAVED_SEARCH;

        $body = Utils::convertClassToJson($query);

        $headers = ['Content-type' => 'application/json'];
        $response = $this->api->requestPost($url, $body, $headers);

        $location = $response->getHeader('Location');

        if (empty($location)) {
            throw new \Exception('Error request.');
        }

        return $location;
    }

    /**
     * Delete saved search resumes
     *
     * @param int $id
     *
     * @return Resumes
     *
     * @throws
     */
    public function deleteSavedSearch(int $id): Resumes
    {
        $url = 'https://' . Api::HOST_API . self::QUERY_SAVED_SEARCH . "/$id";

        $headers = [];
        $response = $this->api->request($url, $headers, 'DELETE');

        $requestCode = $response->getStatusCode();

        if ($requestCode !== 204) {
            throw new \Exception('Error request.');
        }

        return $this;
    }

    /**
     * Move saved search resumes to another manager
     *
     * @param int $id
     * @param int $managerId
     *
     * @return Resumes
     *
     * @throws
     */
    public function moveSavedSearchToManagerId(int $id, int $managerId): Resumes
    {
        $url = 'https://' . Api::HOST_API . self::QUERY_SAVED_SEARCH . "/$id/managers/$managerId";

        $headers = [];
        $response = $this->api->request($url, $headers, 'PUT');

        $requestCode = $response->getStatusCode();

        if ($requestCode !== 204) {
            throw new \Exception('Error request.');
        }

        return $this;
    }

    /**
     * Get saved searches resume
     *
     * @param int $page
     * @param int $perPage
     *
     * @return array
     *
     * @throws
     */
    public function savedSearch(int $page = 1, int $perPage = 10):array
    {
        $url = 'https://' . Api::HOST_API . self::QUERY_SAVED_SEARCH . "?page=$page&per_page=$perPage";

        $headers = ['Content-type' => 'application/x-www-form-urlencoded'];
        $response = $this->api->request($url, $headers);

        $body = $response->getBody()->getContents();

        $data = json_decode($body, true);

        if (!is_array($data) || empty($data)) {
            throw new \Exception('Error response searching vacancies');
        }

        return $data;
    }

    /**
     * Get saved searches resume by id
     *
     * @param int $id
     *
     * @return array
     *
     * @throws
     */
    public function savedSearchById(int $id):array
    {
        $url = 'https://' . Api::HOST_API . self::QUERY_SAVED_SEARCH . "/$id";

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