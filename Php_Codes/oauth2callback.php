<?php
require_once __DIR__ . '/../vendor/autoload.php';

session_start();

$client = new Google\Client();
$client->setAuthConfig(__DIR__ . '/../credentials.json');
$client->setRedirectUri('http://localhost/mrbs/Php_Codes/oauth2callback.php');
$client->addScope(Google\Service\Gmail::GMAIL_SEND);
$client->setAccessType('offline');
$client->setPrompt('consent'); // Force to get refresh token

if (isset($_GET['code'])) {
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    if(!isset($token['error'])) {
        // Store the token
        file_put_contents(__DIR__ . '/../token.json', json_encode($token));
        echo "Authentication successful! You can close this window and run the test again.";
    } else {
        echo "Error: " . $token['error_description'];
    }
    exit;
} else {
    $auth_url = $client->createAuthUrl();
    header('Location: ' . filter_var($auth_url, FILTER_SANITIZE_URL));
}
?> 