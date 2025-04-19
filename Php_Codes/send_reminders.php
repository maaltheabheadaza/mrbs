<?php
require_once __DIR__ . '/../vendor/autoload.php';
use Google\Client;
use Google\Service\Gmail;
use Google\Service\Gmail\Message;

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "user_info";

echo "Starting reminder script...<br>";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Database connection successful<br>";

// Gmail API setup
$client = new Client();
$client->setAuthConfig(__DIR__ . '/../credentials.json');
$client->setRedirectUri('http://localhost/mrbs/Php_Codes/oauth2callback.php');
$client->addScope(Gmail::GMAIL_SEND);
$client->setAccessType('offline');
$client->setPrompt('consent'); // Force to get refresh token

echo "Gmail client initialized<br>";

// Load the token if it exists
$tokenPath = __DIR__ . '/../token.json';
if (file_exists($tokenPath)) {
    echo "Token file found<br>";
    $accessToken = json_decode(file_get_contents($tokenPath), true);
    $client->setAccessToken($accessToken);
} else {
    echo "No token file found<br>";
}

// If there is no token or it's expired, get a new one
if (!$client->getAccessToken() || $client->isAccessTokenExpired()) {
    echo "Token expired or not found, redirecting to auth...<br>";
    $authUrl = $client->createAuthUrl();
    echo "Please visit this URL to authorize the application: <a href='$authUrl'>Authorize Access</a><br>";
    exit;
}

// Function to send email
function sendEmail($to, $subject, $message) {
    global $client;
    
    try {
        echo "Attempting to send email to: $to<br>";
        $service = new Gmail($client);
        
        $rawMessage = "To: $to\r\n";
        $rawMessage .= "Subject: =?utf-8?B?" . base64_encode($subject) . "?=\r\n";
        $rawMessage .= "MIME-Version: 1.0\r\n";
        $rawMessage .= "Content-Type: text/html; charset=utf-8\r\n";
        $rawMessage .= "Content-Transfer-Encoding: base64\r\n\r\n";
        $rawMessage .= base64_encode($message);
        
        $msg = new Message();
        $msg->setRaw(base64_encode($rawMessage));
        
        $result = $service->users_messages->send('me', $msg);
        echo "Email sent successfully to: $to (Message ID: {$result->getId()})<br>";
        return true;
    } catch (Exception $e) {
        echo "Error sending email: " . $e->getMessage() . "<br>";
        error_log("Error sending email: " . $e->getMessage());
        return false;
    }
}

// Check community halls bookings
echo "Checking community halls bookings...<br>";
$sql = "SELECT * FROM bookingform1 WHERE 
        DATEDIFF(event_date_start, CURDATE()) <= 1 AND 
        DATEDIFF(event_date_start, CURDATE()) >= 0";
$result = $conn->query($sql);

if ($result === FALSE) {
    echo "Error executing query: " . $conn->error . "<br>";
} else {
    if ($result->num_rows > 0) {
        echo "Found " . $result->num_rows . " upcoming community hall bookings<br>";
        while($row = $result->fetch_assoc()) {
            $subject = "Reminder: Your Community Hall Booking";
            $message = "Dear " . $row['fullname'] . ",<br><br>
                       This is a reminder that your booking for " . $row['bookingpreference'] . 
                       " is scheduled for " . $row['event_date_start'] . ".<br><br>
                       Event Details:<br>
                       - Start Time: " . $row['event_time_start'] . "<br>
                       - End Time: " . $row['event_time_end'] . "<br>
                       - Reason: " . $row['reason'] . "<br><br>
                       Best regards,<br>
                       Municipality Resource Booking System";
            
            sendEmail($row['email'], $subject, $message);
        }
    } else {
        echo "No upcoming community hall bookings found<br>";
    }
}

// Check sports facilities bookings
echo "Checking sports facilities bookings...<br>";
$sql = "SELECT * FROM bookingform2 WHERE 
        DATEDIFF(book_date_start, CURDATE()) <= 1 AND 
        DATEDIFF(book_date_start, CURDATE()) >= 0";
$result = $conn->query($sql);

if ($result === FALSE) {
    echo "Error executing query: " . $conn->error . "<br>";
} else {
    if ($result->num_rows > 0) {
        echo "Found " . $result->num_rows . " upcoming sports facility bookings<br>";
        while($row = $result->fetch_assoc()) {
            $subject = "Reminder: Your Sports Facility Booking";
            $message = "Dear " . $row['fullname'] . ",<br><br>
                       This is a reminder that your booking for " . $row['bookingpreference'] . 
                       " is scheduled for " . $row['book_date_start'] . ".<br><br>
                       Booking Details:<br>
                       - Start Time: " . $row['book_time_start'] . "<br>
                       - End Time: " . $row['book_time_end'] . "<br>
                       - Reason: " . $row['reason'] . "<br><br>
                       Best regards,<br>
                       Municipality Resource Booking System";
            
            sendEmail($row['email'], $subject, $message);
        }
    } else {
        echo "No upcoming sports facility bookings found<br>";
    }
}

// Check public transportation bookings
echo "Checking public transportation bookings...<br>";
$sql = "SELECT * FROM bookingform3 WHERE 
        DATEDIFF(pick_up_date, CURDATE()) <= 1 AND 
        DATEDIFF(pick_up_date, CURDATE()) >= 0";
$result = $conn->query($sql);

if ($result === FALSE) {
    echo "Error executing query: " . $conn->error . "<br>";
} else {
    if ($result->num_rows > 0) {
        echo "Found " . $result->num_rows . " upcoming transportation bookings<br>";
        while($row = $result->fetch_assoc()) {
            $subject = "Reminder: Your Public Transportation Booking";
            $message = "Dear " . $row['fullname'] . ",<br><br>
                       This is a reminder that your transportation booking for " . $row['vehicle_type'] . 
                       " is scheduled for " . $row['pick_up_date'] . ".<br><br>
                       Booking Details:<br>
                       - Pick-up Time: " . $row['pick_up_time'] . "<br>
                       - Destination: " . $row['destination'] . "<br>
                       - Duration: " . $row['days_use'] . " days<br>
                       - Reason: " . $row['reason'] . "<br><br>
                       Best regards,<br>
                       Municipality Resource Booking System";
            
            sendEmail($row['email'], $subject, $message);
        }
    } else {
        echo "No upcoming transportation bookings found<br>";
    }
}

$conn->close();
echo "Script completed<br>";
?> 