<?php
$conn = mysqli_connect("localhost", "root", "", "user_info");
if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
}

$data = json_decode(file_get_contents("php://input"));
$userId = $data->id;

$sql = "DELETE FROM users WHERE id = $userId";
if ($conn->query($sql) === TRUE) {
    http_response_code(200); 
} else {
    http_response_code(500); 
}

$conn->close();
?>