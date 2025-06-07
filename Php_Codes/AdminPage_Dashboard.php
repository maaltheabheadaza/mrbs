<?php
//session

session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: ../Html_Codes/adminlogin.html");
    exit();
}
$admin = $_SESSION['admin']; 
$profileImage = $_SESSION['admin']['profile_image'];




  $conn = mysqli_connect("localhost", "root", "", "user_info");
  if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
  }

  function countRows($conn, $tableName)
  {
    $sql = "SELECT COUNT(*) as total FROM $tableName";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
      $row = $result->fetch_assoc();
      return $row['total'];
    } else {
      return 0;
    }
  }

  $totalBookings1 = countRows($conn, 'bookingform1');
  $totalBookings2 = countRows($conn, 'bookingform2');
  $totalBookings3 = countRows($conn, 'bookingform3');
  $totalUsers = countRows($conn, 'users');
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="Cache-Control" content="no-store, no-cache, must-revalidate, post-check=0, pre-check=0">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <title>Administration Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css"/>
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200">
    <link rel="stylesheet" type="text/css" href="../Css_Codes/AdminPage_Dashboardstyle.css">
    <link rel="icon" href="../Images/admin.png" type="image/png">
    <style>

    .box1, .box2, .box3{
      position: absolute;
      top: 19%;
      width: 30%;
      height: 60px;
      border-radius: 20px;
      padding: 5px;
      text-align: center;
      box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.2);
      cursor: pointer;
    }

    .box4 {
      position: absolute;
      top: 103%;
      width: 20%;
      left: 30px;
      height: 60px;
      border-radius: 20px;
      padding: 5px;
      text-align: center;
      box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.2);
      background-color: #009688;
    }

    .box1 { left: 30px; background-color: #F7DFF5; }
    .box2 { left: 35%; background-color: #d1e8ff; }
    .box3 { right: 30px; background-color: #f1f1f1; }

    .box p { margin-top: 20px; }
    .box p span { font-size: 20px; font-weight: 600; color: var(--text-color); }

      .tables-container, #userTable1, #userTable2, #userTable3 {
        width: 98%;
        height: 58%;
        overflow-y: auto;
        border-collapse: collapse;
        margin-left: auto;
        margin-right: auto; 
        position: absolute;
        top: 29%;
        left: 12px;
        border: none; 
      }
      
      #userTable1, #userTable2, #userTable3, th, td {
        text-align: center;
        padding: 12px 15px;
        font-size: 14px;
        border: 1px solid #ddd;
      }
      #userTable1, #userTable2, #userTable3, thead th {
        position: sticky; 
        top: 0;
        font-size: 14px;
        background-color: #f8f9fa;
        font-weight: 600;
        color: #333;
        border-bottom: 2px solid #dee2e6;
      }

      table {
          width: 95%;
          max-height: 120px;
          overflow-y: auto;
          border-collapse: collapse;
          margin-top: 5px;
          margin-left: auto;
          margin-right: auto; 
          position: relative;
          top: 113%;
          border-radius: 8px; 
          border: 1px solid #dee2e6;
          box-shadow: 0 2px 4px rgba(0,0,0,0.1);
      }

      th, td {
          text-align: center;
          padding: 12px 15px;
          border: 1px solid #dee2e6;
      }
      thead th {
          position: sticky; 
          top: 0;
          background-color: #f8f9fa;
          font-weight: 600;
          color: #333;
          border-bottom: 2px solid #dee2e6;
      }

      .title1 {
          align-items: center;
          margin: 30px 0;
          position: absolute;
          top: 92%;
          left: 3%;
      }
      .title1 i {
          height: 35px;
          width: 35px;
          background-color: var(--primary-color);
          border-radius: 6px;
          color: var(--title-icon-color);
          display: flex;
          align-items: center;
          justify-content: center;
          font-size: 24px;
          margin-left: 30px;
      }
      .title1 #text2 {
          position: absolute;
          width: 500%;
          font-size: 34px;
          font-weight: 500;
          color: var(--text-color);
          margin-left: 10px;
          top: -18%;
          left: 100%;
      }

      .BotSpace {
        position: absolute;
        width: 100%;
        height: 30%;
        top: 145%;
      }

      .success-modal {
        display: none;
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background-color: white;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        z-index: 1000;
        text-align: center;
      }
      .success-modal.show {
        display: block;
      }
      .modal-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0,0,0,0.5);
        z-index: 999;
      }
      .modal-overlay.show {
        display: block;
      }
      .logout-modal {
        display: none;
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background-color: white;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        z-index: 1000;
        text-align: center;
        max-width: 400px;
        width: 90%;
      }
      .logout-modal.show {
        display: block;
      }
      .logout-modal h2 {
        margin-bottom: 15px;
        color: #333;
      }
      .logout-modal p {
        margin-bottom: 20px;
        color: #666;
      }
      .logout-modal-buttons {
        display: flex;
        justify-content: center;
        gap: 10px;
      }
      .logout-modal-buttons button {
        padding: 8px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-weight: 500;
      }
      .logout-modal-buttons .cancel-btn {
        background-color: #e0e0e0;
        color: #333;
      }
      .logout-modal-buttons .confirm-btn {
        background-color: #dc3545;
        color: white;
      }
    </style>
  </head>
  <body>
    <?php if (isset($_GET['login_success'])): ?>
    <div class="modal-overlay show"></div>
    <div class="success-modal show">
        <h2>Welcome, <?php echo htmlspecialchars($admin['fullname']); ?>!</h2>
        <p>You have successfully logged in!</p>
        <button onclick="closeModal()" style="padding: 8px 16px; background-color: #4CAF50; color: white; border: none; border-radius: 4px; cursor: pointer;">OK</button>
    </div>
    <script>
        function closeModal() {
            document.querySelector('.success-modal').classList.remove('show');
            document.querySelector('.modal-overlay').classList.remove('show');
            // Remove the login_success parameter from URL
            window.history.replaceState({}, document.title, window.location.pathname);
        }
    </script>
    <?php endif; ?>

    <!-- Logout Confirmation Modal -->
    <div class="modal-overlay" id="logoutOverlay"></div>
    <div class="logout-modal" id="logoutModal">
        <h2>Confirm Logout</h2>
        <p>Are you sure you want to logout?</p>
        <div class="logout-modal-buttons">
            <button class="cancel-btn" onclick="closeLogoutModal()">Cancel</button>
            <button class="confirm-btn" onclick="confirmLogout()">Logout</button>
        </div>
    </div>

    <nav class="sidebar">
        <a href="#" class="logo">RBMS</a>
        <div class="menu-content">
            <ul class="menu-items">
            <div class="menu-title"><?php echo htmlspecialchars($admin['fullname']); ?></div>
                <li class="item">
                    <a href="#">Dashboard</a>
                </li>
                <li class="item">
                    <div class="submenu-item">
                        <span>Users</span>
                        <i class="fa-solid fa-chevron-right"></i>
                    </div>
                    <ul class="menu-items submenu">
                        <div class="menu-title">
                            <i class="fa-solid fa-chevron-left"></i>
                            User History
                        </div>
                        <li class="item">
                  <a href="../Php_Codes/AdminPage_viewuser.php">User List</a>
              </li>
              <li class="item">
                  <a href="../Php_Codes/AdminPage_deleteuser.php">Manage Users</a>
              </li>
                    </ul>
                </li>
                <li class="item">
                    <div class="submenu-item">
                        <span>Bookings & Tables</span>
                        <i class="fa-solid fa-chevron-right"></i>
                    </div>
                    <ul class="menu-items submenu">
                        <div class="menu-title">
                            <i class="fa-solid fa-chevron-left"></i>
                            Booking Preferences
                        </div>
                        <li class="item">
                            <a href="../Php_Codes/AdminPage_bookform1.php">Community Halls | Centers Booking</a>
                        </li>
                        <li class="item">
                            <a href="../Php_Codes/AdminPage_bookform2.php">Sport Facilities Booking</a>
                        </li>
                        <li class="item">
                            <a href="../Php_Codes/AdminPage_bookform3.php">Public Transportation Booking</a>
                        </li>
                    </ul>
                </li>

                <li class="item">
                  <a href="../Php_Codes/AdminPage_messages.php">Messages</a>
                </li>
            </ul>
            <ul style="margin-top: -117px;">
              <li class="item bottom1">
                <a href="#">Settings</a>
              </li>
              <li class="item bottom2">
                <a href="#" onclick="showLogoutModal(); return false;">Logout</a>
              </li>
            </ul>
        </div>
    </nav>

    <nav class="navbar">
        <i class="fa-solid fa-bars" id="sidebar-close"></i>
        <i class="fa-solid fa-user-tie" id="sidebar-admin"></i>
    </nav>

    <main class="main">
        <div class="title">
            <i class="uil uil-tachometer-fast-alt"></i>
            <span class="text" id="text1">Booking Details</span>
        </div>  

        <div class="box1">
          <i class="uil uil-home"></i>
          <span class="text">Community Halls | Centers</span>
          <p>Total Bookings: <span><?php echo $totalBookings1; ?></span></p>
        </div>
        <div class="box2">
          <i class="uil uil-trophy"></i>
          <span class="text">Sport Facilities | Equipments</span>
          <p>Total Bookings: <span><?php echo $totalBookings2; ?></span></p>
        </div>
        <div class="box3">
          <i class="uil uil-car"></i>
          <span class="text">Public Transportation</span>
          <p>Total Bookings: <span><?php echo $totalBookings3; ?></span></p>
        </div>
        <div class="box4">
          <i class="uil uil-user"></i>
          <span class="text">User Register</span>
          <p>Total Users: <span><?php echo $totalUsers; ?></span></p>
        </div>

              <div class="tables-container"> 
                <div id="table1" style="display: none;">
                  <table id="userTable1" border="1" style="text-align:center; border-color:#000;">
                      <tr>
                          <th>ID</th>
                          <th>Full Name</th>
                          <th>Email</th>
                          <th>Address</th>
                          <th>Number</th>
                          <th>Booking Preference</th>
                          <th>Reason</th>
                          <th>Date Started</th>
                          <th>Date Ended</th>
                          <th>Time Started</th>
                          <th>Time End</th>
                          <th>Others</th>
                          <th>Booking Time</th>
                      </tr>

                      <?php
                      $conn = mysqli_connect("localhost","root","","user_info");
                      if($conn->connect_error) {
                          die("Connection Failed: ".$conn->connect_error);
                      }
                      $sql = "SELECT id, fullname, email, full_address, contact_number, bookingpreference, reason, event_date_start, event_date_end, event_time_start, event_time_end, others, bookingtime FROM bookingform1 ORDER BY id";
                      $result = $conn->query($sql);

                      if($result->num_rows>0) {
                          while($row = $result->fetch_assoc()) {
                              echo"</tr><td>".$row["id"].
                              "</td><td>".$row["fullname"].
                              "</td><td>".$row["email"].
                              "</td><td>".$row["full_address"].
                              "</td><td>".$row["contact_number"].
                              "</td><td>".$row["bookingpreference"].
                              "</td><td>".$row["reason"].
                              "</td><td>".$row["event_date_start"].
                              "</td><td>".$row["event_date_end"].
                              "</td><td>".$row["event_time_start"].
                              "</td><td>".$row["event_time_end"].
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

                <div id="table2" style="display: none;">
                  <table id="userTable2" border="1" style="text-align:center; border-color:#000;">
                      <tr>
                          <th>ID</th>
                          <th>Full Name</th>
                          <th>Email</th>
                          <th>Address</th>
                          <th>Number</th>
                          <th>Booking Preference</th>
                          <th>Reason</th>
                          <th>Date Started</th>
                          <th>Date Ended</th>
                          <th>Time Started</th>
                          <th>Time End</th>
                          <th>If Sport Equipment</th>
                          <th>Others</th>
                          <th>Booking Time</th>
                      </tr>

                          <?php
                          $conn = mysqli_connect("localhost","root","","user_info");
                          if($conn->connect_error) {
                              die("Connection Failed: ".$conn->connect_error);
                          }
                          $sql = "SELECT id, fullname, email, full_address, contact_number, bookingpreference, reason, book_date_start, book_date_end, book_time_start, book_time_end, sport_equipment, others, bookingtime from bookingform2";
                          $result = $conn->query($sql);

                          if($result->num_rows>0) {
                              while($row = $result->fetch_assoc()) {
                                  echo"</tr><td>".$row["id"].
                                  "</td><td>".$row["fullname"].
                                  "</td><td>".$row["email"].
                                  "</td><td>".$row["full_address"].
                                  "</td><td>".$row["contact_number"].
                                  "</td><td>".$row["bookingpreference"].
                                  "</td><td>".$row["reason"].
                                  "</td><td>".$row["book_date_start"].
                                  "</td><td>".$row["book_date_end"].
                                  "</td><td>".$row["book_time_start"].
                                  "</td><td>".$row["book_time_end"].
                                  "</td><td>".$row["sport_equipment"].
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
          
                <div id="table3" style="display: none;">
                  <table id="userTable3" border="1" style="text-align:center; border-color:#000;">
                      <tr>
                          <th>ID</th>
                          <th>Full Name</th>
                          <th>Email</th>
                          <th>Address</th>
                          <th>Number</th>
                          <th>Vehicle Type</th>
                          <th>Reason</th>
                          <th>Pick Up Date</th>
                          <th>Pick Up Time</th>
                          <th>Destination</th>
                          <th>Days</th>
                          <th>Others</th>
                          <th>Booking Time</th>
                      </tr>

                      <?php
                      $conn = mysqli_connect("localhost","root","","user_info");
                      if($conn->connect_error) {
                          die("Connection Failed: ".$conn->connect_error);
                      }
                      $sql = "SELECT id, fullname, email, full_address, contact_number, vehicle_type, reason, pick_up_date, pick_up_time, destination, days_use, others, bookingtime from bookingform3";
                      $result = $conn->query($sql);

                      if($result->num_rows>0) {
                          while($row = $result->fetch_assoc()) {
                              echo"</tr><td>".$row["id"].
                              "</td><td>".$row["fullname"].
                              "</td><td>".$row["email"].
                              "</td><td>".$row["full_address"].
                              "</td><td>".$row["contact_number"].
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
              </div>
  

        <div class="title1">
            <i class="uil uil-clock-three"></i>
            <span class="text" id="text2">Recent Activity</span>
        </div>

        <table border="1" id="userTable" style="text-align:center; border-color:#000;">
            <tr>
              <th>ID</th>
              <th>Full Name</th>
              <th>Email</th>
              <th>Contact Number</th>
              <th>Address</th>
              <th>Password</th>
            </tr>
            <?php
            $conn = mysqli_connect("localhost","root","","user_info");
            if($conn->connect_error) {
              die("Connection Failed: ".$conn->connect_error);
            }
            $sql = "SELECT id, fullname, email, contact_number, full_address, valid_password from users";
            $result = $conn->query($sql);

            if($result->num_rows>0) {
              while($row = $result->fetch_assoc()) {
                echo "<tr id='row".$row["id"]."'>
                      <td>".$row["id"]."</td>
                      <td>".$row["fullname"]."</td>
                      <td>".$row["email"]."</td>
                      <td>".$row["contact_number"]."</td>
                      <td>".$row["full_address"]."</td>
                      <td>".$row["valid_password"]."</td>
                    </tr>";
              }
              echo"</table>";
            }
            else{
              echo"0 result";
            }

            $conn->close();
            
            ?>
          </table>

          <div class="profile-card">
            <div class="image">
            <img src="<?php echo $profileImage; ?>" alt="" class="profile-img" />

            </div>
          

            <div class="text-data">
              <div class="name"><?php echo htmlspecialchars($admin['fullname']); ?></div>

              <span class="job">Administrator</span>
            </div>
            <div class="media-buttons">
              <a href="#" style="background: #4267b2" class="link">
                <i class="bx bxl-facebook"></i>
              </a>
              <a href="#" style="background: #1da1f2" class="link">
                <i class="bx bxl-twitter"></i>
              </a>
              <a href="#" style="background: #e1306c" class="link">
                <i class="bx bxl-instagram"></i>
              </a>
              <a href="#" style="background: #ff0000" class="link">
                <i class="bx bxl-youtube"></i>
              </a>
            </div>
            <div class="buttons">
              <button class="buttonn">View More</button>
              <button class="buttonn">Edit Profile</button>
            </div>
            <div class="analytics">
              <div class="data">
                <i class="bx bx-heart"></i>
                <span class="number">1B</span>
              </div>
              <div class="data">
                <i class="bx bx-message-rounded"></i>
                <span class="number">100M</span>
              </div>
              <div class="data">
                <i class="bx bx-share"></i>
                <span class="number">7.2B</span>
              </div>
            </div>
          </div>

          <div class="BotSpace">
            <br>
          </div>



    </main>

    <script src="../Javascript_Codes/AdminPage_Dashboardscript.js"></script>
    <script>
document.addEventListener("DOMContentLoaded", () => {
    function renumberAndSortIDs() {
        const table = document.getElementById("userTable1");
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

    renumberAndSortIDs();
});
    </script>
    <script>
        function showLogoutModal() {
            document.getElementById('logoutModal').classList.add('show');
            document.getElementById('logoutOverlay').classList.add('show');
        }

        function closeLogoutModal() {
            document.getElementById('logoutModal').classList.remove('show');
            document.getElementById('logoutOverlay').classList.remove('show');
        }

        function confirmLogout() {
            window.location.href = 'admin_logout.php';
        }
    </script>
</body>
</html>