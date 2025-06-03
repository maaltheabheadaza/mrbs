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
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $full_address = $_POST['full_address'];
    $contact_number = $_POST['contact_number'];
    $bookingpreference = $_POST['bookingpreference'];
    $reason = $_POST['reason'];
    $event_date_start = $_POST['event_date_start'];
    $event_date_end = $_POST['event_date_end'];
    $event_time_start = $_POST['event_time_start'];
    $event_time_end = $_POST['event_time_end'];
    $others = $_POST['others'];
    $bookingtime = date("Y-m-d H:i:s");

    // Check for holidays
    $holidayAPI = new HolidayAPI();
    $isStartDateHoliday = $holidayAPI->isHoliday($event_date_start);
    $isEndDateHoliday = $holidayAPI->isHoliday($event_date_end);
    
    $holidayWarning = "";
    if ($isStartDateHoliday || $isEndDateHoliday) {
        $holidayInfo = [];
        if ($isStartDateHoliday) {
            $startDateHolidayInfo = $holidayAPI->getHolidayInfo($event_date_start);
            $holidayInfo[] = "Start date ({$event_date_start}): {$startDateHolidayInfo[0]['name']}";
        }
        if ($isEndDateHoliday) {
            $endDateHolidayInfo = $holidayAPI->getHolidayInfo($event_date_end);
            $holidayInfo[] = "End date ({$event_date_end}): {$endDateHolidayInfo[0]['name']}";
        }
        $holidayWarning = "Note: The following dates are holidays:\n" . implode("\n", $holidayInfo);
    }

    $sql = "INSERT INTO bookingform1 (fullname, email, full_address, contact_number, bookingpreference, reason, event_date_start, event_date_end, event_time_start, event_time_end, others, bookingtime)
            VALUES ('$fullname', '$email', '$full_address', '$contact_number', '$bookingpreference', '$reason', '$event_date_start', '$event_date_end', '$event_time_start', '$event_time_end', '$others', '$bookingtime')";

    if ($conn->query($sql) === TRUE) {
        // Send confirmation email
        $subject = "Booking Confirmation - Community Hall";
        $message = "Dear $fullname,<br><br>
                   Thank you for your booking! Here are your booking details:<br><br>
                   Facility: $bookingpreference<br>
                   Date: $event_date_start to $event_date_end<br>
                   Time: $event_time_start to $event_time_end<br>
                   Reason: $reason<br><br>";
        
        if ($holidayWarning) {
            $message .= "<strong>Important Notice:</strong><br>" . nl2br($holidayWarning) . "<br><br>";
        }
        
        $message .= "You will receive a reminder email one day before your booking.<br><br>
                   Best regards,<br>
                   Municipality Resource Booking System";
        
        sendEmail($email, $subject, $message);
        
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>\n";
        echo "<script>\nSwal.fire({\n  icon: 'success',\n  title: 'Booking Successful!',\n  html: `<div style='text-align:left;font-size:1.1em;'>\n    <b>Thank you for your booking!</b><br><br>\n    <b>Facility:</b> $bookingpreference<br>\n    <b>Date:</b> $event_date_start to $event_date_end<br>\n    <b>Time:</b> $event_time_start to $event_time_end<br>\n    <b>Reason:</b> $reason<br>\n    <b>Email:</b> $email<br>\n    <b>Name:</b> $fullname<br>\n    <b>Address:</b> $full_address<br>\n    <b>Contact:</b> $contact_number<br>\n    <b>Others:</b> $others<br>\n    <br><span style='color:#009688;font-weight:bold;'>A confirmation email has been sent to your email address.</span>\n  </div>`,\n  confirmButtonText: 'OK',\n  confirmButtonColor: '#009688'\n}).then(() => {\n  window.location.href='../Html_Codes/EndPage.html';\n});\n<\/script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
