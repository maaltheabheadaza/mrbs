<?php
session_start();
require_once 'db_connect.php';

// Check if user is logged in
if (!isset($_SESSION['email'])) {
    // Store the current page URL in session
    $_SESSION['redirect_url'] = $_SERVER['PHP_SELF'];
    header("Location: ../Html_Codes/Userlogin.html");
    exit();
}

$user_email = $_SESSION['email'];

// Fetch booking history from all three booking tables
$query = "(SELECT 
            id,
            fullname,
            email,
            bookingpreference as resource_name,
            event_date_start as booking_date,
            event_time_start as start_time,
            event_time_end as end_time,
            status,
            'hall' as booking_type,
            bookingtime
          FROM bookingform1 
          WHERE email = ?)
          UNION ALL
          (SELECT 
            id,
            fullname,
            email,
            bookingpreference as resource_name,
            book_date_start as booking_date,
            book_time_start as start_time,
            book_time_end as end_time,
            status,
            'sports' as booking_type,
            bookingtime
          FROM bookingform2 
          WHERE email = ?)
          UNION ALL
          (SELECT 
            id,
            fullname,
            email,
            vehicle_type as resource_name,
            pick_up_date as booking_date,
            pick_up_time as start_time,
            pick_up_time as end_time,
            status,
            'transport' as booking_type,
            bookingtime
          FROM bookingform3 
          WHERE email = ?)
          ORDER BY bookingtime DESC";

$stmt = $conn->prepare($query);
$stmt->bind_param("sss", $user_email, $user_email, $user_email);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Booking History</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="../Css_Codes/BookingPagestyle.css?v=2">
    <style>
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        #back {
            width: 100px;
            padding: 15px 0;
            text-align: center;
            margin: 20px 10px;
            border-radius: 25px;
            font-weight: bold;
            border: 2px solid #009688;
            background: transparent;
            color: #fff;
            cursor: pointer;
            overflow: hidden;
            position: absolute;
            left: 30px;
            top: 30px;
        }

        #back i {
            color: #fff;
            font-size: 20px;
        }

        #backspan {
            background: #009688;
            height: 100%;
            width: 0%;
            border-radius: 25px;
            position: absolute;
            left: 0;
            bottom: 0;
            z-index: -1;
            transition: 0.5s;
        }

        #back:hover #backspan {
            width: 100%;
        }

        #back:hover {
            border: none;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .back-button {
            padding: 10px 20px;
            background-color: #009688;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .back-button:hover {
            background-color: #00796b;
        }

        .booking-table {
            width: 100%;
            border-collapse: collapse;
            background-color: white;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
            margin-top: 20px;
        }

        .booking-table th,
        .booking-table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }

        .booking-table th {
            background-color: #009688;
            color: white;
            font-weight: 600;
        }

        .booking-table tr:hover {
            background-color: #f9f9f9;
        }

        .status {
            padding: 5px 10px;
            border-radius: 15px;
            font-size: 0.9em;
            font-weight: 500;
        }

        .status-pending {
            background-color: #fff3e0;
            color: #ef6c00;
        }

        .booking-type {
            padding: 5px 10px;
            border-radius: 15px;
            font-size: 0.9em;
            font-weight: 500;
        }

        .type-hall {
            background-color: #e3f2fd;
            color: #1565c0;
        }

        .type-sports {
            background-color: #e8f5e9;
            color: #2e7d32;
        }

        .type-transport {
            background-color: #f3e5f5;
            color: #6a1b9a;
        }

        .no-bookings {
            text-align: center;
            padding: 40px;
            color: #666;
            font-size: 1.2em;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
        }

        .action-button {
            padding: 6px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 0.9em;
            margin-right: 5px;
        }

        .cancel-button {
            background-color: #ff5252;
            color: white;
        }

        .cancel-button:hover {
            background-color: #ff1744;
        }

        .cancel-button:disabled {
            background-color: #ccc;
            cursor: not-allowed;
        }

        h1 {
            text-align: center;
            margin-top: 20px;
            color: #009688;
        }

        .table-container {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div>
        <button type="button" id="back"><span id="backspan"></span><a href="../Php_Codes/BookingPage.php"><i class="fas fa-arrow-left"></i></a></button>
    </div>

    <div class="container">
        <h1>My Booking History</h1>

        <div class="table-container">
            <?php if ($result->num_rows > 0): ?>
                <table class="booking-table">
                    <thead>
                        <tr>
                            <th>Type</th>
                            <th>Resource</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td>
                                    <span class="booking-type type-<?php echo $row['booking_type']; ?>">
                                        <?php 
                                            echo ucfirst($row['booking_type']);
                                            if ($row['booking_type'] == 'hall') echo ' (Community Hall)';
                                            if ($row['booking_type'] == 'sports') echo ' (Sports Facility)';
                                            if ($row['booking_type'] == 'transport') echo ' (Transport)';
                                        ?>
                                    </span>
                                </td>
                                <td><?php echo htmlspecialchars($row['resource_name']); ?></td>
                                <td><?php echo date('F j, Y', strtotime($row['booking_date'])); ?></td>
                                <td>
                                    <?php 
                                        if ($row['booking_type'] == 'transport') {
                                            echo date('g:i A', strtotime($row['start_time']));
                                        } else {
                                            echo date('g:i A', strtotime($row['start_time'])) . ' - ' . 
                                                 date('g:i A', strtotime($row['end_time']));
                                        }
                                    ?>
                                </td>
                                <td>
                                    <span class="status status-<?php echo strtolower($row['status']); ?>">
                                        <?php echo ucfirst($row['status']); ?>
                                    </span>
                                </td>
                                <td>
                                    <?php if (strtotime($row['booking_date']) >= strtotime('today')): ?>
                                        <button class="action-button cancel-button" 
                                                onclick="cancelBooking(<?php echo $row['id']; ?>, '<?php echo $row['booking_type']; ?>')">
                                            Cancel
                                        </button>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div class="no-bookings">
                    <p>You haven't made any bookings yet.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function cancelBooking(bookingId, bookingType) {
            Swal.fire({
                title: 'Are you sure you want to cancel this booking?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#009688',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, cancel it',
                cancelButtonText: 'No, keep it'
            }).then((result) => {
                if (result.isConfirmed) {
                fetch('cancelBooking.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: 'booking_id=' + bookingId + '&booking_type=' + bookingType
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Booking cancelled successfully',
                                showConfirmButton: false,
                                timer: 1500
                            }).then(() => location.reload());
                    } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: data.message || 'Error cancelling booking.'
                            });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'An error occurred while cancelling the booking.'
                        });
                });
            }
            });
        }
    </script>
</body>
</html> 