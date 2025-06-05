<?php
require_once __DIR__ . '/../auth_api.php';
require __DIR__ . '/../vendor/autoload.php';

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $otp = $_POST['otp'];
    $new_password = $_POST['new_password'];

    $auth_api = new UserAuthAPI('ak_9b668ca54c3669ef57fe218fa4f51773');
    $verifyResponse = $auth_api->verifyEmail($email, $otp); // Use verifyEmail for OTP verification
    if ($verifyResponse['status'] === 200 && isset($verifyResponse['data']['success']) && $verifyResponse['data']['success']) {
        // OTP verified, update password in local DB
        $hashedPassword = password_hash($new_password, PASSWORD_DEFAULT);
        $conn = new mysqli('localhost', 'root', '', 'user_info');
        if ($conn->connect_error) {
            echo json_encode(['success' => false, 'message' => 'Connection Failed: ' . $conn->connect_error]);
            exit;
        }
        $stmt = $conn->prepare("UPDATE users SET valid_password = ? WHERE email = ?");
        $stmt->bind_param("ss", $hashedPassword, $email);
        $stmt->execute();
        $stmt->close();
        $conn->close();
        echo json_encode([
            'success' => true,
            'message' => 'Password updated successfully! You can now log in.',
            'redirect' => '../Html_Codes/Userlogin.html'
        ]);
        exit;
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'OTP verification failed! ' . ($verifyResponse['data']['message'] ?? 'Unknown error')
        ]);
        exit;
    }
}
?> 