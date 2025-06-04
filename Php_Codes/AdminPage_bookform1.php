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
    <link rel="stylesheet" href="../Css_Codes/AdminPage_bookform1style.css">
    <link rel="icon" href="../Images/admin.png" type="image/png">

    <style>
      
    .table-container {
        width: 95%;
        height: 60%;
        overflow: auto;
        border: none; 
        margin-top: 5px;
        margin-left: auto;
        margin-right: auto; 
        position: absolute;
        top: 25%;
        left: 25px;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
      }

      table {
        overflow-y: auto;
        border-collapse: collapse;
        margin-right: auto; 
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        border: 1px solid #dee2e6;
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

      .BotSpace {
        position: absolute;
        width: 100%;
        height: 60%;
        top: 70%;
        z-index: 0;
        pointer-events: none;
      }

      .title2 {
          align-items: center;
          margin: 30px 0;
          position: absolute;
          top: 92%;
          left: 3%;
      }
      .title2 i {
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
      .title2 #text3 {
          position: absolute;
          width: 800%;
          font-size: 34px;
          font-weight: 500;
          color: var(--text-color);
          margin-left: 10px;
          top: -18%;
          left: 100%;
      }

      #addbook{
        position: absolute;
        top: 93%;
        right: 90px;
        width: 180px;
        height: 50px;
        margin-top: 25px;
        border-radius: 20px;
        border: none;
        outline: none;
        background-color:#009688;
        z-index: 1;
        cursor: pointer;
      }
      #addbook:hover{
        background-color: green;
        transition: all ease 0.3s;
        cursor: pointer;
      }

      .wrapper{
        display: none; /* Initially hide the wrapper */
        position: fixed;
        width: 40%;
        height: 50%;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background: #fff;
        border-radius: 7px;
        padding: 20px 25px 15px;
        box-shadow: 0 15px 40px rgba(0,0,0,0.12);
        z-index: 2;
      }
      .wrapper header h1{
        font-size: 27px;
        font-weight: 500;
      }
      .wrapper header p{
        margin-top: 5px;
        font-size: 18px;
        color: #474747;
      }
      .wrapper form{
        margin: 20px 0 27px;
      }
      .wrapper form input{
        width: 100%;
        height: 60px;
        outline: none;
        padding: 10px 17px;
        font-size: 19px;
        border-radius: 5px;
        border: 1px solid #b3b2b2;
        transition: 0.1s ease;
      }
      .wrapper form input::placeholder{
        color: #b3b2b2;
      }
      .wrapper form input:focus{
        box-shadow: 0 3px 6px rgba(0,0,0,0.13);
      }
      .wrapper form input[type="submit"]{
        width: 100%;
        border: none;
        outline: none;
        color: #fff;
        cursor: pointer;
        font-size: 17px;
        margin-top: 20px;
        padding: 15px 0;
        border-radius: 5px;
        background: #009688;
        transition: background-color ease 0.3s;
        z-index: 3;
      }
      form input[type="submit"]:hover {
        background-color: green;
      }

      .table-container1 {
        width: 95%;
        height: 60%;
        overflow: auto;
        border: none; 
        margin-top: 5px;
        margin-left: auto;
        margin-right: auto; 
        position: absolute;
        top: 105%;
        left: 35px;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
      }

      #UserTable4 {
        overflow-y: auto;
        border-collapse: collapse;
        margin-right: auto; 
        top: 0;
        left: 0;
        width: 100%;
        border: 1px solid #dee2e6;
      }

      #UserTable4 th, td {
        text-align: center;
        padding: 12px 15px;
        border: 1px solid #dee2e6;
      }
      #UserTable4 thead th {
        position: sticky; 
        padding: 12px 15px;
        top: 0;
        background-color: #f8f9fa;
        font-weight: 600;
        color: #333;
        border-bottom: 2px solid #dee2e6;
      }
      #userTable4 td.editable span {
        border: 1px solid black;
        width: 150px;
        padding: 2px 4px;
        display: inline-block;
      }

      /* Add column width specifications */
      #userTable4 th:nth-child(1), 
      #userTable4 td:nth-child(1) {
        width: 10%;
      }
      #userTable4 th:nth-child(2), 
      #userTable4 td:nth-child(2) {
        width: 100%;
        min-width: 300px;
      }
      #userTable4 th:nth-child(3), 
      #userTable4 td:nth-child(3) {
        width: 20%;
        min-width: 100px;
      }
      #userTable4 td.editable span {
        width: 100%;
        min-width: 300px;
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
                <a href="#">Community Halls | Centers Booking</a>
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
            <i class="uil uil-tachometer-fast-alt"></i>
            <span class="text" id="text1">Community Halls | Center Booking History</span>
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

        <div class="table-container">
        <table id="userTable" border="1" style="text-align:center; border-color:#000;">
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
            <th>Status</th>
            <th>Action</th>
        </tr>

        <?php
        $conn = mysqli_connect("localhost","root","","user_info");
        if($conn->connect_error) {
            die("Connection Failed: ".$conn->connect_error);
        }
        $sql = "SELECT id, fullname, email, full_address, contact_number, bookingpreference, reason, event_date_start, event_date_end, event_time_start, event_time_end, others, bookingtime, status from bookingform1";
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
                "</td><td>".$row["bookingtime"].
                "</td><td><span class='status-badge status-".strtolower($row["status"] ?? 'pending')."'>".ucfirst($row["status"] ?? 'pending')."</span></td>".
                '<td style="display:flex;gap:8px;justify-content:center;align-items:center;">';
                if (($row["status"] ?? 'pending') === 'pending') {
                    echo '<a href="#" class="approve-booking" data-id="'.$row["id"].'" data-type="hall" title="Approve"><i class="fas fa-check-circle" style="color:green;font-size:20px;"></i></a>';
                    echo '<a href="#" class="decline-booking" data-id="'.$row["id"].'" data-type="hall" title="Decline"><i class="fas fa-times-circle" style="color:red;font-size:20px;"></i></a>';
                }
                echo '<a href="#" class="delete-row" data-id="'.$row["id"].'" title="Delete"><i class="fas fa-trash-alt" style="color:#888;font-size:18px;"></i></a>';
                echo '</td>';
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
    <div class="BotSpace">
            <br>
          </div>

          <div class="title2">
            <i class="uil uil-book"></i>
            <span class="text" id="text3">Add Booking Preferences</span>
        </div>

        <button id="addbook">Add Booking Preference</button>

        <div class="wrapper" id="bookingFormWrapper">
      <header>
        <h1>Add Booking Preference</h1>
        <p>Add only if approved by the Municipality</p>
      </header>
      <form action="add_booking_preference1.php" method="POST">
        <input type="text" name="booking_preference" placeholder="Add Booking Preference" required><br><br>
        <input type="submit" id="button" value="Add Booking Preference"></input>
      </form>
    </div>

    <div class="table-container1">
    <table id="userTable4" border="1" style="text-align:center; border-color:#000;">
  <tr>
    <th>ID</th>
    <th>Booking Preference</th>
    <th>Action</th>
  </tr>

  <?php
  $conn = mysqli_connect("localhost", "root", "", "user_info");
  if ($conn->connect_error) {
      die("Connection Failed: " . $conn->connect_error);
  }
  $sql = "SELECT id, preference FROM booking_preferences1";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
          echo "<tr data-id='" . $row["id"] . "'>
                  <td>" . $row["id"] . "</td>
                  <td class='editable' data-field='preference'><span>" . $row["preference"] . "</span></td>
                  <td>
                      <a href='#' class='save-btn' style='margin-right:15px;'><i class='fa-solid fa-floppy-disk'></i></a>
                      <a href='#' class='delete-row' data-id='" . $row["id"] . "'><i class='fas fa-trash-alt'></i></a>
                  </td>
                </tr>";
      }
  } else {
      echo "<tr><td colspan='3'>0 result</td></tr>";
  }

  $conn->close();
  ?>
