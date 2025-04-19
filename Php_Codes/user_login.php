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
        // Show success modal and redirect
        echo '<!DOCTYPE html>
        <html>
        <head>
            <title>Login Success</title>
            <style>
                .modal {
                    display: block;
                    position: fixed;
                    z-index: 1;
                    left: 0;
                    top: 0;
                    width: 100%;
                    height: 100%;
                    background-color: rgba(0,0,0,0.4);
                }
                .modal-content {
                    background-color: #fefefe;
                    margin: 15% auto;
                    padding: 20px;
                    border: 1px solid #888;
                    width: 80%;
                    max-width: 400px;
                    border-radius: 8px;
                    text-align: center;
                    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
                }
                .success-icon {
                    color: #4CAF50;
                    font-size: 48px;
                    margin-bottom: 20px;
                }
                .modal-message {
                    font-size: 18px;
                    margin-bottom: 20px;
                    color: #333;
                }
                .redirect-message {
                    font-size: 14px;
                    color: #666;
                }
            </style>
        </head>
        <body>
            <div class="modal">
                <div class="modal-content">
                    <div class="success-icon">✓</div>
                    <div class="modal-message">Login Successful!</div>
                    <div class="redirect-message">Redirecting to booking page...</div>
                </div>
            </div>
            <script>
                setTimeout(function() {
                    window.location.href = "../Html_Codes/BookingPage.html";
                }, 2000);
            </script>
        </body>
        </html>';
        exit();
    } else {
        echo '<script>alert("Incorrect email or password. Please try again.");</script>';
        echo '<script>window.location.href = "../Html_Codes/Userlogin.html";</script>';
    }
}

$conn->close();
?>