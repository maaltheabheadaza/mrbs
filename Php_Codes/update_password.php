<?php
session_start();
require_once __DIR__ . '/../auth_api.php';
header('Content-Type: application/json');

$host = 'localhost';
$dbname = 'user_info'; 
$username = 'root'; 
$password = ''; 

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Connection failed: ' . $e->getMessage()
    ]);
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];
    $otp = $_POST['otp']; // Get the OTP from the form

    if ($new_password !== $confirm_password) {
        echo json_encode([
            'success' => false,
            'error' => 'password_mismatch',
            'message' => 'Passwords do not match. Please try again.'
        ]);
        exit;
    }

    // 1. Update local DB
    $hashedPassword = password_hash($new_password, PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("UPDATE users SET valid_password = ? WHERE email = ?");
    $stmt->execute([$hashedPassword, $email]);

    // 2. Update password in external API
    $auth_api = new UserAuthAPI('ak_9b668ca54c3669ef57fe218fa4f51773');
    $apiResponse = $auth_api->resetPassword($otp, $new_password);

    if ($apiResponse['status'] === 200 && isset($apiResponse['data']['success']) && $apiResponse['data']['success']) {
        echo json_encode([
            'success' => true,
            'message' => 'Password updated successfully! You can now log in.'
        ]);
        exit;
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Password updated locally, but failed to update in external API: ' . ($apiResponse['data']['message'] ?? 'Unknown error') . ' | Raw: ' . json_encode($apiResponse)
        ]);
        exit;
    }
}
?>
