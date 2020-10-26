<?php
ini_set ('set_time_limit', 0);
ini_set ('memory_limit', '-1');
mb_internal_encoding("UTF-8");

require __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__, '.env');

$env = $dotenv->load();

$creditials = new \HHruApi\OAuthCredentials();

$creditials->clientId = (!empty($env['HHRU_CLIENT_ID'])) ? $env['HHRU_CLIENT_ID'] : null;
$creditials->clientSecret = (!empty($env['HHRU_CLIENT_SECRET'])) ? $env['HHRU_CLIENT_SECRET'] : null;
$creditials->authCode = (!empty($env['HHRU_AUTH_CODE'])) ? $env['HHRU_AUTH_CODE'] : null;
$creditials->accessToken = (!empty($env['HHRU_ACCESS_TOKEN'])) ? $env['HHRU_ACCESS_TOKEN'] : null;
$creditials->refreshToken = (!empty($env['HHRU_REFRESH_TOKEN'])) ? $env['HHRU_REFRESH_TOKEN'] : null;
$creditials->expairesIn = (!empty($env['HHRU_EXPAIR_IN'])) ? $env['HHRU_EXPAIR_IN'] : null;
$creditials->redirectUri = (!empty($env['HHRU_REDIRECT_URI'])) ? $env['HHRU_REDIRECT_URI'] : null;

$options = array(
    'debug' => true,
    'headers' => array(
        'User-Agent' => $env['HHRU_USER_AGENT'],
        'Connection' => 'close',
    )
);

$client = new \GuzzleHttp\Client($options);

return new \HHruApi\Api($creditials, $client);