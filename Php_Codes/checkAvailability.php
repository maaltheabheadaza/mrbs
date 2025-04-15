<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
    <title>Check for Date Availability</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap');

        * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
            font-family: "Poppins", sans-serif;
        }
        body {
            width: 100%;
            height: 250vh;
            background-image: linear-gradient(rgba(0,0,0,0.75),rgba(0,0,0,0.75)), url("https://assets-global.website-files.com/6009ec8cda7f305645c9d91b/60107f9c58f4bb476b10caa8_6002086f72b72769e701e207_online-booking-system.jpeg");
            background-size:cover;
            background-position: center;
            color: white;
        }
        h1 {
            position: relative;
            top: 20px;
        }
        h1 p {
            position: absolute;
            top: 15px;
            left: 160px;
        }
        
        .table-container {
            padding-top: 10px;
            width: 90%;
            margin: 20px auto;
            height: calc(250vh / 3);
            overflow-y: auto;
            background: rgba(255, 255, 255, 0.8);
            padding: 20px;
            border-radius: 10px;
            color: black;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 10px;
            border: 1px solid black;
            text-align: center;
        }
        th {
            background-color: #009688;
            color: white;
        }
        .footer {
            position: absolute;
            width: 100%;
            bottom: -210%;
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

<h1 style="padding: 40px;"><p>Check for Date Availability</p></h1>
<div>
    <button type="button" id="back"><span id="backspan"></span><a href="../Html_Codes/BookingPage.html"><i class="fas fa-arrow-left"></i></a></button>
</div>

<div class="table-container" id="table1">
    <h2>Community Halls and Centers</h2>
    <table id="userTable1">
        <tr>
            <th>ID</th>
            <th>Booking Preference</th>
            <th>Reason</th>
            <th class="blue-column">Date Started</th>
            <th class="blue-column">Date Ended</th>
            <th class="blue-column">Time Started</th>
            <th class="blue-column">Time End</th>
            <th>Others</th>
            <th>Booking Time</th>
        </tr>
        <?php
        $conn = mysqli_connect("localhost", "root", "", "user_info");
        if ($conn->connect_error) {
            die("Connection Failed: " . $conn->connect_error);
        }
        $sql = "SELECT id, bookingpreference, reason, event_date_start, event_date_end, event_time_start, event_time_end, others, bookingtime FROM bookingform1 ORDER BY id";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr><td>" . $row["id"] .
                    "</td><td>" . $row["bookingpreference"] .
                    "</td><td>" . $row["reason"] .
                    "</td><td>" . $row["event_date_start"] .
                    "</td><td>" . $row["event_date_end"] .
                    "</td><td>" . $row["event_time_start"] .
                    "</td><td>" . $row["event_time_end"] .
                    "</td><td>" . $row["others"] .
                    "</td><td>" . $row["bookingtime"] . "</td></tr>";
            }
            echo "</table>";
        } else {
            echo "0 result";
        }

        $conn->close();
        ?>
    </table>
</div>

<div class="table-container" id="table2">
    <h2>Sport Facilities and Equipment</h2>
    <table id="userTable2">
        <tr>
            <th>ID</th>
            <th>Booking Preference</th>
            <th>Reason</th>
            <th class="blue-column">Date Started</th>
            <th class="blue-column">Date Ended</th>
            <th class="blue-column">Time Started</th>
            <th class="blue-column">Time End</th>
            <th>If Sport Equipment</th>
            <th>Others</th>
            <th>Booking Time</th>
        </tr>
        <?php
        $conn = mysqli_connect("localhost", "root", "", "user_info");
        if ($conn->connect_error) {
            die("Connection Failed: " . $conn->connect_error);
        }
        $sql = "SELECT id, bookingpreference, reason, book_date_start, book_date_end, book_time_start, book_time_end, sport_equipment, others, bookingtime FROM bookingform2";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr><td>" . $row["id"] .
                    "</td><td>" . $row["bookingpreference"] .
                    "</td><td>" . $row["reason"] .
                    "</td><td>" . $row["book_date_start"] .
                    "</td><td>" . $row["book_date_end"] .
                    "</td><td>" . $row["book_time_start"] .
                    "</td><td>" . $row["book_time_end"] .
                    "</td><td>" . $row["sport_equipment"] .
                    "</td><td>" . $row["others"] .
                    "</td><td>" . $row["bookingtime"] . "</td></tr>";
            }
            echo "</table>";
        } else {
            echo "0 result";
        }

        $conn->close();
        ?>
    </table>
</div>

<div class="table-container" id="table3">
    <h2>Public Transportation</h2>
    <table id="userTable3">
        <tr>
            <th>ID</th>
            <th>Vehicle Type</th>
            <th>Reason</th>
            <th class="blue-column">Pick Up Date</th>
            <th class="blue-column">Pick Up Time</th>
            <th>Destination</th>
            <th class="blue-column">Days</th>
            <th>Others</th>
            <th>Booking Time</th>
        </tr>

        <?php
        $conn = mysqli_connect("localhost","root","","user_info");
        if($conn->connect_error) {
            die("Connection Failed: ".$conn->connect_error);
        }
        $sql = "SELECT id, vehicle_type, reason, pick_up_date, pick_up_time, destination, days_use, others, bookingtime from bookingform3";
        $result = $conn->query($sql);

        if($result->num_rows>0) {
            while($row = $result->fetch_assoc()) {
                echo"</tr><td>".$row["id"].
                "</td><td>".$row["vehicle_type"].
                "</td><td>".$row["reason"].
                "</td><td>".$row["pick_up_date"].
                "</td><td>".$row["pick_up_time"].
                "</td><td>".$row["destination"].
                "</td><td>".$row["days_use"].
                "</td><td>".$row["others"].
                "</td><td>".$row["bookingtime"];
            }
            echo"</table>";
        }
        else{
            echo"0 result";
        }

        $conn->close();
        ?>
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
    document.addEventListener("DOMContentLoaded", () => {
    function renumberAndSortIDs(tableId) {
        const table = document.getElementById(tableId);
        const tbody = table.querySelector("tbody");
        const rows = Array.from(tbody.querySelectorAll("tr"));

        rows.sort((a, b) => {
            const idA = parseInt(a.querySelector("td:first-child").textContent, 10);
            const idB = parseInt(b.querySelector("td:first-child").textContent, 10);
            return idA - idB;
        });

        tbody.innerHTML = "";
        let idCounter = 1;
        rows.forEach((row, index) => {
            const idCell = row.querySelector("td:first-child");
            if (idCell) {
                idCell.textContent = idCounter;
                idCounter++;
            }
            row.id = "row" + idCounter;
            tbody.appendChild(row);
        });
    }

    renumberAndSortIDs("userTable1");
    renumberAndSortIDs("userTable2");
    renumberAndSortIDs("userTable3");
});
  </script>
</body>

</html>
