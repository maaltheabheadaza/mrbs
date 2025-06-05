<?php
require_once __DIR__ . '/../auth_api.php';
require_once __DIR__ . '/../vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    if (!$email) {
        echo json_encode([
            'success' => false,
            'message' => 'Email is required.'
        ]);
        exit;
    }
    $auth_api = new UserAuthAPI('ak_9b668ca54c3669ef57fe218fa4f51773');
    $otpResponse = $auth_api->requestOTP($email, 'password-reset');
    if ($otpResponse['status'] === 200 && isset($otpResponse['data']['success']) && $otpResponse['data']['success']) {
        // Try to get OTP from response
        $otp = null;
        if (isset($otpResponse['data']['otp'])) {
            $otp = $otpResponse['data']['otp'];
        } elseif (isset($otpResponse['data']['data']['otp'])) {
            $otp = $otpResponse['data']['data']['otp'];
        }
        if ($otp) {
            // Send OTP email using PHPMailer
            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'almackieandrew.bangalao@gmail.com';
                $mail->Password = 'tcfg yhrq etjs ywts';
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;
                $mail->setFrom('almackieandrew.bangalao@gmail.com', 'Municipality Resource Booking System');
                $mail->addAddress($email);
                $mail->isHTML(true);
                $mail->Subject = 'Your OTP Code for Password Reset';
                $mail->Body = "<div style='font-family: Arial, sans-serif; color: #222;'><h2 style='color: #009688;'>Municipality Resource Booking System</h2><p>Dear User,</p><p>Your One-Time Password (OTP) for password reset is:</p><div style='font-size: 2em; font-weight: bold; color: #009688; margin: 20px 0;'>$otp</div><p>Please enter this code on the verification page to complete your password reset.</p><p>If you did not request this, please ignore this email.</p><br><p style='color: #888;'>Best regards,<br>MRBS Team</p></div>";
                $mail->send();
                $emailSent = true;
            } catch (Exception $e) {
                $emailSent = false;
            }
            echo json_encode([
                'success' => true,
                'message' => $emailSent ? 'OTP sent to your email.' : 'OTP generated, but failed to send email.'
            ]);
            exit;
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'OTP not found in API response.'
            ]);
            exit;
        }
    } else {
        echo json_encode([
            'success' => false,
            'message' => $otpResponse['data']['message'] ?? 'Failed to send OTP.'
        ]);
        exit;
    }
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid request.'
    ]);
    exit;
} 