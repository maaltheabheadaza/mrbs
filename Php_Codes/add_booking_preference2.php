<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['booking_preference'])) {
    $preference = $_POST['booking_preference'];

    $conn = mysqli_connect("localhost", "root", "", "user_info");
    if ($conn->connect_error) {
        die("Connection Failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("INSERT INTO booking_preferences2 (preference) VALUES (?)");
    $stmt->bind_param("s", $preference);

    if ($stmt->execute()) {
        echo "<script>
                alert('New booking preference created successfully.');
                window.location.href = 'AdminPage_bookform2.php';
              </script>";
    } else {
        echo "<script>
                alert('Error: " . $stmt->error . "');
                window.location.href = 'AdminPage_bookform2.php';
              </script>";
    }
    
    $stmt->close();
    $conn->close();
} else {
    header("Location: AdminPage_bookform2.php");
    exit();
}
?>