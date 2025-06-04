<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Google\Client;
use Google\Service\Gmail;
use Google\Service\Gmail\Message;

session_start();
if (!isset($_SESSION['admin'])) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit();
}
header('Content-Type: application/json');
if (!isset($_POST['booking_id'], $_POST['booking_type'], $_POST['new_status'])) {
    echo json_encode(['success' => false, 'message' => 'Missing parameters']);
    exit();
}
$booking_id = $_POST['booking_id'];
$booking_type = $_POST['booking_type'];
$new_status = $_POST['new_status'];
$allowed_types = ['hall' => 'bookingform1', 'sports' => 'bookingform2', 'transport' => 'bookingform3'];
if (!isset($allowed_types[$booking_type])) {
    echo json_encode(['success' => false, 'message' => 'Invalid booking type']);
    exit();
}
$table = $allowed_types[$booking_type];
$conn = new mysqli('localhost', 'root', '', 'user_info');
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'DB connection error']);
    exit();
}
$stmt = $conn->prepare("UPDATE $table SET status = ? WHERE id = ?");
$stmt->bind_param('si', $new_status, $booking_id);
$status_updated = $stmt->execute();
$stmt->close();

// Fetch booking details and user email
$fields = '*';
$stmt = $conn->prepare("SELECT $fields FROM $table WHERE id = ?");
$stmt->bind_param("i", $booking_id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows !== 1) {
    $stmt->close();
    $conn->close();
    echo json_encode(['success' => false, 'message' => 'Booking not found']);
    exit();
}
$row = $result->fetch_assoc();
$stmt->close();
$conn->close();

// Prepare email
$to = $row['email'];
$fullname = $row['fullname'];
$subject = '';
$message = '';

