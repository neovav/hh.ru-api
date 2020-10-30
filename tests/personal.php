<?php
$api = require_once __DIR__ . '/api.php';

try {
    if (!($api instanceof \HHruApi\Api)) {
        throw new Exception('Return not class: \HHruApi\Api');
    }

    $data = $api->getPersonal()->get();

    echo "\r\n", 'Personal data: ', "\r\n";
    var_dump($data);
    echo "\r\n";
} catch (\Exception $e) {
    echo "\r\n", 'Error (code: ' . $e->getCode() . ' line: ', $e->getLine() . ' file: "', $e->getFile() . '"): ';
    echo "\r\n", $e->getMessage(), "\r\n";
}