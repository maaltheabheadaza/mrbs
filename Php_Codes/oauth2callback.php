<?php
require __DIR__ . '/../vendor/autoload.php';

use Google\Client;
use Google\Service\Gmail;

// Create client object
$client = new Client();
$client->setAuthConfig(__DIR__ . '/../credentials.json');
$client->setRedirectUri('http://localhost/mrbs/Php_Codes/oauth2callback.php');
$client->addScope(Gmail::GMAIL_SEND);
$client->setAccessType('offline'); // This ensures we get a refresh token
$client->setPrompt('consent'); // This forces the consent screen to appear

// Exchange authorization code for access token
if (isset($_GET['code'])) {
    try {
        $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
        
        if (!isset($token['error'])) {
            // Store the token
            file_put_contents(__DIR__ . '/../token.json', json_encode($token));
            echo "<h1>Authentication Successful!</h1>";
            echo "<p>You can now close this window and return to the registration page.</p>";
            echo "<script>setTimeout(function() { window.close(); }, 3000);</script>";
        } else {
            echo "<h1>Authentication Error</h1>";
            echo "<p>Error: " . $token['error_description'] . "</p>";
        }
    } catch (Exception $e) {
        echo "<h1>Authentication Error</h1>";
        echo "<p>Error: " . $e->getMessage() . "</p>";
    }
} else {
    // If no code is present, redirect to Google's OAuth 2.0 server
    $auth_url = $client->createAuthUrl();
    header('Location: ' . filter_var($auth_url, FILTER_SANITIZE_URL));
    exit;
}
?> 