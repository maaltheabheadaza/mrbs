<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "user_info";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $full_address = $_POST['full_address'];
    $contact_number = $_POST['contact_number'];
    $bookingpreference = $_POST['bookingpreference'];
    $reason = $_POST['reason'];
    $event_date_start = $_POST['event_date_start'];
    $event_date_end = $_POST['event_date_end'];
    $event_time_start = $_POST['event_time_start'];
    $event_time_end = $_POST['event_time_end'];
    $others = $_POST['others'];
    $bookingtime = date("Y-m-d H:i:s");

    $sql = "INSERT INTO bookingform1 (fullname, email, full_address, contact_number, bookingpreference, reason, event_date_start, event_date_end, event_time_start, event_time_end, others, bookingtime)
            VALUES ('$fullname', '$email', '$full_address', '$contact_number', '$bookingpreference', '$reason', '$event_date_start', '$event_date_end', '$event_time_start', '$event_time_end', '$others', '$bookingtime')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>
                alert('Register successfully');
                window.location.href='../Html_Codes/EndPage.html';
              </script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
