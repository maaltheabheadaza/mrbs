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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $full_address = $_POST['full_address'];
    $contact_number = $_POST['contact_number'];
    $bookingpreference = $_POST['bookingpreference'];
    $reason = $_POST['reason'];
    $book_date_start = $_POST['book_date_start'];
    $book_date_end = $_POST['book_date_end'];
    $book_time_start = $_POST['book_time_start'];
    $book_time_end = $_POST['book_time_end'];
    $sport_equipment = $_POST['sport_equipment'];
    $others = $_POST['others'];
    $bookingtime = date("Y-m-d H:i:s");

    $sql = "INSERT INTO bookingform2 (fullname, email, full_address, contact_number, bookingpreference, reason, book_date_start, book_date_end, book_time_start, book_time_end, sport_equipment, others, bookingtime)
            VALUES ('$fullname', '$email', '$full_address', '$contact_number', '$bookingpreference', '$reason', '$book_date_start', '$book_date_end', '$book_time_start', '$book_time_end', '$sport_equipment', '$others', '$bookingtime')";

    if ($conn->query($sql) === TRUE) {
        // Send confirmation email
        $subject = "Booking Confirmation - Sports Facility";
        $message = "Dear $fullname,<br><br>
                   Thank you for your booking! Here are your booking details:<br><br>
                   Facility: $bookingpreference<br>
                   Date: $book_date_start to $book_date_end<br>
                   Time: $book_time_start to $book_time_end<br>
                   Reason: $reason<br>
                   Equipment: $sport_equipment<br><br>
                   You will receive a reminder email one day before your booking.<br><br>
                   Best regards,<br>
                   Municipality Resource Booking System";
        sendEmail($email, $subject, $message);
        header('Location: ../Html_Codes/EndPage.html');
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>