if ($new_status === 'approved') {
    $subject = 'Booking Approved - Municipality Resource Booking System';
    if ($booking_type === 'hall') {
        $message = "Dear $fullname,<br><br>Your booking for <b>{$row['bookingpreference']}</b> has been <b>approved</b>.<br><br>" .
            "<b>Facility:</b> {$row['bookingpreference']}<br>" .
            "<b>Date:</b> {$row['event_date_start']} to {$row['event_date_end']}<br>" .
            "<b>Time:</b> {$row['event_time_start']} to {$row['event_time_end']}<br>" .
            "<b>Reason:</b> {$row['reason']}<br><br>" .
            "We look forward to serving you.<br><br>Best regards,<br>Municipality Resource Booking System";
    } elseif ($booking_type === 'sports') {
        $message = "Dear $fullname,<br><br>Your booking for <b>{$row['bookingpreference']}</b> has been <b>approved</b>.<br><br>" .
            "<b>Facility:</b> {$row['bookingpreference']}<br>" .
            "<b>Date:</b> {$row['book_date_start']} to {$row['book_date_end']}<br>" .
            "<b>Time:</b> {$row['book_time_start']} to {$row['book_time_end']}<br>" .
            "<b>Reason:</b> {$row['reason']}<br>" .
            "<b>Equipment:</b> {$row['sport_equipment']}<br><br>" .
            "We look forward to serving you.<br><br>Best regards,<br>Municipality Resource Booking System";
    } elseif ($booking_type === 'transport') {
        $message = "Dear $fullname,<br><br>Your booking for <b>{$row['vehicle_type']}</b> has been <b>approved</b>.<br><br>" .
            "<b>Vehicle Type:</b> {$row['vehicle_type']}<br>" .
            "<b>Pick-up Date:</b> {$row['pick_up_date']}<br>" .
            "<b>Pick-up Time:</b> {$row['pick_up_time']}<br>" .
            "<b>Destination:</b> {$row['destination']}<br>" .
            "<b>Duration:</b> {$row['days_use']} days<br>" .
            "<b>Reason:</b> {$row['reason']}<br><br>" .
            "We look forward to serving you.<br><br>Best regards,<br>Municipality Resource Booking System";
    }
} elseif ($new_status === 'declined') {
    $subject = 'Booking Declined - Municipality Resource Booking System';
    if ($booking_type === 'hall') {
        $message = "Dear $fullname,<br><br>We regret to inform you that your booking for <b>{$row['bookingpreference']}</b> has been <b>declined</b>.<br><br>" .
            "<b>Facility:</b> {$row['bookingpreference']}<br>" .
            "<b>Date:</b> {$row['event_date_start']} to {$row['event_date_end']}<br>" .
            "<b>Time:</b> {$row['event_time_start']} to {$row['event_time_end']}<br>" .
            "<b>Reason:</b> {$row['reason']}<br><br>" .
            "This may be due to a schedule conflict, holiday, or other reasons.<br>For further assistance, please contact us.<br><br>Best regards,<br>Municipality Resource Booking System";
    } elseif ($booking_type === 'sports') {
        $message = "Dear $fullname,<br><br>We regret to inform you that your booking for <b>{$row['bookingpreference']}</b> has been <b>declined</b>.<br><br>" .
            "<b>Facility:</b> {$row['bookingpreference']}<br>" .
            "<b>Date:</b> {$row['book_date_start']} to {$row['book_date_end']}<br>" .
            "<b>Time:</b> {$row['book_time_start']} to {$row['book_time_end']}<br>" .
            "<b>Reason:</b> {$row['reason']}<br>" .
            "<b>Equipment:</b> {$row['sport_equipment']}<br><br>" .
            "This may be due to a schedule conflict, holiday, or other reasons.<br>For further assistance, please contact us.<br><br>Best regards,<br>Municipality Resource Booking System";
    } elseif ($booking_type === 'transport') {
        $message = "Dear $fullname,<br><br>We regret to inform you that your booking for <b>{$row['vehicle_type']}</b> has been <b>declined</b>.<br><br>" .
            "<b>Vehicle Type:</b> {$row['vehicle_type']}<br>" .
            "<b>Pick-up Date:</b> {$row['pick_up_date']}<br>" .
            "<b>Pick-up Time:</b> {$row['pick_up_time']}<br>" .
            "<b>Destination:</b> {$row['destination']}<br>" .
            "<b>Duration:</b> {$row['days_use']} days<br>" .
            "<b>Reason:</b> {$row['reason']}<br><br>" .
            "This may be due to a schedule conflict, holiday, or other reasons.<br>For further assistance, please contact us.<br><br>Best regards,<br>Municipality Resource Booking System";
    }
}

// Send email using Gmail API
function sendEmail($to, $subject, $message, &$errorMsg = null) {
    $client = new Client();
    $client->setAuthConfig(__DIR__ . '/../credentials.json');
    $client->setRedirectUri('http://localhost/mrbs/Php_Codes/oauth2callback.php');
    $client->addScope(Gmail::GMAIL_SEND);
    $client->setAccessType('offline');
    $tokenPath = __DIR__ . '/../token.json';
    if (file_exists($tokenPath)) {
        $accessToken = json_decode(file_get_contents($tokenPath), true);
        $client->setAccessToken($accessToken);
    } else {
        $errorMsg = 'Token file not found.';
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
        $msg->setRaw(strtr(base64_encode($rawMessage), ['+' => '-', '/' => '_']));
        $service->users_messages->send('me', $msg);
        return true;
    } catch (Exception $e) {
        $errorMsg = $e->getMessage();
        error_log("Error sending email: " . $e->getMessage());
        return false;
    }
}

$emailError = null;
$emailSent = sendEmail($to, $subject, $message, $emailError);

$response = ['success' => $status_updated, 'message' => 'Status updated'];
if ($emailSent) {
    $response['email'] = 'sent';
} else {
    $response['email'] = 'failed';
    $response['email_error'] = $emailError;
}
echo json_encode($response); 