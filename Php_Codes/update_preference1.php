=<?php
$conn = mysqli_connect("localhost", "root", "", "user_info");
$data = json_decode(file_get_contents("php://input"), true);

$id = intval($data['id']);
$preference = mysqli_real_escape_string($conn, $data['preference']);
$per_hour = floatval($data['per_hour']);

$query = "UPDATE booking_preferences1 SET preference='$preference', per_hour='$per_hour' WHERE id=$id";

if (!mysqli_query($conn, $query)) {
    echo "Error: " . mysqli_error($conn);
}
?>
