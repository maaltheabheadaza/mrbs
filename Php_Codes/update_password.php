<?php
session_start();

$host = 'localhost';
$dbname = 'user_information'; 
$username = 'root'; 
$password = ''; 

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    if ($new_password !== $confirm_password) {
        echo "<script>alert('Passwords do not match. Please try again.'); window.location.href='../Php_Codes/ForgetPass.php';</script>";
        exit;
    }

    echo "Email: $email <br>";

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    echo "Row count: " . $stmt->rowCount() . "<br>";

    if ($stmt->rowCount() == 1) {
        $stmt = $pdo->prepare("UPDATE users SET valid_password = :new_password WHERE email = :email");
        $stmt->bindParam(':new_password', $new_password);
        $stmt->bindParam(':email', $email);
        if ($stmt->execute()) {
            echo "<script>alert('Password updated successfully.'); window.location.href='../Html_Codes/Userlogin.html';</script>";
        } else {
            echo "<script>alert('Failed to update password. Please try again.'); window.location.href='../Php_Codes/ForgetPass.php';</script>";
        }
    } else {
        echo "<script>alert('No account found with that email.'); window.location.href='../Php_Codes/ForgetPass.php';</script>";
    }
}
?>
