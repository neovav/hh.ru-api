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

    const QUERY_LIST = '/negotiations/response';

    const QUERY_INTERVIEW = '/negotiations/interview/';

    const QUERY_INVITE_AFTER_RESPONSE = '/message_templates/invite_after_response';

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

        $response->getBody()->rewind();
        $body = $response->getBody()->getContents();

        $data = json_decode($body, true);

        if (!is_array($data) || empty($data)) {
            throw new \Exception('Error response searching vacancies');
        }

        return $data;
    }

    /**
     * Send invite on interview
     *
     * @param int $responseId
     * @param NegotiationsQueryInterview $query
     *
     * @return array
     *
     * @throws
     */
    public function sendInviteOnInterview(int $responseId, NegotiationsQueryInterview $query)
    {
        $url = 'https://' . Api::HOST_API . self::QUERY_INTERVIEW . $responseId;

        $queryString = Utils::convertClassToUriQuery($query);

        $headers = ['Content-type' => 'application/x-www-form-urlencoded'];
        $response = $this->api->request($url, $headers, 'PUT', $queryString);

        $response->getBody()->rewind();
        $body = $response->getBody()->getContents();

        $data = json_decode($body, true);

        if (!is_array($data) || empty($data)) {
            throw new \Exception('Error response searching vacancies');
        }

        return $data;
    }

    /**
     * Getting template message invite after response
     *
     * @param $resumeId
     * @param $vacancyId
     *
     * @return string
     *
     * @throws
     */
    public function getTemplateInviteMessageAfterResponse($resumeId, $vacancyId): string
    {
        $url = 'https://' . Api::HOST_API . self::QUERY_INVITE_AFTER_RESPONSE . "?resume_id=$resumeId&vacancy_id=$vacancyId";

        $response = $this->api->request($url);

        $response->getBody()->rewind();
        $body = $response->getBody()->getContents();

        $data = json_decode($body, true);

        if (!is_array($data) || empty($data['mail']) || empty($data['mail']['text'])) {
            throw new \Exception('Error getting template invite message after response');
        }

        return $data['mail']['text'];
    }
}