</table>


      
    
    </main>

    <script src="../Javascript_Codes/AdminPage_bookform1script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
      document.addEventListener("DOMContentLoaded", function () {
        const addButton = document.getElementById("addbook");
        const bookingFormWrapper = document.getElementById("bookingFormWrapper");

        addButton.addEventListener("click", function () {
          bookingFormWrapper.style.display = "block";
        });

        document.addEventListener("click", function (event) {
          if (!bookingFormWrapper.contains(event.target) && event.target !== addButton) {
            bookingFormWrapper.style.display = "none";
          }
        });
      });

      // Remove all existing delete event listeners first
      document.querySelectorAll('.delete-row').forEach(item => {
          const newItem = item.cloneNode(true);
          item.parentNode.replaceChild(newItem, item);
      });

      // Add new event listeners
      document.querySelectorAll('.delete-row').forEach(item => {
          item.onclick = function(e) {
              e.preventDefault();
              e.stopPropagation();
              const row = this.closest('tr');
              const id = this.dataset.id;
              
              if (confirm('Are you sure you want to delete this booking?')) {
                  fetch('../Php_Codes/delete_preference1.php?id=' + id, { method: 'DELETE' })
                      .then(response => {
                          if (response.ok) {
                              row.remove();
                              const rows = document.querySelectorAll('#userTable4 tr');
                              rows.forEach((row, index) => {
                                  if (index > 0) {
                                      row.cells[0].textContent = index;
                                  }
                              });
                          } else {
                              alert('Failed to delete booking.');
                          }
                      })
                      .catch(error => alert('Failed to delete booking.'));
              }
              return false;
          };
      });

      document.querySelectorAll('#userTable4 tr[data-id]').forEach(row => {
        row.querySelectorAll('.editable').forEach(cell => {
          cell.addEventListener('click', () => {
            if (!cell.hasAttribute('contenteditable')) {
              cell.setAttribute('contenteditable', 'true');
              cell.focus();
              row.querySelector('.save-btn').style.display = 'inline-block';
            }
          });
        });

        row.querySelector('.save-btn').addEventListener('click', () => {
          const id = row.dataset.id;
          const preference = row.querySelectorAll('.editable')[0].innerText.trim();

          fetch('update_preference1.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ id, preference })
          })
          .then(res => res.text())
          .then(msg => {
          
            row.querySelectorAll('.editable').forEach(cell => cell.removeAttribute('contenteditable'));
            row.querySelector('.save-btn').style.display = 'none';
          });
        });
      });

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

        document.querySelectorAll('.approve-booking').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const id = this.dataset.id;
                Swal.fire({
                    title: 'Approve this booking?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Approve',
                    cancelButtonText: 'Cancel',
                    confirmButtonColor: '#009688',
                }).then(result => {
                    if (result.isConfirmed) {
                        updateStatus(id, 'hall', 'approved', this);
                    }
                });
            });
        });
        document.querySelectorAll('.decline-booking').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const id = this.dataset.id;
                Swal.fire({
                    title: 'Decline this booking?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Decline',
                    cancelButtonText: 'Cancel',
                    confirmButtonColor: '#d33',
                }).then(result => {
                    if (result.isConfirmed) {
                        updateStatus(id, 'hall', 'declined', this);
                    }
                });
            });
        });
        function updateStatus(id, type, newStatus, btn) {
            fetch('updateBookingStatus.php', {
                method: 'POST',
                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                body: `booking_id=${id}&booking_type=${type}&new_status=${newStatus}`
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    const row = btn.closest('tr');
                    const statusCell = row.querySelector('td:nth-last-child(2) .status-badge');
                    statusCell.textContent = newStatus.charAt(0).toUpperCase() + newStatus.slice(1);
                    statusCell.className = 'status-badge status-' + newStatus;
                    btn.parentElement.querySelectorAll('.approve-booking, .decline-booking').forEach(el => el.remove());
                    Swal.fire({icon:'success',title:'Status updated!',timer:1200,showConfirmButton:false});
                } else {
                    Swal.fire({icon:'error',title:'Error',text:data.message||'Failed to update status'});
                }
            });
        }
    </script>
  </body>
</html>