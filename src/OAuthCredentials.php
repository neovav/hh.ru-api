<?php
namespace HHruApi;

/**
 * Class for credentials for hh.ru oAuth
 */
class OAuthCredentials
{
    public string $clientId;

    public string $clientSecret;

    public string $accessToken;

    /** To get $authCode go to the following link in your browser: https://hh.ru/oauth/authorize?response_type=code&client_id={client_id}&state={state}&redirect_uri={redirect_uri} */
    public string $authCode;

    public string $refreshToken;

    public int $expairesIn;

    public string $redirectUri;
}