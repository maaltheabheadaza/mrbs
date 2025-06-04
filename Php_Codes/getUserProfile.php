<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['email'])) {
    echo json_encode(['success' => false, 'message' => 'Not logged in']);
    exit;
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "user_info";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'DB connection error']);
    exit;
}

$email = $_SESSION['email'];
$stmt = $conn->prepare("SELECT fullname, email, full_address, profile_image FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();
    echo json_encode([
        'success' => true,
        'fullname' => $user['fullname'],
        'email' => $user['email'],
        'full_address' => $user['full_address'],
        'profile_image' => $user['profile_image'] ?? null
    ]);
} else {
    echo json_encode(['success' => false, 'message' => 'User not found']);
}
$stmt->close();
$conn->close(); 