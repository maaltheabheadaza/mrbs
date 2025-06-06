<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: ../Html_Codes/adminlogin.html");
    exit();
}
$admin = $_SESSION['admin'];
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Administration Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" />
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200">
    <link rel="stylesheet" type="text/css" href="../Css_Codes/AdminPage_messagesstyle.css">
    <link rel="icon" href="../Images/admin.png" type="image/png">
    <style>
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
      table {
        width: 95%;
        border-collapse: collapse;
        margin: 20px auto;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
      }

      th, td {
        text-align: center;
        padding: 12px 15px;
        border: 1px solid #dee2e6;
      }

      thead th {
        background-color: #f8f9fa;
        font-weight: 600;
        color: #333;
        border-bottom: 2px solid #dee2e6;
      }

      tbody tr:nth-child(even) {
        background-color: #f8f9fa;
      }

      tbody tr:hover {
        background-color: #f2f2f2;
      }

      .delete-row {
        color: #dc3545;
        text-decoration: none;
        padding: 5px 10px;
        border-radius: 4px;
        transition: background-color 0.3s;
      }

      .delete-row:hover {
        background-color: #dc3545;
        color: white;
      }
    </style>
  </head>
  <body>
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
          <div class="menu-title"><?php echo htmlspecialchars($admin['fullname']); ?>
          </div>

          <li class="item">
            <a href="../Php_Codes/AdminPage_Dashboard.php">Dashboard</a>
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
              <span>Bookings & Tables
              </span>
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
            <a href="#">Messages</a>
          </li>

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
    </nav>

    <main class="main">
        <div class="title">
            <i class="uil uil-envelope"></i>
            <span class="text" id="text1">Messages</span>
        </div> 

        <div class="search-box">
          <a href="#"><i class="uil uil-search"></i></a>
          <input type="text" id="searchInput" placeholder="Search here...">
      </div>

        <div class="dropdown">
            <span>Sort Options</span>
            <div class="dropdown-content">
              <a href="#" data-sort="ascending">Ascending</a>
              <a href="#" data-sort="descending">Descending</a>
          </div>
        </div>

        <table id="userTable" border="1" style="text-align:center; border-color:#000;">
          <tr>
              <th>ID</th>
              <th>Full Name</th>
              <th>Email</th>
              <th>Messages</th>
              <th>Time Sent</th>
              <th>Action</th>
          </tr>
  
          <?php
          $conn = mysqli_connect("localhost","root","","user_info");
          if($conn->connect_error) {
              die("Connection Failed: ".$conn->connect_error);
          }
          $sql = "SELECT id, fullname, email, messages, time_sent from contact_us";
          $result = $conn->query($sql);
  
          if($result->num_rows>0) {
              while($row = $result->fetch_assoc()) {
                  echo"</tr><td>".$row["id"].
                  "</td><td>".$row["fullname"].
                  "</td><td>".$row["email"].
                  "</td><td>".$row["messages"].
                  "</td><td>".$row["time_sent"].
                  '<td><a href="#" class="delete-row" data-id="'.$row["id"].'"><i class="fas fa-trash-alt"></i></a></td>';
              }
              echo"</table>";
          }
          else{
              echo"0 result";
          }
  
          $conn->close();

        
          ?>
      </table>

    </main>

    <script src="../Javascript_Codes/AdminPage_messagesscript.js"></script>
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