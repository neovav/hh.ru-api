<?php
namespace HHruApi;

use GuzzleHttp\Client;

/**
 * Class for oAuth authorization on portal hh.ru
 */
class OAuth implements OAuthInterface
{
    private static bool $isDebug = false;

    private OAuthCredentials $credentials;

    private Client $client;

    const URL_GET_TOKEN = 'https://hh.ru/oauth/token';

    private string $responseContent = '';

    private static $listFunctionsRequestToken = [];

    /**
     * Constructor of the OAuth class
     *
     * @param OAuthCredentials $credentials
     * @param Client $client
     */
    public function __construct(OAuthCredentials &$credentials, Client $client = null)
    {
        $this->credentials = &$credentials;
        $this->client = ($client instanceof Client) ? $client : new Client();
    }

    /**
     * Adding a function for processing a request to get a token
     *
     * @param callable $functionRequestToken
     */
    public static function addFunctionsRequestToken(callable $functionRequestToken)
    {
        self::$listFunctionsRequestToken[] = $functionRequestToken;
    }

    /**
     * Enable debugging
     *
     * @param bool $isDebug
     */
    public static function enableDebug(bool $isDebug = true)
    {
        self::$isDebug = $isDebug;
    }

    /**
     * Getting credentials for portals hh.ru
     *
     * @return OAuthCredentials
     */
    public function getCredentials(): OAuthCredentials
    {
        return $this->credentials;
    }

    /**
     * Getting access code
     *
     * @throws
     *
     * @return array
     */
    private function getAccessToken(): array
    {
        if (empty($this->credentials->clientId)) {
            throw new \Exception('Client id is absent');
        }

        if (empty($this->credentials->clientSecret)) {
            throw new \Exception('Client secret is absent');
        }

        if (empty($this->credentials->authCode)) {
            throw new \Exception('Auth code is absent');
        }

        $post = [
            'grant_type' => 'authorization_code',
            'client_id' => $this->credentials->clientId,
            'client_secret' => $this->credentials->clientSecret,
            'code' => $this->credentials->authCode,
        ];

        if (!empty($this->credentials->redirectUri)) {
            $post['redirect_uri'] = $this->credentials->redirectUri;
        }

        try {
            $result = $this->requestToken($post);
        } catch (\Exception $e) {
            throw new \Exception('Error request get access token (' . $e->getCode() . '): ' . $e->getMessage() .
                "\r\n" . $this->getResponseContent());
        }

        if (empty($result['access_token'])) {
            throw new \Exception('Error request get access toke. Access token is absent' .
                "\r\n" . $this->getResponseContent());
        }

        return $result;
    }

    /**
     * Update access token
     *
     * @return array
     *
     * @throws
     */
    private function updAccessToken(): array
    {
        if (empty($this->credentials->refreshToken)) {
            throw new \Exception('Refresh token is absent');
        }

        $post = [
            'grant_type' => 'refresh_token',
            'refresh_token' => $this->credentials->refreshToken
        ];

        try {
            $result = $this->requestToken($post);
        } catch (\Exception $e) {
            throw new \Exception('Error request update access token (' .
                $e->getCode() . '): ' . $e->getMessage() . "\r\n" . $this->getResponseContent());
        }

        if (empty($result['access_token'])) {
            throw new \Exception('Error request update access token. Access token is absent. Response: ' .
                "\r\n" . $this->getResponseContent());
        }

        return $result;
    }

    /**
     * @param array $post
     *
     * @return array
     *
     * @throws
     */
    public function requestToken(array $post)
    {
        $options = [
            'body' => http_build_query($post),
            'headers' => [
                'Content-type' => 'application/x-www-form-urlencoded'
            ]
        ];

        $this->responseContent = '';

        $result = $this->client->post(self::URL_GET_TOKEN, $options);

        $result->getBody()->rewind();
        $this->requestContent = $result->getBody()->getContents();

        if (empty($this->requestContent)) {
            throw new \Exception('Error getting access token');
        }

        $data = json_decode($this->requestContent, true);

        if (!is_array($data)) {
            throw new \Exception('Error decode json for access token');
        }

        if (!empty($data['access_token'])) {
            $this->credentials->accessToken = $data['access_token'];
        }

        if (!empty($data['refresh_token'])) {
            $this->credentials->refreshToken = $data['refresh_token'];
        }

        if (!empty($data['expires_in'])) {
            $this->credentials->expairesIn = time() + (int) $data['expires_in'];
        }

        if (!empty($data['error'])) {
            throw new \Exception($data['error_description']);
        }

        if (!empty(self::$listFunctionsRequestToken)) {
            foreach (self::$listFunctionsRequestToken as $func) {
                $func($data);
            }
        }

        return $data;
    }

    /**
     * Getting oAuth token for authorize on hh.ru
     *
     * @param string $refreshToken
     * @param int $expairesIn
     *
     * @return string
     *
     * @throws
     */
    public function getToken($refreshToken = null, $expairesIn = null): string
    {
        $result = null;

        if (empty($refreshToken)) {
            $refreshToken = $this->credentials->refreshToken;
        }

        if (empty($expairesIn)) {
            $expairesIn = $this->credentials->expairesIn;
        }

        if (empty($refreshToken)) {
            if (empty($this->credentials->authCode)) {
                throw new \Exception('Empty auth code');
            }

            $this->getAccessToken();
        } elseif (empty($expairesIn)
            || time() > $expairesIn
            || empty($this->credentials->accessToken)) {
            $this->updAccessToken();
        }

        return $this->credentials->accessToken;
    }

    /**
     * Get request content body
     *
     * @return string
     */
    public function getResponseContent(): string
    {
        return $this->responseContent;
    }
}