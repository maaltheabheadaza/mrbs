<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "user_info";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

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

    $sql = "SELECT * FROM users WHERE email=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['valid_password'])) {
            $_SESSION['email'] = $email;
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['fullname'] = $user['fullname'];
            echo json_encode([
                'success' => true,
                'message' => 'Login Successful!',
                'redirect' => '../Php_Codes/BookingPage.php'
            ]);
            exit();
        } else {
            echo json_encode([
                'success' => false,
                'error' => 'wrong_password',
                'message' => 'Incorrect email or password. Please try again.'
            ]);
            exit();
        }
    } else {
        echo json_encode([
            'success' => false,
            'error' => 'wrong_email',
            'message' => 'Incorrect email or password. Please try again.'
        ]);
        exit();
    }
}

$conn->close();
?>