<?php
require_once('_config.php');

// Set up app

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

function queryDb($query) {
    // Set up the database connection as you like
    $dbconn = pg_connect("user=postgres dbname=emergency_waitlist");
    if (!$dbconn) return "Failed to connect to database";
    $result = pg_query($dbconn, $query);
    if (!$result) return "Failed to query database";
    $data = pg_fetch_all($result);
    pg_close($dbconn);
    return $data;
}

// General API calls

$app->get('/', function (Request $request, Response $response, $args) {
    $view = file_get_contents("{$GLOBALS["appDir"]}/views/index.html");
    $response->getBody()->write($view);
    return $response;
});

$app->get('/api/getpatients', function (Request $request, Response $response, $args) {
    $data = queryDb("SELECT * FROM patients");
    return jsonReply($response, $data);
});

$app->run();