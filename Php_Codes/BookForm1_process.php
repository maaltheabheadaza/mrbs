<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/holiday_api.php';
use Google\Client;
use Google\Service\Gmail;
use Google\Service\Gmail\Message;

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "user_info";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to send email
function sendEmail($to, $subject, $message) {
    $client = new Client();
    $client->setAuthConfig(__DIR__ . '/../credentials.json');
    $client->setRedirectUri('http://localhost/mrbs/Php_Codes/oauth2callback.php');
    $client->addScope(Gmail::GMAIL_SEND);
    $client->setAccessType('offline');
    
    // Load the token
    $tokenPath = __DIR__ . '/../token.json';
    if (file_exists($tokenPath)) {
        $accessToken = json_decode(file_get_contents($tokenPath), true);
        $client->setAccessToken($accessToken);
    } else {
        error_log("Token file not found: $tokenPath");
        return false;
    }
    
    try {
        $service = new Gmail($client);
        
        $rawMessage = "To: $to\r\n";
        $rawMessage .= "Subject: =?utf-8?B?" . base64_encode($subject) . "?=\r\n";
        $rawMessage .= "MIME-Version: 1.0\r\n";
        $rawMessage .= "Content-Type: text/html; charset=utf-8\r\n";
        $rawMessage .= "Content-Transfer-Encoding: base64\r\n\r\n";
        $rawMessage .= base64_encode($message);
        
        $msg = new Message();
        $msg->setRaw(strtr(base64_encode($rawMessage), ['+' => '-', '/' => '_'])); // Correct encoding for Gmail API
        
        $service->users_messages->send('me', $msg);
        return true;
    } catch (Exception $e) {
        error_log("Error sending email: " . $e->getMessage());
        return false;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Prepare the SQL statement
    $sql = "INSERT INTO bookingform1 (fullname, email, full_address, contact_number, bookingpreference, reason, 
            event_date_start, event_date_end, event_time_start, event_time_end, others, bookingtime) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("Error preparing statement: " . $conn->error);
    }
    
    $bookingtime = date("Y-m-d H:i:s");
    
    // Bind parameters
    $stmt->bind_param("ssssssssssss", 
        $_POST['fullname'],
        $_POST['email'],
        $_POST['full_address'],
        $_POST['contact_number'],
        $_POST['bookingpreference'],
        $_POST['reason'],
        $_POST['event_date_start'],
        $_POST['event_date_end'],
        $_POST['event_time_start'],
        $_POST['event_time_end'],
        $_POST['others'],
        $bookingtime
    );
    
    // Execute the statement
    if ($stmt->execute()) {
        // Send confirmation email
        $subject = "Booking Confirmation - Community Hall";
        $message = "Dear {$_POST['fullname']},<br><br>
                   Thank you for your booking! Here are your booking details:<br><br>
                   Facility: {$_POST['bookingpreference']}<br>
                   Date: {$_POST['event_date_start']} to {$_POST['event_date_end']}<br>
                   Time: {$_POST['event_time_start']} to {$_POST['event_time_end']}<br>
                   Reason: {$_POST['reason']}<br><br>";
        
        if (isset($holidayWarning) && $holidayWarning) {
            $message .= "<strong>Important Notice:</strong><br>" . nl2br($holidayWarning) . "<br><br>";
        }
        
        $message .= "You will receive a reminder email one day before your booking.<br><br>
                   Best regards,<br>
                   Municipality Resource Booking System";
        
        sendEmail($_POST['email'], $subject, $message);
        
        // Redirect to EndPage.html after successful booking
        header('Location: ../Html_Codes/EndPage.html');
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
