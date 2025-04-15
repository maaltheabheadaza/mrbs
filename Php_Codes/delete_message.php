<?php
$conn = mysqli_connect("localhost", "root", "", "user_info");
if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "DELETE") {
    $id = $_GET['id'];
    $sql = "DELETE FROM contact_us WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        http_response_code(200);
        echo "Message deleted successfully!";
    } else {
        http_response_code(500);
        echo "Error deleting message: " . $conn->error;
    }
}

$conn->close();
?>
