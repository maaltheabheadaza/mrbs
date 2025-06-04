<?php
session_start();

$host = 'localhost';
$dbname = 'user_info'; 
$username = 'root'; 
$password = ''; 

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    if ($new_password !== $confirm_password) {
        echo json_encode([
            'success' => false,
            'error' => 'password_mismatch',
            'message' => 'Passwords do not match. Please try again.'
        ]);
        exit;
    }

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    if ($stmt->rowCount() == 1) {
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("UPDATE users SET valid_password = :new_password WHERE email = :email");
        $stmt->bindParam(':new_password', $hashed_password);
        $stmt->bindParam(':email', $email);
        if ($stmt->execute()) {
            echo json_encode([
                'success' => true,
                'message' => 'Password updated successfully.'
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'error' => 'update_failed',
                'message' => 'Failed to update password. Please try again.'
            ]);
        }
    } else {
        echo json_encode([
            'success' => false,
            'error' => 'email_not_found',
            'message' => 'No account found with that email.'
        ]);
    }
    exit;
}
?>
