<?php
  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);
require __DIR__ . '/../vendor/autoload.php';

use Google\Client;
use Google\Service\Gmail;
use Google\Service\Gmail\Message;

// Load environment variables
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

try {
    // Create Gmail API client
    $client = new Client();
    $client->setAuthConfig(__DIR__ . '/../credentials.json');
    $client->setRedirectUri('http://localhost/mrbs/Php_Codes/oauth2callback.php');
    $client->addScope(Gmail::GMAIL_SEND);
    $client->setAccessType('offline');
    $client->setPrompt('consent');
    
    // Load token from file
    $tokenPath = __DIR__ . '/../token.json';
    if (file_exists($tokenPath)) {
        $accessToken = json_decode(file_get_contents($tokenPath), true);
        $client->setAccessToken($accessToken);
    }

    // If we don't have a token or it's expired, redirect to OAuth flow
    if (!$client->getAccessToken() || $client->isAccessTokenExpired()) {
        if ($client->getRefreshToken()) {
            try {
                $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
                file_put_contents($tokenPath, json_encode($client->getAccessToken()));
            } catch (Exception $e) {
                // If refresh token fails, we need to re-authenticate
                unlink($tokenPath); // Delete the invalid token
                $auth_url = $client->createAuthUrl();
                echo "<h1>Authentication Required</h1>";
                echo "<p>Please authorize the application to continue:</p>";
                echo "<p><a href='" . filter_var($auth_url, FILTER_SANITIZE_URL) . "' style='padding: 10px 20px; background-color: #4285f4; color: white; text-decoration: none; border-radius: 5px;'>Authorize Gmail Access</a></p>";
                exit;
            }
        } else {
            // No refresh token, need to authenticate
            $auth_url = $client->createAuthUrl();
            echo "<h1>Authentication Required</h1>";
            echo "<p>Please authorize the application to continue:</p>";
            echo "<p><a href='" . filter_var($auth_url, FILTER_SANITIZE_URL) . "' style='padding: 10px 20px; background-color: #4285f4; color: white; text-decoration: none; border-radius: 5px;'>Authorize Gmail Access</a></p>";
            exit;
        }
    }

    // Create Gmail service
    $service = new Gmail($client);

    // Create test email message
    $email = "From: Municipality Resource Booking System <{$_ENV['GMAIL_USERNAME']}>\r\n";
    $email .= "To: {$_ENV['GMAIL_USERNAME']}\r\n"; // Send to yourself for testing
    $email .= "Subject: Gmail API Test\r\n";
    $email .= "Content-Type: text/html; charset=UTF-8\r\n\r\n";
    $email .= "<h2>Gmail API Test</h2>";
    $email .= "<p>If you're receiving this email, your Gmail API setup is working correctly!</p>";
    $email .= "<p>This is a test email sent using the Gmail API.</p>";

    // Encode email in base64
    $message = new Message();
    $message->setRaw(base64_encode($email));

    // Send email
    $result = $service->users_messages->send('me', $message);
    
    echo "<h1>Test Results</h1>";
    echo "<p style='color: green;'>✅ Test email sent successfully!</p>";
    echo "<p>Message ID: " . $result->getId() . "</p>";
    echo "<p>Please check your email ({$_ENV['GMAIL_USERNAME']}) for the test message.</p>";
    echo "<p><a href='user_registration.php' style='padding: 10px 20px; background-color: #4285f4; color: white; text-decoration: none; border-radius: 5px;'>Return to Registration Page</a></p>";

} catch (Exception $e) {
    echo "<h1>Test Results</h1>";
    echo "<p style='color: red;'>❌ Error: " . $e->getMessage() . "</p>";
    echo "<p>Please check:</p>";
    echo "<ul>";
    echo "<li>Your credentials.json file is in the correct location</li>";
    echo "<li>The Gmail API is enabled in your Google Cloud Console</li>";
    echo "<li>Your OAuth consent screen is configured correctly</li>";
    echo "<li>Your Gmail account has the necessary permissions</li>";
    echo "</ul>";
    echo "<p>If the error persists, try:</p>";
    echo "<ol>";
    echo "<li>Delete the token.json file (if it exists)</li>";
    echo "<li>Clear your browser cookies for Google</li>";
    echo "<li>Try the test again</li>";
    echo "</ol>";
    echo "<p><a href='user_registration.php' style='padding: 10px 20px; background-color: #4285f4; color: white; text-decoration: none; border-radius: 5px;'>Return to Registration Page</a></p>";
}
?> 