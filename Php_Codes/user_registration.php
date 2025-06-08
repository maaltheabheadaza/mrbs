<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once __DIR__ . '/../auth_api.php';
require __DIR__ . '/../vendor/autoload.php';
use Cloudinary\Cloudinary;
use Dotenv\Dotenv;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Load environment variables
$dotenv = Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

// Configure Cloudinary directly
$cloudinary = new Cloudinary([
    'cloud' => [
        'cloud_name' => $_ENV['CLOUDINARY_CLOUD_NAME'],
        'api_key' => $_ENV['CLOUDINARY_API_KEY'],
        'api_secret' => $_ENV['CLOUDINARY_API_SECRET']
    ]
]);

session_start();
$auth_api = new UserAuthAPI('ak_9b668ca54c3669ef57fe218fa4f51773');

// If OTP is being submitted
if (isset($_POST['otp']) && isset($_POST['email'])) {
    $email = $_POST['email'];
    $otp = $_POST['otp'];
    $fullname = $_POST['fullname'];
    $contactNumber = $_POST['contact_number'];
    $address = $_POST['full_address'];
    $password = $_POST['valid_password'];
    $imageUrl = isset($_POST['profile_image_url']) ? $_POST['profile_image_url'] : null;

    $verifyResponse = $auth_api->verifyEmail($email, $otp);
    if ($verifyResponse['status'] === 200 && isset($verifyResponse['data']['success']) && $verifyResponse['data']['success']) {
        // OTP verified, insert user into local DB
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $conn = new mysqli('localhost', 'root', '', 'user_info');
        if ($conn->connect_error) {
            die(json_encode(['success' => false, 'message' => 'Connection Failed: ' . $conn->connect_error, 'redirect' => '../Html_Codes/Userlogin.html']));
        }
        $stmt = $conn->prepare("INSERT INTO users (fullname, email, contact_number, full_address, valid_password, profile_image) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssisss", $fullname, $email, $contactNumber, $address, $hashedPassword, $imageUrl);
        $stmt->execute();
        $stmt->close();
        $conn->close();
        header('Content-Type: application/json');
        echo json_encode(['success' => true, 'message' => 'Registration and OTP verification successful!', 'redirect' => '../Html_Codes/Userlogin.html']);
        exit;
    } else {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'OTP verification failed!', 'error' => $verifyResponse['data']['message'] ?? 'Unknown error', 'redirect' => '../Html_Codes/Userlogin.html']);
        exit;
    }
}

// Initial registration request
$fullname = $_POST['fullname'];
$email = $_POST['email'];
$contactNumber = $_POST['contact_number'];
$address = $_POST['full_address'];
$password = $_POST['valid_password'];
$confirmPassword = $_POST['confirm_password'];

// Check if passwords match
if ($password !== $confirmPassword) {
    header('Content-Type: application/json');
    echo json_encode([
        'success' => false,
        'message' => 'Passwords do not match!',
        'error' => 'password_mismatch',
        'redirect' => '../Html_Codes/Userlogin.html'
    ]);
    exit;
}

$conn = new mysqli('localhost', 'root', '', 'user_info');
if ($conn->connect_error) {
    die(json_encode(['success' => false, 'message' => 'Connection Failed: ' . $conn->connect_error, 'redirect' => '../Html_Codes/Userlogin.html']));
}
// Check if email already exists
$checkEmail = $conn->prepare("SELECT email FROM users WHERE email = ?");
$checkEmail->bind_param("s", $email);
$checkEmail->execute();
$result = $checkEmail->get_result();
if ($result->num_rows > 0) {
    header('Content-Type: application/json');
    echo json_encode([
        'success' => false,
        'message' => 'Email already exists!',
        'error' => 'email_exists',
        'redirect' => '../Html_Codes/Userlogin.html'
    ]);
    $checkEmail->close();
    $conn->close();
    exit;
}
$checkEmail->close();

// Handle image upload
$imageUrl = null;
if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === UPLOAD_ERR_OK) {
    $uploadResult = $cloudinary->uploadApi()->upload($_FILES['profile_image']['tmp_name'], [
        'folder' => 'user_profiles'
    ]);
    $imageUrl = $uploadResult['secure_url'];
}

// Call external API to register user and get OTP
$registerResponse = $auth_api->register($email, $password, $fullname);
error_log('External API register response: ' . print_r($registerResponse, true));
$otp = null;
if ($registerResponse['status'] === 200 && isset($registerResponse['data']['success']) && $registerResponse['data']['success']) {
    // Try to get OTP from response
    if (isset($registerResponse['data']['otp'])) {
        $otp = $registerResponse['data']['otp'];
    } elseif (isset($registerResponse['data']['data']['otp'])) {
        $otp = $registerResponse['data']['data']['otp'];
    }
    // Send OTP email using PHPMailer
    $mail = new PHPMailer(true);
    $emailSent = false;
    $mailError = '';
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'almackieandrew.bangalao@gmail.com';
        $mail->Password = 'tcfg yhrq etjs ywts';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;
        $mail->setFrom('almackieandrew.bangalao@gmail.com', 'Municipality Resource Booking System');
        $mail->addAddress($email, $fullname);
        $mail->isHTML(true);
        $mail->Subject = 'Your OTP Code for Registration';
        $mail->Body = "<div style='font-family: Arial, sans-serif; color: #222;'><h2 style='color: #009688;'>Municipality Resource Booking System</h2><p>Dear $fullname,</p><p>Thank you for registering with us!</p><p>Your One-Time Password (OTP) for registration is:</p><div style='font-size: 2em; font-weight: bold; color: #009688; margin: 20px 0;'>$otp</div><p>Please enter this code on the verification page to complete your registration.</p><p>If you did not request this, please ignore this email.</p><br><p style='color: #888;'>Best regards,<br>MRBS Team</p></div>";
        $mail->send();
        $emailSent = true;
    } catch (Exception $e) {
        $mailError = $e->getMessage();
        error_log('PHPMailer error: ' . $mailError);
        $emailSent = false;
    }
    header('Content-Type: application/json');
    echo json_encode([
        'success' => true,
        'message' => $emailSent ? 'Registration successful! Please check your email for the OTP.' : 'Registration successful, but failed to send OTP email. Error: ' . $mailError,
        'require_otp' => true,
        'email' => $email,
        'fullname' => $fullname,
        'contact_number' => $contactNumber,
        'full_address' => $address,
        'valid_password' => $password,
        'profile_image_url' => $imageUrl,
        'mail_error' => $mailError,
        'api_response' => $registerResponse
    ]);
    exit;
} else {
    error_log('Registration failed! API response: ' . print_r($registerResponse, true));
    header('Content-Type: application/json');
    echo json_encode([
        'success' => false,
        'message' => 'Registration failed! ' . ($registerResponse['data']['message'] ?? 'Unknown error'),
        'error' => $registerResponse['data']['message'] ?? 'Unknown error',
        'raw' => $registerResponse,
        'redirect' => '../Html_Codes/Userlogin.html'
    ]);
    exit;
}
?>