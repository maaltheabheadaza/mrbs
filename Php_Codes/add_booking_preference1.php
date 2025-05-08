<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['booking_preference']) && isset($_POST['per_hour'])) {
    $preference = $_POST['booking_preference'];
    $per_hour = intval($_POST['per_hour']);

    $conn = mysqli_connect("localhost", "root", "", "user_info");

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $sql = "INSERT INTO booking_preferences1 (preference, per_hour) VALUES (?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "si", $preference, $per_hour);

    if (mysqli_stmt_execute($stmt)) {
        echo "<script>alert('Booking preference added successfully'); window.location.href='../Php_Codes/AdminPage_bookform1.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
?>
