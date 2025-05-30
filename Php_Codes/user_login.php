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
    $captcha = $_POST['g-recaptcha-response'];

    // Verify CAPTCHA
    $secretKey = "6LdV3zsrAAAAAOl8Or7LkwglfT-IHAABjQG7pwjJ";
    $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secretKey&response=$captcha");
    $responseKeys = json_decode($response, true);

    if (!$responseKeys["success"]) {
        echo '<script>alert("CAPTCHA verification failed. Please try again.");</script>';
        echo '<script>window.location.href = "../Html_Codes/Userlogin.html";</script>';
        exit();
    }

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
                    background-color: rgba(0,0,0,0.7);
                    backdrop-filter: blur(8px);
                }
                .modal-content {
                    background: linear-gradient(145deg, #ffffff, #f8f8f8);
                    margin: 15% auto;
                    padding: 35px;
                    border: none;
                    width: 80%;
                    max-width: 400px;
                    border-radius: 20px;
                    text-align: center;
                    box-shadow: 0 15px 35px rgba(0,0,0,0.2);
                    animation: modalFadeIn 0.6s ease-out;
                    position: relative;
                    overflow: hidden;
                }
                .modal-content::before {
                    content: "";
                    position: absolute;
                    top: 0;
                    left: 0;
                    width: 100%;
                    height: 5px;
                    background: linear-gradient(90deg, #009688, #00bcd4);
                }
                @keyframes modalFadeIn {
                    from {
                        opacity: 0;
                        transform: translateY(-30px);
                    }
                    to {
                        opacity: 1;
                        transform: translateY(0);
                    }
                }
                .success-icon {
                    color: #009688;
                    font-size: 65px;
                    margin-bottom: 25px;
                    animation: scaleIn 0.6s ease-out;
                    text-shadow: 0 2px 10px rgba(0,150,136,0.2);
                }
                @keyframes scaleIn {
                    0% {
                        transform: scale(0);
                        opacity: 0;
                    }
                    50% {
                        transform: scale(1.2);
                    }
                    100% {
                        transform: scale(1);
                        opacity: 1;
                    }
                }
                .modal-message {
                    font-size: 26px;
                    margin-bottom: 20px;
                    color: #009688;
                    font-weight: 600;
                    letter-spacing: 0.5px;
                    text-transform: uppercase;
                }
                .redirect-message {
                    font-size: 16px;
                    color: #666;
                    font-weight: 400;
                    position: relative;
                    padding-bottom: 15px;
                }
                .redirect-message::after {
                    content: "";
                    position: absolute;
                    bottom: 0;
                    left: 50%;
                    transform: translateX(-50%);
                    width: 50px;
                    height: 3px;
                    background: linear-gradient(90deg, #009688, #00bcd4);
                    border-radius: 3px;
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