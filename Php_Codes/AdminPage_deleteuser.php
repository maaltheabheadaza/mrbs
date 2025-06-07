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
    <link rel="stylesheet" type="text/css" href="../Css_Codes/AdminPage_deleteuserstyle.css">
    <link rel="stylesheet" type="text/css" href="../Css_Codes/AdminPage_searchuserstyle.css">
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
      .table-responsive {
        width: 100%;
        overflow-x: auto;
      }
      table {
        min-width: 900px;
      }
      /* Limit width of Password column */
      #userTable th:nth-child(6),
      #userTable td:nth-child(6) {
        max-width: 180px;
        width: 180px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
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
            <i class="uil uil-trash"></i>
            <span class="text" id="text1">Delete User</span>
        </div> 

        <div class="search-box">
                <a href="#"><i class="uil uil-search"></i></a>
                <input type="text" id="searchInput" placeholder="Search here...">
        </div>
         
        <div class="table-responsive">
        <table border="1" id="userTable" style="text-align:center; border-color:#000; min-width: 900px;">
            <tr>
              <th>ID</th>
              <th>Full Name</th>
              <th>Email</th>
              <th>Contact Number</th>
              <th>Address</th>
              <th>Password</th>
              <th>Action</th>
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
                      <td><a href='javascript:void(0)' class='delete-row' data-id='".$row["id"]."'><i class='fas fa-trash-alt'></i></a></td>
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
        </div>

    </main>
    <script src="../Javascript_Codes/AdminPage_searchuserscript.js"></script>
    <script src="../Javascript_Codes/AdminPage_deleteuserscript.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Add click event listeners to all delete buttons
            document.querySelectorAll('.delete-row').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const userId = this.getAttribute('data-id');
                    
                    if (confirm('Are you sure you want to delete this user?')) {
                        const formData = new FormData();
                        formData.append('id', userId);

                        fetch('delete_user.php', {
                            method: 'POST',
                            body: formData
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // Clear existing table content except header
                                const table = document.getElementById('userTable');
                                const headerRow = table.rows[0];
                                table.innerHTML = '';
                                table.appendChild(headerRow);
                                
                                // Rebuild table with updated data
                                data.users.forEach(user => {
                                    const row = table.insertRow();
                                    
                                    // Insert cells
                                    [
                                        user.id,
                                        user.fullname,
                                        user.email,
                                        user.contact_number,
                                        user.full_address,
                                        user.valid_password
                                    ].forEach(text => {
                                        const cell = row.insertCell();
                                        cell.textContent = text;
                                    });
                                    
                                    // Add delete button
                                    const actionCell = row.insertCell();
                                    actionCell.innerHTML = `<a href="javascript:void(0)" class="delete-row" data-id="${user.id}"><i class="fas fa-trash-alt"></i></a>`;
                                });
                                
                                // Reattach event listeners to new delete buttons
                                attachDeleteListeners();
                                
                                // Show success message
                                alert('User deleted successfully');
                            } else {
                                alert('Error deleting user: ' + data.message);
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('Error deleting user. Please try again.');
                        });
                    }
                });
            });
        });

        // Function to attach delete event listeners to new buttons
        function attachDeleteListeners() {
            document.querySelectorAll('.delete-row').forEach(button => {
                button.addEventListener('click', function(e) {
                    // Remove existing event listener
                    const newButton = button.cloneNode(true);
                    button.parentNode.replaceChild(newButton, button);
                    
                    // Add the click event to the new button
                    newButton.addEventListener('click', function(e) {
                        e.preventDefault();
                        const userId = this.getAttribute('data-id');
                        
                        if (confirm('Are you sure you want to delete this user?')) {
                            const formData = new FormData();
                            formData.append('id', userId);

                            fetch('delete_user.php', {
                                method: 'POST',
                                body: formData
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    // Clear existing table content except header
                                    const table = document.getElementById('userTable');
                                    const headerRow = table.rows[0];
                                    table.innerHTML = '';
                                    table.appendChild(headerRow);
                                    
                                    // Rebuild table with updated data
                                    data.users.forEach(user => {
                                        const row = table.insertRow();
                                        
                                        // Insert cells
                                        [
                                            user.id,
                                            user.fullname,
                                            user.email,
                                            user.contact_number,
                                            user.full_address,
                                            user.valid_password
                                        ].forEach(text => {
                                            const cell = row.insertCell();
                                            cell.textContent = text;
                                        });
                                        
                                        // Add delete button
                                        const actionCell = row.insertCell();
                                        actionCell.innerHTML = `<a href="javascript:void(0)" class="delete-row" data-id="${user.id}"><i class="fas fa-trash-alt"></i></a>`;
                                    });
                                    
                                    // Reattach event listeners to new delete buttons
                                    attachDeleteListeners();
                                    
                                    // Show success message
                                    alert('User deleted successfully');
                                } else {
                                    alert('Error deleting user: ' + data.message);
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                alert('Error deleting user. Please try again.');
                            });
                        }
                    });
                });
            });
        }

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