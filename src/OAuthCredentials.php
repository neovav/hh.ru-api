<?php
namespace HHruApi;

/**
 * Class for credentials for hh.ru oAuth
 */
class OAuthCredentials
{
    public $clientId;

    public $clientSecret;

    public $accessToken;

    /** To get $authCode go to the following link in your browser: https://hh.ru/oauth/authorize?response_type=code&client_id={client_id}&state={state}&redirect_uri={redirect_uri} */
    public $authCode;

    public $refreshToken;

    public $expairesIn;

    public $redirectUri;
}