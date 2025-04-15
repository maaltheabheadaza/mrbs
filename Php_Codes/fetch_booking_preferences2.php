<?php

$servername = "localhost"; 
$username = "root";        
$password = "";          
$dbname = "user_info"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$sql = "SELECT preference FROM booking_preferences2";
$result = $conn->query($sql);

$options = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $options[] = $row['preference'];
    }
}

$conn->close();

echo json_encode($options);
?>