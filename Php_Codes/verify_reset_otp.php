<?php
// This script is now obsolete. Password reset uses the OTP directly in ForgetPass.php.
// No logic needed here.

    $email = $_POST['email'];
    $otp = $_POST['otp'];
    $new_password = $_POST['new_password'];

    $auth_api = new UserAuthAPI('ak_9b668ca54c3669ef57fe218fa4f51773');
    $verifyResponse = $auth_api->verifyEmail($email, $otp); // Use verifyEmail for OTP verification
    error_log('OTP Verify Response: ' . print_r($verifyResponse, true));
    // If OTP is verified, generate and return a reset token
    if (
        $verifyResponse['status'] === 200 &&
        (
            (isset($verifyResponse['data']['success']) && $verifyResponse['data']['success']) ||
            (isset($verifyResponse['data']['message']) && $verifyResponse['data']['message'] === 'Email is already verified')
        )
    ) {
        // Generate a secure random token
        $reset_token = bin2hex(random_bytes(32));
        $_SESSION['reset_token'] = $reset_token;
        error_log('SESSION ID (verify_reset_otp.php): ' . session_id());
        error_log('Generated reset_token: ' . $reset_token);
        echo json_encode([
            'success' => true,
            'reset_token' => $reset_token,
            'message' => 'OTP verified. Use this token to reset your password.'
        ]);
        exit;
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'OTP verification failed! ' . ($verifyResponse['data']['message'] ?? 'Unknown error')
        ]);
        exit;
    }

?> 