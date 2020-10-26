<?php
$api = require_once __DIR__ . '/api.php';

try {
    $token = $api->getOAuth()->getToken();

    echo "\r\n";
    var_dump($creditials);
    echo "\r\n", 'Token oAuth: ', $token, "\r\n";
} catch (\Exception $e) {
    echo "\r\n", 'Error (code: ' . $e->getCode() . ' line: ', $e->getLine() . ' file: "', $e->getFile() . '"): ';
    echo "\r\n", $e->getMessage(), "\r\n";
}