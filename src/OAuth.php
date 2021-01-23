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
            throw new \Exception('Error request get access token (' . $e->getCode() . '): ' . $e->getMessage());
        }

        if (empty($data['access_token'])) {
            throw new \Exception('Error request get access toke. Access token is absent');
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
            throw new \Exception('Error request update access token (' . $e->getCode() . '): ' . $e->getMessage());
        }

        if (empty($result['access_token'])) {
            throw new \Exception('Error request update access token. Access token is absent');
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

        $result = $this->client->post(self::URL_GET_TOKEN, $options);

        $content = $result->getBody()->getContents();

        if (empty($content)) {
            throw new \Exception('Error getting access token');
        }

        $data = json_decode($content, true);

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
        } else {
            if (empty($expairesIn)
                || time() > $expairesIn
                || empty($this->credentials->accessToken)
            ) {
                $this->updAccessToken();
            }
        }

        return $this->credentials->accessToken;
    }
}