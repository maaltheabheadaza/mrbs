<?php
$conn = mysqli_connect("localhost", "root", "", "user_info");
if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "DELETE") {
    $id = $_GET['id'];
    $sql = "DELETE FROM booking_preferences2 WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        http_response_code(200);
        echo "Booking deleted successfully!";
    } else {
        http_response_code(500);
        echo "Error deleting booking: " . $conn->error;
    }
}

$conn->close();
?>