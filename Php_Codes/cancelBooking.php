<?php
session_start();
require_once 'db_connect.php';

// Check if user is logged in
if (!isset($_SESSION['email'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit();
}

// Check if booking_id and booking_type are provided
if (!isset($_POST['booking_id']) || !isset($_POST['booking_type'])) {
    echo json_encode(['success' => false, 'message' => 'Booking ID or type not provided']);
    exit();
}

$booking_id = $_POST['booking_id'];
$booking_type = $_POST['booking_type'];
$user_email = $_SESSION['email'];

// Determine which table to use based on booking type
switch ($booking_type) {
    case 'hall':
        $table = 'bookingform1';
        $date_field = 'event_date_start';
        break;
    case 'sports':
        $table = 'bookingform2';
        $date_field = 'book_date_start';
        break;
    case 'transport':
        $table = 'bookingform3';
        $date_field = 'pick_up_date';
        break;
    default:
        echo json_encode(['success' => false, 'message' => 'Invalid booking type']);
        exit();
}

// First verify that the booking belongs to the user
$verify_query = "SELECT * FROM $table WHERE id = ? AND email = ?";
$verify_stmt = $conn->prepare($verify_query);
$verify_stmt->bind_param("is", $booking_id, $user_email);
$verify_stmt->execute();
$verify_result = $verify_stmt->get_result();

if ($verify_result->num_rows === 0) {
    echo json_encode(['success' => false, 'message' => 'Booking not found or unauthorized']);
    exit();
}

$booking = $verify_result->fetch_assoc();

// Check if booking is in the future
if (strtotime($booking[$date_field]) < strtotime('today')) {
    echo json_encode(['success' => false, 'message' => 'Cannot cancel past bookings']);
    exit();
}

// Delete the booking
$delete_query = "DELETE FROM $table WHERE id = ? AND email = ?";
$delete_stmt = $conn->prepare($delete_query);
$delete_stmt->bind_param("is", $booking_id, $user_email);

if ($delete_stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Booking cancelled successfully']);
} else {
    echo json_encode(['success' => false, 'message' => 'Error cancelling booking']);
}

$delete_stmt->close();
$conn->close();
?> 