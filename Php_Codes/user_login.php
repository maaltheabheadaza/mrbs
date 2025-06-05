<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/../auth_api.php';

$auth_api = new UserAuthAPI('ak_9b668ca54c3669ef57fe218fa4f51773');

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $captcha = $_POST['g-recaptcha-response'];

    // Verify CAPTCHA
    $secretKey = "6LdV3zsrAAAAAOl8Or7LkwglfT-IHAABjQG7pwjJ";
    $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secretKey&response=$captcha");
    $responseKeys = json_decode($response, true);

    if (!$responseKeys["success"]) {
        echo json_encode([
            'success' => false,
            'error' => 'recaptcha_failed',
            'message' => 'CAPTCHA verification failed. Please try again.'
        ]);
        exit();
    }

    // Call external API to login
    $loginResponse = $auth_api->login($email, $password);

    if ($loginResponse['status'] === 200 && isset($loginResponse['data']['success']) && $loginResponse['data']['success']) {
        // Get user data from local database for additional information
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "user_info";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT * FROM users WHERE email=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $user = $result->fetch_assoc();
            $_SESSION['email'] = $email;
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['fullname'] = $user['fullname'];
            $_SESSION['auth_token'] = $loginResponse['data']['data']['auth_token'];
            $_SESSION['token_expires'] = $loginResponse['data']['data']['expires_at'];

            echo json_encode([
                'success' => true,
                'message' => 'Login Successful!',
                'data' => [
                    'user_id' => $user['id'],
                    'email' => $email,
                    'fullname' => $user['fullname'],
                    'auth_token' => $loginResponse['data']['data']['auth_token'],
                    'expires_at' => $loginResponse['data']['data']['expires_at']
                ],
                'redirect' => '../Php_Codes/BookingPage.php'
            ]);
            exit();
        }
        $conn->close();
    } else {
        echo json_encode([
            'success' => false,
            'error' => 'login_failed',
            'message' => 'Incorrect email or password. Please try again.'
        ]);
        exit();
    }
}
?>