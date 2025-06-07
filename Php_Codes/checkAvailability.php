<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Css_Codes/BookingPagestyle.css?v=2">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
    <title>Check for Date Availability</title>
    <style>
        .footer {
            position: absolute;
            width: 100%;
            bottom: -188px;
            padding: 30px 0;
            background-color: #009688;
        }
        .footer .social {
            text-align: center;
            padding-bottom: 25px;
            color: black;
        }
        .footer .social a {
            font-size: 24px;
            color: inherit;
            border: 1px solid black;
            width: 40px;
            height: 40px;
            line-height: 38px;
            display: inline-block;
            text-align: center;
            border-radius: 50%;
            margin: 0 8px;
            opacity: 0.75;
        }
        .footer .social a:hover {
            opacity: 0.9;
        }
        .footer ul {
            margin-top: 0;
            padding: 0;
            list-style: none;
            text-align: center;
            font-size: 18px;
            line-height: 1.6;
            margin-bottom: 0;
        }
        .footer ul a {
            color: inherit;
            text-decoration: none;
            opacity: 0.8;
        }
        .footer ul li {
            display: inline-block;
            padding: 0 15px;
        }
        .footer ul a:hover {
            opacity: 1;
        }
        .footer .copyright {
            margin-top: 15px;
            text-align: center;
            font-size: 13px;
            color: #aaa;
        }

        .blue-column {
            background-color: blue;
            color: white;
        }

                
        #back{
            width:100px;
            padding: 15px 0;
            text-align:center;
            margin:20 px 10 px;
            border-radius:25px;
            font-weight:bold;
            border: 2px solid #009688;
            background: transparent;
            color:#fff;
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
          #backspan{
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
          #back:hover #backspan{
            width: 100%;
          }
          #back:hover{
            border: none;
          }
    </style>
</head>
<body>
<div style="padding: 30px 0 0 0;">
    <button type="button" id="back"><span id="backspan"></span><a href="../Php_Codes/BookingPage.php"><i class="fas fa-arrow-left"></i></a></button>
</div>
<h1 style="text-align:center; margin-top: 20px; color: #009688;">Check for Date Availability</h1>

<div class="tabs">
    <div class="tab active" data-tab="halls">Community Halls</div>
    <div class="tab" data-tab="sports">Sport Facilities</div>
    <div class="tab" data-tab="transport">Public Transportation</div>
</div>

<!-- Filter Bar -->
<div class="filter-bar">
    <input type="text" id="searchInput" placeholder="Search by preference, reason, etc...">
    <input type="date" id="startDate">
    <input type="date" id="endDate">
    <button onclick="applyFilters()">Filter</button>
    <button onclick="resetFilters()">Reset</button>
</div>

<!-- Community Halls Table -->
<div class="table-container tab-content" id="tab-halls">
    <h2>Community Halls and Centers</h2>
    <table id="userTable1">
        <thead>
        <tr>
            <th>ID</th>
            <th><i class="fas fa-building"></i> Booking Preference</th>
            <th>Reason</th>
            <th>Date Started</th>
            <th>Date Ended</th>
            <th>Time Started</th>
            <th>Time End</th>
            <th>Others</th>
            <th>Status</th>
            <th>Booking Time</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $conn = mysqli_connect("localhost", "root", "", "user_info");
        $today = date('Y-m-d');
        $now = date('H:i:s');
        if ($conn->connect_error) {
            die("Connection Failed: " . $conn->connect_error);
        }
        $sql = "SELECT id, bookingpreference, reason, event_date_start, event_date_end, event_time_start, event_time_end, others, bookingtime, status FROM bookingform1 ORDER BY id DESC";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $status = (!empty($row["status"])) ? $row["status"] : 'pending';
                echo "<tr><td>" . $row["id"] .
                    "</td><td>" . htmlspecialchars($row["bookingpreference"]) .
                    "</td><td>" . htmlspecialchars($row["reason"]) .
                    "</td><td>" . date('M d, Y', strtotime($row["event_date_start"])) .
                    "</td><td>" . date('M d, Y', strtotime($row["event_date_end"])) .
                    "</td><td>" . date('h:i A', strtotime($row["event_time_start"])) .
                    "</td><td>" . date('h:i A', strtotime($row["event_time_end"])) .
                    "</td><td>" . htmlspecialchars($row["others"]) .
                    "</td><td>" . $status . "</td>" .
                    "<td>" . date('M d, Y h:i A', strtotime($row["bookingtime"])) . "</td></tr>";
            }
        }
        $conn->close();
        ?>
        </tbody>
    </table>
</div>

