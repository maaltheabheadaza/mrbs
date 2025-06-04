<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Resources Now</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="../Css_Codes/BookingPagestyle.css?v=2">
    <link rel="icon" href="../Images/icon.png" type="image/png">
    <style>
        .footer {
            padding: 30px 0;
            background-color: #009688;
            display: block;
            flex-direction: column;
            position: absolute;
            top: 100vh;
            width: 100%;
        
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

          #viewBook{
            width:300px;
            padding: 15px 0;
            text-align:center;
            margin:20 px 10 px;
            border-radius:25px;
            font-weight:bold;
            border: 2px solid #009688;
            background: transparent;
            color:#fff;
            cursor: pointer;
            position: absolute;
            overflow: hidden;
            top: 5%;
            right: 20px;
          }
          #viewspan{
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
          #viewBook:hover #viewspan{
            width: 100%;
          }
          #viewBook:hover{
            border: none;
          }
          
    </style>
</head>
<body>
    <div class="card-list">
        <a href="../Html_Codes/BookForm1.php" class="card-item">
            <img alt="Card Image" src="../Images/communityhalls.jpg">
            <span class="developer">Community Halls | Centers Booking Form</span>
            <h3>For options like Events, Meetings, Gatherings and etc.</h3>
            <div class="arrow">
                <i class="fas fa-arrow-right card-icon"></i>
            </div>
        </a>
        <a href="../Html_Codes/BookForm2.php" class="card-item">
            <img alt="Card Image" src="../Images/sportfacilities.jpg">
            <span class="designer">Sports Facilities</span>
            <h3>For options like Courts, Fields/Oval, Pools, Gymnasium and etc.</h3>
            <div class="arrow">
                <i class="fas fa-arrow-right card-icon"></i>
            </div>
        </a>
        <a href="../Html_Codes/BookForm3.php" class="card-item">
            <img alt="Card Image" src="../Images/publictransport.jpg">
            <span class="editor">Public Transportation</span>
            <h3>For options like Selecting Routes,Type of Vehicle, and etc.</h3>
            <div class="arrow">
                <i class="fas fa-arrow-right card-icon"></i>
            </div>
        </a>
    </div>

    <div style="position: absolute; top: 30px; right: 40px; display: flex; align-items: center; gap: 18px; z-index: 100;">
      <button type="button" id="viewBook" style="position: static; margin: 0;"><span id="viewspan"></span><a href="../Php_Codes/checkAvailability.php" style="text-decoration: none; color:white">View Booking Details</a></button>
      <div id="userProfileContainer" style="position: relative;">
        <div id="userIcon" style="cursor: pointer; width: 48px; height: 48px; border-radius: 50%; background: #fff; display: flex; align-items: center; justify-content: center; box-shadow: 0 2px 8px rgba(0,0,0,0.12); transition: box-shadow 0.2s;">
          <i class="fas fa-user" style="font-size: 28px; color: #009688;"></i>
        </div>
        <div id="userProfilePopup" style="display: none; position: absolute; top: 60px; right: 0; min-width: 320px; background: #fff; border-radius: 16px; box-shadow: 0 8px 32px rgba(0,0,0,0.18); padding: 28px 24px 16px 24px; z-index: 2000; transition: opacity 0.2s;">
          <div style="position: absolute; top: 16px; right: 16px; cursor: pointer;" id="logoutIcon" title="Logout">
            <i class="fas fa-sign-out-alt" style="font-size: 22px; color: #e74c3c;"></i>
          </div>
          <div style="display: flex; flex-direction: column; align-items: center; margin-top: 10px;">
            <img id="profileImage" src="../Images/default-user.png" alt="Profile Image" style="width: 80px; height: 80px; border-radius: 50%; object-fit: cover; box-shadow: 0 2px 8px rgba(0,0,0,0.10); margin-bottom: 12px; border: 3px solid #009688;">
            <div style="font-size: 1.2em; font-weight: bold; color: #222; margin-bottom: 4px;" id="profileName">Loading...</div>
            <div style="font-size: 1em; color: #555; margin-bottom: 4px;" id="profileEmail">Loading...</div>
            <div style="font-size: 0.95em; color: #888; margin-bottom: 18px; text-align: center;" id="profileAddress">Loading...</div>
            <button id="viewHistoryBtn" style="background: linear-gradient(90deg, #009688 60%, #26a69a 100%); color: #fff; border: none; border-radius: 22px; padding: 10px 32px; font-size: 1em; font-weight: 600; box-shadow: 0 2px 8px rgba(0,0,0,0.10); cursor: pointer; margin-top: 8px; transition: background 0.2s;">View your book history</button>
          </div>
        </div>
      </div>
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

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Prevent back button after logout
        window.addEventListener('load', function() {
            // Clear browser history
            window.history.pushState(null, '', window.location.href);
            
            // Add event listener for popstate
            window.addEventListener('popstate', function() {
                window.history.pushState(null, '', window.location.href);
            });
        });

        function handleLogout(event) {
            event.preventDefault();
            
            // Show loading state
            const button = document.getElementById('back');
            button.style.pointerEvents = 'none';
            
            // Call logout endpoint
            fetch('../Php_Codes/logout.php')
                .then(response => response.json())
                .then(data => {
                    // Show notification
                    const notification = document.createElement('div');
                    notification.style.cssText = `
                        position: fixed;
                        top: 20px;
                        right: 20px;
                        background: #2ecc71;
                        color: white;
                        padding: 15px 25px;
                        border-radius: 8px;
                        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
                        z-index: 1000;
                        animation: slideIn 0.5s ease-out;
                    `;
                    notification.textContent = data.message;
                    document.body.appendChild(notification);

                    // Add animation keyframes
                    const style = document.createElement('style');
                    style.textContent = `
                        @keyframes slideIn {
                            from {
                                transform: translateX(100%);
                                opacity: 0;
                            }
                            to {
                                transform: translateX(0);
                                opacity: 1;
                            }
                        }
                    `;
                    document.head.appendChild(style);

                    // Remove notification after 3 seconds
                    setTimeout(() => {
                        notification.style.animation = 'slideOut 0.5s ease-out';
                        setTimeout(() => {
                            notification.remove();
                            // Clear history and redirect to homepage
                            window.history.pushState(null, '', '../Html_Codes/Homepage.html');
                            window.location.replace('../Html_Codes/Homepage.html');
                        }, 500);
                    }, 3000);
                })
                .catch(error => {
                    console.error('Error:', error);
                    button.style.pointerEvents = 'auto';
                });
        }

        // User Profile Popup Logic
        const userIcon = document.getElementById('userIcon');
        const userProfilePopup = document.getElementById('userProfilePopup');
        let profileLocked = false;

        userIcon.addEventListener('mouseenter', () => {
          if (!profileLocked) userProfilePopup.style.display = 'block';
        });
        userIcon.addEventListener('mouseleave', () => {
          if (!profileLocked) userProfilePopup.style.display = 'none';
        });
        userIcon.addEventListener('click', () => {
          profileLocked = !profileLocked;
          userProfilePopup.style.display = profileLocked ? 'block' : 'none';
        });
        document.addEventListener('click', (e) => {
          if (!userProfilePopup.contains(e.target) && !userIcon.contains(e.target)) {
            profileLocked = false;
            userProfilePopup.style.display = 'none';
          }
        });

        // Fetch user info via AJAX
        fetch('../Php_Codes/getUserProfile.php')
          .then(res => res.json())
          .then(data => {
            if (data.success) {
              document.getElementById('profileName').textContent = data.fullname;
              document.getElementById('profileEmail').textContent = data.email;
              document.getElementById('profileAddress').textContent = data.full_address;
              document.getElementById('profileImage').src = data.profile_image || '../Images/default-user.png';
            } else {
              document.getElementById('profileName').textContent = 'Unknown User';
              document.getElementById('profileEmail').textContent = '';
              document.getElementById('profileAddress').textContent = '';
            }
          });

        // View history button
        document.getElementById('viewHistoryBtn').onclick = function() {
          window.location.href = '../Php_Codes/viewBookingHistory.php';
        };

        // Logout icon logic
        document.getElementById('logoutIcon').onclick = function(e) {
          e.stopPropagation();
          Swal.fire({
            title: 'Are you sure you want to logout?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#009688',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, logout',
            background: '#fff',
            color: '#222',
          }).then((result) => {
            if (result.isConfirmed) {
              fetch('../Php_Codes/logout.php')
                .then(response => response.json())
                .then(data => {
                  Swal.fire({
                    title: 'Logged out!',
                    text: data.message || 'You have been logged out.',
                    icon: 'success',
                    confirmButtonColor: '#009688',
                    timer: 1500,
                    showConfirmButton: false
                  });
                  setTimeout(() => {
                    window.location.href = '../Html_Codes/Homepage.html';
                  }, 1500);
                });
            }
          });
        };
    </script>
</body>
</html>