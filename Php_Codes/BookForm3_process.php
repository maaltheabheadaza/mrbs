<?php
require_once __DIR__ . '/../vendor/autoload.php';
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

$stmt = $conn->prepare("INSERT INTO bookingform3 (fullname, email, full_address, contact_number, vehicle_type, reason, pick_up_date, pick_up_time, destination, days_use, others, bookingtime) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())");
$stmt->bind_param("sssisssssss", $fullname, $email, $full_address, $contact_number, $vehicle_type, $reason, $pick_up_date, $pick_up_time, $destination, $days_use, $others);

$fullname = $_POST['fullname'];
$email = $_POST['email'];
$full_address = $_POST['full_address'];
$contact_number = $_POST['contact_number'];
$vehicle_type = $_POST['vehicle_type'];
$reason = $_POST['reason'];
$pick_up_date = $_POST['pick_up_date'];
$pick_up_time = $_POST['pick_up_time'];
$destination = $_POST['destination'];
$days_use = $_POST['days_use'];
$others = $_POST['others'];

if ($stmt->execute()) {
    // Send confirmation email
    $subject = "Booking Confirmation - Transportation";
    $message = "Dear $fullname,<br><br>
               Thank you for your booking! Here are your booking details:<br><br>
               Vehicle Type: $vehicle_type<br>
               Pick-up Date: $pick_up_date<br>
               Pick-up Time: $pick_up_time<br>
               Destination: $destination<br>
               Duration: $days_use days<br>
               Reason: $reason<br><br>
               You will receive a reminder email one day before your pick-up date.<br><br>
               Best regards,<br>
               Municipality Resource Booking System";
    
    sendEmail($email, $subject, $message);
    
    echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>\n";
    echo "<script>\nSwal.fire({\n  icon: 'success',\n  title: 'Booking Successful!',\n  html: `<div style='text-align:left;font-size:1.1em;'>\n    <b>Thank you for your booking!</b><br><br>\n    <b>Vehicle Type:</b> $vehicle_type<br>\n    <b>Pick-up Date:</b> $pick_up_date<br>\n    <b>Pick-up Time:</b> $pick_up_time<br>\n    <b>Destination:</b> $destination<br>\n    <b>Duration:</b> $days_use days<br>\n    <b>Reason:</b> $reason<br>\n    <b>Email:</b> $email<br>\n    <b>Name:</b> $fullname<br>\n    <b>Address:</b> $full_address<br>\n    <b>Contact:</b> $contact_number<br>\n    <b>Others:</b> $others<br>\n    <br><span style='color:#009688;font-weight:bold;'>A confirmation email has been sent to your email address.</span>\n  </div>`,\n  confirmButtonText: 'OK',\n  confirmButtonColor: '#009688'\n}).then(() => {\n  window.location.href='../Html_Codes/EndPage.html';\n});\n<\/script>";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>