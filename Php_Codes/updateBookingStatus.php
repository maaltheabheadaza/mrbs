<?php
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
if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Status updated']);
} else {
    echo json_encode(['success' => false, 'message' => 'Update failed']);
}
$stmt->close();
$conn->close(); 