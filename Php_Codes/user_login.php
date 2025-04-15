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

    $sql = "SELECT * FROM users WHERE email='$email' AND valid_password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $_SESSION['email'] = $email; 
        header("Location: ../Html_Codes/BookingPage.html"); 
        exit(); 
    } else {
        echo '<script>alert("Incorrect email or password. Please try again.");</script>';
        echo '<script>window.location.href = "../Html_Codes/Userlogin.html";</script>';
    }
}

$conn->close();
?>