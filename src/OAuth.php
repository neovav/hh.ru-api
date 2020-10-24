<?php
namespace HHruApi;

use GuzzleHttp\Client;

/**
 * Class for oAuth authorization on portal hh.ru
 */
class OAuth implements OAuthInterface
{
    private static $isDebug = false;

    private $clientId;

    private $clientSecret;

    private $accessToken;

    private $authCode;

    private $refreshToken;

    private $expairesIn;

    private $client;

    private $redirectUri;

    const URL_GET_TOKEN = 'https://hh.ru/oauth/token';

    /**
     * Constructor of the OAuth class
     *
     * To get $authCode go to the following link in your browser: https://hh.ru/oauth/authorize?response_type=code&client_id={client_id}&state={state}&redirect_uri={redirect_uri}
     *
     * @param string $clientId
     * @param string $clientSecret
     * @param string $authCode
     * @param string $redirectUri
     */
    public function __construct($clientId, $clientSecret, $authCode = null, $redirectUri = null)
    {
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
        $this->authCode = $authCode;
        $this->redirectUri = $redirectUri;
        $this->client = new Client();
    }

    /**
     * Enable debugging
     *
     * @param bool $isDebug
     */
    public static function enableDebug($isDebug = true)
    {
        self::$isDebug = $isDebug;
    }

    /**
     * Getting refresh code
     *
     * @return string
     */
    public function getRefreshToken()
    {
        return $this->refreshToken;
    }

    /**
     * Getting expaires in
     *
     * @return int
     */
    public function getExpairesIn()
    {
        return $this->expairesIn;
    }

    /**
     * Getting access code
     *
     * @throws
     *
     * @return array
     */
    private function getAccessToken()
    {
        $post = array(
            'grant_type' => 'authorization_code',
            'client_id' => $this->clientId,
            'client_secret' => $this->clientSecret,
            'code' => $this->authCode,
        );

        if (!empty($this->redirectUri)) {
            $post['redirect_uri'] = $this->redirectUri;
        }

        return $this->requestToken($post);
    }

    /**
     * Update access token
     *
     * @return array
     *
     * @throws
     */
    private function updAccessToken()
    {
        $post = array(
            'grant_type' => 'refresh_token',
            'refresh_token' => $this->refreshToken
        );

        return $this->requestToken($post);
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
        $options = array(
            'form_params' => http_build_query($post),
            'debug' => self::$isDebug
        );

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
            $this->accessToken = $data['access_token'];
        }

        if (!empty($data['refresh_token'])) {
            $this->refreshToken = $data['refresh_token'];
        }

        if (!empty($data['expires_in'])) {
            $this->expairesIn = time() + (int) $data['expires_in'];
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
     * @return array
     *
     * @throws
     */
    public function getToken($refreshToken = null, $expairesIn = null)
    {
        $result = null;

        if (empty($refreshToken)) {
            if (empty($this->authCode)) {
                throw new \Exception('Empty auth code');
            }

            $this->getAccessToken();
        } else {
            if (empty($expairesIn) && empty($this->expairesIn)
                || empty($this->accessToken)
                || (!empty($expairesIn) && time() > $expairesIn)
                || (!empty($this->expairesIn) && time() > $this->expairesIn)) {
                $this->updAccessToken();
            }
        }

        return $this->accessToken;
    }
}