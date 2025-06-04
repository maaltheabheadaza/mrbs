<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="../Css_Codes/BookForm2style.css">
    <link rel="icon" href="../Images/icon.png" type="image/png">
   <title>Sport Facilities Form </title>
    <style>
        /* Loading Overlay */
        .loading-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            z-index: 9999;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }

        .loading-spinner {
            width: 50px;
            height: 50px;
            border: 5px solid #f3f3f3;
            border-top: 5px solid #009688;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        .loading-text {
            color: white;
            margin-top: 15px;
            font-size: 18px;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
  <div>
    <button type="button" id="back"><span id="spanBtn"></span><a href="../Php_Codes/BookingPage.php"><i class="fas fa-arrow-left"></i></a></button>
  </div>
    <div class="container">
        <header>Sport Facilities Booking Form</header>

        <!-- Loading Overlay -->
        <div class="loading-overlay">
            <div class="loading-spinner"></div>
            <div class="loading-text">Processing your booking...</div>
        </div>

        <form action="../Php_Codes/BookForm2_process.php" method="POST" onsubmit="showLoading()">
            <div class="form first">
                <div class="details personal">
                    <span class="title">Personal Details</span>
        
                    <div class="fields">
                        <div class="input-field">
                            <label>Full Name</label>
                            <input type="text" name="fullname" placeholder="Enter your name" required>
                        </div>
        
                        <div class="input-field">
                            <label>Email</label>
                            <input type="email" name="email" placeholder="Enter your email" required>
                        </div>
        
                        <div class="input-field">
                            <label>Address</label>
                            <input type="text" name="full_address" placeholder="Enter your address" required>
                        </div>
        
                        <div class="input-field">
                            <label>Mobile Number</label>
                            <input type="number" name="contact_number" placeholder="Enter mobile number" required>
                        </div>
                    </div>
                </div>
        
                <div class="details ID">
                    <span class="title">Booking Details</span>
        
                    <div class="fields">
                        <div class="input-field">
                            <label>Book Preference</label>
                            <select name="bookingpreference" required>
                                <option disabled selected>Select Sport Facility</option>
                                <?php
                                $servername = "localhost"; 
                                $username = "root";       
                                $password = "";          
                                $dbname = "user_info"; 

                                $conn = new mysqli($servername, $username, $password, $dbname);

                                if ($conn->connect_error) {
                                    die("Connection failed: " . $conn->connect_error);
                                }

                                $sql = "SELECT preference FROM booking_preferences2";
                                $result = $conn->query($sql);

                                if ($result->num_rows > 0) {
                                    while($row = $result->fetch_assoc()) {
                                        echo '<option value="' . $row['preference'] . '">' . $row['preference'] . '</option>';
                                    }
                                }

                                $conn->close();
                                ?>
                            </select>
                        </div>
        
                        <div class="input-field">
                            <label>Reason for Booking</label>
                            <select name="reason" required>
                                <option disabled selected>State a Reason</option>
                                <option value="Game">Game</option>
                                <option value="Practice">Practice</option>
                                <option value="Event">Event</option>
                                <option value="Activity">Activity</option>
                                <option value="Others">Others</option>
                            </select>
                        </div>
        
                        <div class="input-field">
                            <label>Book Date Start</label>
                            <input type="date" name="book_date_start" required>
                        </div>
        
                        <div class="input-field">
                            <label>Book Date End</label>
                            <input type="date" name="book_date_end" required>
                        </div>
        
                        <div class="input-field">
                            <label>Time Start</label>
                            <input type="time" name="book_time_start" required>
                        </div>
        
                        <div class="input-field">
                            <label>Time End</label>
                            <input type="time" name="book_time_end" required>
                        </div> 
        
                        <div class="input-field">
                            <label>If Sport Equipment  <p>*State equipment | quantity | Type N/A if none</p></label>
                            <textarea name="sport_equipment"></textarea>
                        </div> 
        
                        <div class="input-field">
                            <label>If Others  <p>*State Another Reasons | Type N/A if none</p></label>
                            <textarea name="others" ></textarea>
                        </div> 
        
                        <div class="input-field terms">
                            <input type="checkbox" id="terms" name="terms">
                            <label id="labelterms" for="terms">I agree to the terms and conditions</label>
                        </div>
                    </div>
        
                    <button type="submit" class="submit">
                        <span class="btnText">Submit</span>
                        <i class="uil uil-navigator"></i>
                    </button>
                </div> 
            </div>
        </form>
    </div>

    <!-- Add Modal for Holiday Notification -->
    <div id="holidayModal" class="modal" style="display: none; position: fixed; text-align: center; z-index: 1; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgba(0,0,0,0.4);">
        <div class="modal-content" style="background-color: #fefefe; margin: 15% auto; padding: 20px; border: 1px solid #888; width: 80%; max-width: 500px; border-radius: 5px; position: relative;">
            <span class="close" style="color: #aaa; float: right; font-size: 28px; font-weight: bold; cursor: pointer;">&times;</span>
            <h2 style="color: #333; margin-bottom: 20px;">Holiday Notice</h2>
            <p id="holidayMessage" style="margin-bottom: 20px; color: #666;"></p>
            <button onclick="closeHolidayModal()" style="background-color: #009688; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer;">Choose Another Date</button>
        </div>
    </div>

    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        const form = document.querySelector("form");
        const allInput = form.querySelectorAll(".first input");
        const startDateInput = document.querySelector('input[name="book_date_start"]');
        const endDateInput = document.querySelector('input[name="book_date_end"]');
        const modal = document.getElementById("holidayModal");
        const closeBtn = document.getElementsByClassName("close")[0];
        const loadingOverlay = document.querySelector('.loading-overlay');

        function showHolidayModal(message) {
            document.getElementById("holidayMessage").innerHTML = message;
            modal.style.display = "block";
        }

        function closeHolidayModal() {
            modal.style.display = "none";
        }

        // When the user clicks on <span> (x), close the modal
        closeBtn.onclick = closeHolidayModal;

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
            if (event.target == modal) {
                closeHolidayModal();
            }
        }

        async function checkHoliday(date) {
            try {
                const response = await fetch(`../Php_Codes/check_holiday.php?date=${date}`, {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json'
                    }
                });
                return await response.json();
            } catch (error) {
                console.error('Error checking holiday:', error);
                return null;
            }
        }

        async function validateDates() {
            const startDate = startDateInput.value;
            const endDate = endDateInput.value;
            const startTime = document.querySelector('input[name="book_time_start"]').value;
            const endTime = document.querySelector('input[name="book_time_end"]').value;

            // Check if end date is before start date
            if (startDate && endDate && startDate > endDate) {
                alert("End date must be after start date");
                return false;
            }

            // If dates are the same, check if end time is after start time
            if (startDate === endDate && startTime && endTime && startTime >= endTime) {
                alert("End time must be after start time");
                return false;
            }

            if (startDate && endDate) {
                const [startHoliday, endHoliday] = await Promise.all([
                    checkHoliday(startDate),
                    checkHoliday(endDate)
                ]);

                let warningMessage = '';
                if (startHoliday.isHoliday) {
                    warningMessage += `Warning: Start date (${startDate}) is a holiday: ${startHoliday.name} (${startHoliday.type})\n`;
                }
                if (endHoliday.isHoliday) {
                    warningMessage += `Warning: End date (${endDate}) is a holiday: ${endHoliday.name} (${endHoliday.type})\n`;
                }

                if (warningMessage) {
                    showHolidayModal(warningMessage + '\nDo you want to proceed with the booking?');
                    return false;
                }
            }
            return true;
        }

        function showLoading() {
            loadingOverlay.style.display = 'flex';
        }

        function hideLoading() {
            loadingOverlay.style.display = 'none';
        }

        form.addEventListener("submit", async function(e) {
            e.preventDefault();
            let isValid = true;
            allInput.forEach(input => {
                if(input.hasAttribute('required') && !input.value) {
                    isValid = false;
                }
            });
            const termsChecked = document.getElementById('terms').checked;
            if (!termsChecked) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Terms Required',
                    text: 'You must agree to the terms and conditions before submitting.'
                });
                return;
            }
            if(isValid) {
                try {
                    showLoading();
                    const holidayCheck = await validateDates();
                    hideLoading();
                    if (holidayCheck) {
                        // Gather booking details
                        const formData = new FormData(form);
                        let detailsHtml = `<ul style='text-align:left;'>`;
                        formData.forEach((value, key) => {
                            if(key !== 'terms') detailsHtml += `<li><b>${key.replace(/_/g, ' ')}:</b> ${value}</li>`;
                        });
                        detailsHtml += `</ul>`;
                        
                        const result = await Swal.fire({
                            title: 'Confirm Your Booking',
                            html: detailsHtml,
                            showCancelButton: true,
                            confirmButtonText: 'Confirm',
                            cancelButtonText: 'Back',
                            confirmButtonColor: '#009688'
                        });

                        if (result.isConfirmed) {
                            showLoading();
                            form.submit();
                        }
                    }
                } catch (error) {
                    hideLoading();
                    console.error('Error during form submission:', error);
                    Swal.fire('Error', 'There was an error checking holiday dates. Please try again.', 'error');
                }
            } else {
                form.classList.remove('secActive');
                Swal.fire('Missing Fields', 'Please fill in all required fields.', 'warning');
            }
        });

        // Add event listeners to date inputs to check for holidays on change
        [startDateInput, endDateInput].forEach(input => {
            input.addEventListener('change', async function() {
                if (this.value) {
                    const holidayInfo = await checkHoliday(this.value);
                    if (holidayInfo.isHoliday) {
                        showHolidayModal(`The selected date (${this.value}) is a ${holidayInfo.type}: ${holidayInfo.name}<br><br>Please select another date for your booking.`);
                        this.value = ''; // Clear the date input
                    }
                }
            });
        });
    </script>
</body>
</html>