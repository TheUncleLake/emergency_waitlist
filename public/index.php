<?php
require_once('_config.php');

// Set up app

use EmergencyWaitlist\ConnectionDB;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

$app = AppFactory::create();

// Helper functions

function jsonReply(Response $response, $data) {
    $payload = json_encode($data);
    $response->getBody()->write($payload);
    return $response->withHeader('Content-Type', 'application/json; charset=utf-8');
}

// General API calls

$app->get('/', function (Request $request, Response $response, $args) {
    $view = file_get_contents("{$GLOBALS["appDir"]}/views/index.html");
    $response->getBody()->write($view);
    return $response;
});

$app->get('/api/getpatients', function (Request $request, Response $response, $args) {
    $data = ConnectionDB::queryDb(
        "SELECT patient_name, severity, staff_name, date_triage FROM patients
        LEFT JOIN staff ON patients.staff_id = staff.staff_id"
    );
    return jsonReply($response, $data);
});

$app->run();