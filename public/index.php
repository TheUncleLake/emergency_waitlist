<?php
require_once('_config.php');

session_start();

use EmergencyWaitlist\{ConnectionDB, User};

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

// General API calls

$app->get('/', function (Request $request, Response $response, $args) {
    if (User::isPatient())
        $view = file_get_contents("{$GLOBALS["appDir"]}/views/patient.html");
    elseif (User::isAdmin())
        $view = file_get_contents("{$GLOBALS["appDir"]}/views/admin.html");
    elseif (isset($_SESSION["invalid"])) {
        unset($_SESSION["invalid"]);
        $view = file_get_contents("{$GLOBALS["appDir"]}/views/logininvalid.html");
    }
    else $view = file_get_contents("{$GLOBALS["appDir"]}/views/login.html");
    $response->getBody()->write($view);
    return $response;
});

$app->post('/', function (Request $request, Response $response, $args) {
    $post = $request->getParsedBody();
    // Logout
    if (isset($post['logout'])) {
        $_SESSION = array();
        goto finish_login;
    }
    if (isset($post['uname']) && strlen($post['uname']) <= 20 && preg_match('/^[A-Za-z ]+$/', $post['uname'])) {
        // Patient login
        if (isset($post["patientlogin"])) {
            $data = ConnectionDB::queryDb("SELECT 1 FROM patients WHERE patient_name = '{$post["uname"]}'");
            if (is_string($data)) {
                $response->getBody()->write($data);
                return $response->withStatus(500); // Internal Server Error
            }
            elseif (empty($data)) goto invalid_login;
            $_SESSION['uname'] = $post['uname'];
            goto finish_login;
        // Admin login
        } elseif (isset($post["adminlogin"])) {
            if ($post['uname'] != User::$adminUsername || !isset($post['pass']) || $post['pass'] != User::$adminPassword)
                goto invalid_login;
            $_SESSION['uname'] = $post['uname'];
            $_SESSION['pass'] = $post['pass'];
            goto finish_login;
        }
    }
    invalid_login:
    $_SESSION["invalid"] = true;
    finish_login:
    return $response->withHeader('Location', '/')->withStatus(302); // Redirect
});

$app->get('/api/getpatients', function (Request $request, Response $response, $args) {
    if (!User::isAdmin())
        return $response->withStatus(401); // Unauthorized
    $data = ConnectionDB::queryDb(
        "SELECT patient_name, severity, staff_name, date_triage FROM patients
        LEFT JOIN staff ON patients.staff_id = staff.staff_id"
    );
    return jsonReply($response, $data);
});

$app->get('/api/getinfo', function (Request $request, Response $response, $args) {
    if (!User::isPatient())
        return $response->withStatus(401); // Unauthorized
    $data = ConnectionDB::queryDb(
        "SELECT patient_name, severity, date_triage FROM patients
        WHERE patient_name = '{$_SESSION["uname"]}'"
    );
    return jsonReply($response, $data);
});

$app->run();