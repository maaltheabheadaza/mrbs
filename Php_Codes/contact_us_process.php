<?php
$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "user_info"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$fullname = $_POST['fullname'];
$email = $_POST['email'];
$message = $_POST['message'];

$stmt = $conn->prepare("INSERT INTO contact_us (fullname, email, messages, time_sent) VALUES (?, ?, ?, NOW())");
$stmt->bind_param("sss", $fullname, $email, $message);

if ($stmt->execute()) {
  echo "Your message has been sent successfully!";
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}

$stmt->close();
$conn->close();
?>
