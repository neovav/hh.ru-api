<?php

use HHruApi\NegotiationsQueryInterview;

$api = require_once __DIR__ . '/api.php';

try {
    if (!($api instanceof \HHruApi\Api)) {
        throw new Exception('Return not class: \HHruApi\Api');
    }

    $queryNegotiations = new \HHruApi\NegotiationsQueryForList();

    $negotiations = $api->getNegotiations();

    $listResponses = $negotiations->getList($queryNegotiations);

    if (empty($listResponses['items'])
        || empty($listResponses['items'][0])
        || empty($listResponses['items'][0]['id'])) {
        throw new \Exception('Response id is absent');
    }

    $responseId = (int) $listResponses['items'][0]['id'];

    $queryInvite = new NegotiationsQueryInterview();
    $queryInvite->message = $negotiations->getTemplateInviteMessageAfterResponse($responseId);

    echo "\r\n", 'Invite text for response id: ', $responseId, "\r\n", $queryInvite->message, "\r\n";

    $responseData = $negotiations->sendInviteOnInterview($responseId, $queryInvite);

    echo "\r\n", 'Response data: ', "\r\n";
    var_dump(reset($responseData));
    echo "\r\n";
} catch (\Exception $e) {
    echo "\r\n", 'Error (code: ' . $e->getCode() . ' line: ', $e->getLine() . ' file: "', $e->getFile() . '"): ';
    echo "\r\n", $e->getMessage(), "\r\n";
}