<!-- Sport Facilities Table -->
<div class="table-container tab-content" id="tab-sports" style="display:none;">
    <h2>Sport Facilities and Equipment</h2>
    <table id="userTable2">
        <thead>
        <tr>
            <th>ID</th>
            <th><i class="fas fa-futbol"></i> Booking Preference</th>
            <th>Reason</th>
            <th>Date Started</th>
            <th>Date Ended</th>
            <th>Time Started</th>
            <th>Time End</th>
            <th>Sport Equipment</th>
            <th>Others</th>
            <th>Status</th>
            <th>Booking Time</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $conn = mysqli_connect("localhost", "root", "", "user_info");
        $today = date('Y-m-d');
        if ($conn->connect_error) {
            die("Connection Failed: " . $conn->connect_error);
        }
        $sql = "SELECT id, bookingpreference, reason, book_date_start, book_date_end, book_time_start, book_time_end, sport_equipment, others, bookingtime, status FROM bookingform2 ORDER BY id DESC";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $status = (!empty($row["status"])) ? $row["status"] : 'pending';
                echo "<tr><td>" . $row["id"] .
                    "</td><td>" . htmlspecialchars($row["bookingpreference"]) .
                    "</td><td>" . htmlspecialchars($row["reason"]) .
                    "</td><td>" . date('M d, Y', strtotime($row["book_date_start"])) .
                    "</td><td>" . date('M d, Y', strtotime($row["book_date_end"])) .
                    "</td><td>" . date('h:i A', strtotime($row["book_time_start"])) .
                    "</td><td>" . date('h:i A', strtotime($row["book_time_end"])) .
                    "</td><td>" . htmlspecialchars($row["sport_equipment"]) .
                    "</td><td>" . htmlspecialchars($row["others"]) .
                    "</td><td>" . $status . "</td>" .
                    "<td>" . date('M d, Y h:i A', strtotime($row["bookingtime"])) . "</td></tr>";
            }
        }
        $conn->close();
        ?>
        </tbody>
    </table>
</div>

<!-- Public Transportation Table -->
<div class="table-container tab-content" id="tab-transport" style="display:none;">
    <h2>Public Transportation</h2>
    <table id="userTable3">
        <thead>
        <tr>
            <th>ID</th>
            <th><i class="fas fa-bus"></i> Vehicle Type</th>
            <th>Reason</th>
            <th>Pick Up Date</th>
            <th>Pick Up Time</th>
            <th>Destination</th>
            <th>Days</th>
            <th>Others</th>
            <th>Status</th>
            <th>Booking Time</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $conn = mysqli_connect("localhost","root","","user_info");
        $today = date('Y-m-d');
        if($conn->connect_error) {
            die("Connection Failed: ".$conn->connect_error);
        }
        $sql = "SELECT id, vehicle_type, reason, pick_up_date, pick_up_time, destination, days_use, others, bookingtime, status from bookingform3 ORDER BY id DESC";
        $result = $conn->query($sql);
        if($result->num_rows>0) {
            while($row = $result->fetch_assoc()) {
                $status = (!empty($row["status"])) ? $row["status"] : 'pending';
                echo "<tr><td>" . $row["id"] .
                    "</td><td>" . htmlspecialchars($row["vehicle_type"]) .
                    "</td><td>" . htmlspecialchars($row["reason"]) .
                    "</td><td>" . date('M d, Y', strtotime($row["pick_up_date"])) .
                    "</td><td>" . date('h:i A', strtotime($row["pick_up_time"])) .
                    "</td><td>" . htmlspecialchars($row["destination"]) .
                    "</td><td>" . htmlspecialchars($row["days_use"]) .
                    "</td><td>" . htmlspecialchars($row["others"]) .
                    "</td><td>" . $status . "</td>" .
                    "<td>" . date('M d, Y h:i A', strtotime($row["bookingtime"])) . "</td></tr>";
            }
        }
        $conn->close();
        ?>
        </tbody>
    </table>
</div>

<section class="footer">
    <div class="social">
      <a href="#"><i class="fab fa-instagram"></i></a>
      <a href="#"><i class="fab fa-snapchat"></i></a>
      <a href="#"><i class="fab fa-twitter"></i></a>
      <a href="#"><i class="fab fa-facebook-f"></i></a>
    </div>
    <ul class="list">
      <li>
        <a href="../Html_Codes/Homepage.html">Home</a>
      </li>
      <li>
        <a href="../Html_Codes/AboutPage.html">About</a>
      </li>
      <li>
        <a href="../Html_Codes/ContactPage.html">Contact</a>
      </li>
      <li>
        <a href="#">Privacy Policy</a>
      </li>
      <li>
        <a href="#">FAQs</a>
      </li>
    </ul>
    <p class="copyright">&copy;AAJBangalao@BSIT-2B</p>
  </section>

<script>
// Tab switching
const tabs = document.querySelectorAll('.tab');
const tabContents = document.querySelectorAll('.tab-content');
tabs.forEach(tab => {
    tab.addEventListener('click', () => {
        tabs.forEach(t => t.classList.remove('active'));
        tab.classList.add('active');
        tabContents.forEach(tc => tc.style.display = 'none');
        document.getElementById('tab-' + tab.dataset.tab).style.display = '';
    });
});

// Filtering
function applyFilters() {
    const search = document.getElementById('searchInput').value.toLowerCase();
    const startDate = document.getElementById('startDate').value;
    const endDate = document.getElementById('endDate').value;
    const visibleTable = document.querySelector('.tab-content:not([style*="display: none"]) table');
    const rows = visibleTable.querySelectorAll('tbody tr');
    rows.forEach(row => {
        let text = row.textContent.toLowerCase();
        let show = true;
        if (search && !text.includes(search)) show = false;
        if (startDate || endDate) {
            let dateCells = Array.from(row.cells).filter(cell => cell.textContent.match(/\w{3} \d{2}, \d{4}/));
            let match = false;
            dateCells.forEach(cell => {
                let cellDate = new Date(cell.textContent);
                if (
                    (!startDate || cellDate >= new Date(startDate)) &&
                    (!endDate || cellDate <= new Date(endDate))
                ) {
                    match = true;
                }
            });
            if (!match) show = false;
        }
        row.style.display = show ? '' : 'none';
    });
}
function resetFilters() {
    document.getElementById('searchInput').value = '';
    document.getElementById('startDate').value = '';
    document.getElementById('endDate').value = '';
    applyFilters();
}
</script>
</body>
</html>
