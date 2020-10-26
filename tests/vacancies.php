<?php
$api = require_once __DIR__ . '/api.php';

try {
    if (!($api instanceof \HHruApi\Api)) {
        throw new Exception('Return not class: \HHruApi\Api');
    }

    $vacancies = $api->getVacancies();

    $query = new \HHruApi\VacanciesQuery();
    $query->text = 'php';
    $list = $vacancies->search($query);

    echo "\r\n", 'Vacancies list: ', "\r\n";
    var_dump(array_keys($list));
    echo "\r\n";
    var_dump(reset($list['items']));
    echo "\r\n";
} catch (\Exception $e) {
    echo "\r\n", 'Error (code: ' . $e->getCode() . ' line: ', $e->getLine() . ' file: "', $e->getFile() . '"): ';
    echo "\r\n", $e->getMessage(), "\r\n";
}