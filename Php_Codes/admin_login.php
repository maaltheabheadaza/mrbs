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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM admin WHERE email='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $adminData = $result->fetch_assoc();
        if (password_verify($password, $adminData['valid_password'])) {
            $_SESSION['admin'] = $adminData;
            $_SESSION['admin_name'] = $adminData['fullname'];
            header("Location: ../Php_Codes/AdminPage_dashboard.php?login_success=1");
            exit();
        } else {
            echo '<script>alert("Incorrect email or password. Please try again.");</script>';
            echo '<script>window.location.href = "../Html_Codes/adminlogin.html";</script>';
        }
    } else {
        echo '<script>alert("Incorrect email or password. Please try again.");</script>';
        echo '<script>window.location.href = "../Html_Codes/adminlogin.html";</script>';
    }
}

$conn->close();
?>
