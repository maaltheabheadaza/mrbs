<?php
$conn = mysqli_connect("localhost", "root", "", "user_info");
if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "DELETE") {
    $id = $_GET['id'];
    
    // Start transaction
    $conn->begin_transaction();
    
    try {
        // Delete from booking_preferences1
        $sql1 = "DELETE FROM booking_preferences1 WHERE id=$id";
        $conn->query($sql1);
        
        // Delete from bookingform1
        $sql2 = "DELETE FROM bookingform1 WHERE id=$id";
        $conn->query($sql2);
        
        // If both queries successful, commit the transaction
        $conn->commit();
        http_response_code(200);
        echo "Booking deleted successfully!";
    } catch (Exception $e) {
        // If any query fails, rollback the transaction
        $conn->rollback();
        http_response_code(500);
        echo "Error deleting booking: " . $e->getMessage();
    }
}

$conn->close();
?>