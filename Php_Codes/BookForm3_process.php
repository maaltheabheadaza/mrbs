<?php
$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "user_info"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$stmt = $conn->prepare("INSERT INTO bookingform3 (fullname, email, full_address, contact_number, vehicle_type, reason, pick_up_date, pick_up_time, destination, days_use, others, bookingtime) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())");
$stmt->bind_param("sssisssssss", $fullname, $email, $full_address, $contact_number, $vehicle_type, $reason, $pick_up_date, $pick_up_time, $destination, $days_use, $others);

$fullname = $_POST['fullname'];
$email = $_POST['email'];
$full_address = $_POST['full_address'];
$contact_number = $_POST['contact_number'];
$vehicle_type = $_POST['vehicle_type'];
$reason = $_POST['reason'];
$pick_up_date = $_POST['pick_up_date'];
$pick_up_time = $_POST['pick_up_time'];
$destination = $_POST['destination'];
$days_use = $_POST['days_use'];
$others = $_POST['others'];

if ($stmt->execute()) {
    echo "<script>alert('Registration successful'); window.location.href='../Html_Codes/EndPage.html';</script>";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>