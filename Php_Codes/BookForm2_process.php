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
    $book_date_start = $_POST['book_date_start'];
    $book_date_end = $_POST['book_date_end'];
    $book_time_start = $_POST['book_time_start'];
    $book_time_end = $_POST['book_time_end'];
    $sport_equipment = $_POST['sport_equipment'];
    $others = $_POST['others'];
    $bookingtime = date("Y-m-d H:i:s");

    $sql = "INSERT INTO bookingform2 (fullname, email, full_address, contact_number, bookingpreference, reason, book_date_start, book_date_end, book_time_start, book_time_end, sport_equipment, others, bookingtime)
            VALUES ('$fullname', '$email', '$full_address', '$contact_number', '$bookingpreference', '$reason', '$book_date_start', '$book_date_end', '$book_time_start', '$book_time_end', '$sport_equipment', '$others', '$bookingtime')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>
                alert('Registration successful!');
                window.location.href='../Html_Codes/EndPage.html';
              </script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>