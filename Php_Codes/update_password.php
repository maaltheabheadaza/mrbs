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
    error_log('SESSION ID (update_password.php): ' . session_id());
    $email = trim($_POST['email']);
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];
    $otp_or_token = $_POST['otp']; // Get OTP or token from the form
    // Determine if it's a 6-digit OTP or a reset token
    $isToken = (strlen($otp_or_token) >= 13);
    error_log('[update_password] Received ' . ($isToken ? 'reset token' : 'OTP') . ': ' . $otp_or_token);

    if ($new_password !== $confirm_password) {
        echo json_encode([
            'success' => false,
            'error' => 'password_mismatch',
            'message' => 'Passwords do not match. Please try again.'
        ]);
        exit;
    }

    // Update local DB
    $hashedPassword = password_hash($new_password, PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("UPDATE users SET valid_password = ? WHERE email = ?");
    $stmt->execute([$hashedPassword, $email]);

    // Update password in external API
    global $auth_api;
    // Pass OTP as Bearer token and in body to external API
    $apiResponse = $auth_api->resetPassword($otp_or_token, $new_password);
    error_log('[update_password] Called resetPassword with ' . ($isToken ? 'reset token' : 'OTP') . ' (Bearer and body): ' . $otp_or_token . ' and new_password: ' . $new_password);
    if ($apiResponse['status'] !== 200 || !(isset($apiResponse['data']['success']) && $apiResponse['data']['success'])) {
        echo json_encode([
            'success' => false,
            'error' => 'external_api_failed',
            'message' => 'Password updated locally, but failed to update in external system: ' . (isset($apiResponse['data']['message']) ? $apiResponse['data']['message'] : 'Unknown error')
        ]);
        exit;
    }

    // Unset the reset token after successful password reset
    unset($_SESSION['reset_token']);

    echo json_encode([
        'success' => true,
        'message' => 'Password updated successfully in both systems! You can now log in.'
    ]);
    exit;
}
?>
