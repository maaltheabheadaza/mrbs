<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="../Css_Codes/BookForm1style.css">
    <title>Community Halls | Centers Booking Form</title>
</head>
<body>
    <div>
        <button type="button" id="back"><span id="spanBtn"></span><a href="../Html_Codes/BookingPage.html"><i class="fas fa-arrow-left"></i></a></button>
    </div>
    <div class="container">
        <header>Community Halls | Centers Booking Form</header>

        <form action="../Php_Codes/BookForm1_process.php" method="post">
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
                            <input type="text" name="contact_number" placeholder="Enter mobile number" required>
                        </div>
                    </div>
                </div>
                <div class="details ID">
                    <span class="title">Booking Details</span>
                    <div class="fields">
                        <div class="input-field">
                            <label>Book Preference</label>
                            <select name="bookingpreference" required>
                                <option disabled selected>Select Halls | Centers</option>
                                <?php
                                // Include the PHP script to fetch options
                                $servername = "localhost"; // Change to your server name
                                $username = "root";        // Change to your database username
                                $password = "";            // Change to your database password
                                $dbname = "user_info"; // Change to your database name

                                $conn = new mysqli($servername, $username, $password, $dbname);

                                if ($conn->connect_error) {
                                    die("Connection failed: " . $conn->connect_error);
                                }

                                $sql = "SELECT preference FROM booking_preferences1";
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
                                <option>Gathering</option>
                                <option>Meeting</option>
                                <option>Event</option>
                                <option>Activity</option>
                                <option>Others</option>
                            </select>
                        </div>
                        <div class="input-field">
                            <label>Event Date Start</label>
                            <input type="date" name="event_date_start" required>
                        </div>
                        <div class="input-field">
                            <label>Event Date End</label>
                            <input type="date" name="event_date_end" required>
                        </div>
                        <div class="input-field">
                            <label>Event Time Start</label>
                            <input type="time" name="event_time_start" required>
                        </div>
                        <div class="input-field">
                            <label>Event Time End</label>
                            <input type="time" name="event_time_end" required>
                        </div> 
                        <div class="input-field">
                            <label>If Others  <p>*State Another Reasons | Type N/A if none</p></label>
                            <textarea name="others" id="othertext" required></textarea>
                        </div> 
                        <div class="input-field terms">
                            <input type="checkbox" id="terms" required>
                            <label id="labelterms" for="terms">I agree to the terms and conditions</label>
                        </div>
                    </div>
                    <button class="submit" type="submit">
                        <span class="btnText">Submit</span>
                        <i class="uil uil-navigator"></i>
                    </button>
                </div> 
            </div>
        </form>
    </div>

    <script>
        const form = document.querySelector("form");
        const allInput = form.querySelectorAll(".first input");

        form.addEventListener("submit", function(e) {
            let isValid = true;
            
            // Check if all required fields are filled
            allInput.forEach(input => {
                if(input.hasAttribute('required') && !input.value) {
                    isValid = false;
                }
            });

            if(isValid) {
                form.classList.add('secActive');
            } else {
                e.preventDefault();
                form.classList.remove('secActive');
                alert("Please fill in all required fields.");
            }
        });
    </script>
</body>
</html>
