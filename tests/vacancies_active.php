<?php

use App\Models\Dataan\Settings;

$api = require_once __DIR__ . '/api.php';

try {
    if (!($api instanceof \HHruApi\Api)) {
        throw new Exception('Return not class: \HHruApi\Api');
    }

    $personal = $api->getPersonal()->get();

    if (!is_array($personal) || empty($personal['employer']) || empty($personal['employer']['id'])) {
        throw new \Exception('Error get personal data. Employer id is absent');
    }

    $query = new \HHruApi\VacanciesQueryActive();

    $employerId = $personal['employer']['id'];
    $query->manager_id = $personal['employer']['manager_id'];

    $vacancies = $api->getVacancies();

    // $query->text = 'php';
    $list = $vacancies->getActive($employerId, $query);

    echo "\r\n", 'Vacancies list: ', "\r\n";
    var_dump(array_keys($list));
    echo "\r\n";
    var_dump(reset($list['items']));
    echo "\r\n";
} catch (\Exception $e) {
    echo "\r\n", 'Error (code: ' . $e->getCode() . ' line: ', $e->getLine() . ' file: "', $e->getFile() . '"): ';
    echo "\r\n", $e->getMessage(), "\r\n";
}