<?php
session_start();
if (isset($_GET['reset_token'])) {
    $_SESSION['reset_token'] = $_GET['reset_token'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <link rel="stylesheet" type="text/css" href="../Css_Codes/ForgetPassstyle.css">
    <link rel="icon" href="../Images/admin.png" type="image/png">
    <title>Update Password</title>
</head>
<body>
    <div class="container">
        <div class="registration form">
            <header>Forget Password</header>
            <?php if (isset($_GET['email'])): ?>
            <div style="margin-bottom: 18px; color: #444; font-size: 1.05em; text-align: center;">
                An OTP has been sent to <b><?php echo htmlspecialchars($_GET['email']); ?></b>.<br>
                Please enter the OTP you received in your email, along with your new password, to reset your password.
            </div>
            <?php endif; ?>
            <form id="resetPasswordForm" action="update_password.php" method="POST" onsubmit="return validatePasswordStrength();">
                <input type="hidden" name="email" value="<?php echo isset($_GET['email']) ? htmlspecialchars($_GET['email']) : ''; ?>">

                <div class="password-input">
                    <input type="password" name="new_password" placeholder="Create a new password" required>
                    <i class="fas fa-eye" id="togglePassword1"></i>
                    <i class="fas fa-eye-slash" id="togglePassword1Slash" style="display: none;"></i>
                </div>
                <div class="password-input">
                    <input type="password" name="confirm_password" placeholder="Confirm new password" required>
                    <i class="fas fa-eye" id="togglePassword2"></i>
                    <i class="fas fa-eye-slash" id="togglePassword2Slash" style="display: none;"></i>
                </div>
                <div class="otp-input">
                    <input type="text" name="otp" placeholder="Enter OTP (6-digit) or reset token from your email" required>
                    <div style="font-size: 0.95em; color: #666; margin-top: 4px;">Enter the 6-digit OTP <b>or</b> the reset token from your email, if provided.</div>
                </div>
                <div id="passwordError" style="color: #d32f2f; margin-bottom: 12px; display: none;"></div>
                <input type="submit" class="button" value="Update Password">
            </form>
        </div>
    </div>

    <script>
    function validatePasswordStrength() {
        var password = document.querySelector('input[name="new_password"]').value;
        var confirmPassword = document.querySelector('input[name="confirm_password"]').value;
        var errorDiv = document.getElementById('passwordError');
        errorDiv.style.display = 'none';
        errorDiv.textContent = '';

        var minLength = 8;
        var uppercase = /[A-Z]/;
        var lowercase = /[a-z]/;
        var number = /[0-9]/;
        var special = /[!@#$%^&*(),.?":{}|<>\[\]\\/~`_+=;'\-]/;

        if (password.length < minLength) {
            errorDiv.textContent = 'Password must be at least 8 characters.';
            errorDiv.style.display = 'block';
            return false;
        }
        if (!uppercase.test(password)) {
            errorDiv.textContent = 'Password must contain at least one uppercase letter.';
            errorDiv.style.display = 'block';
            return false;
        }
        if (!lowercase.test(password)) {
            errorDiv.textContent = 'Password must contain at least one lowercase letter.';
            errorDiv.style.display = 'block';
            return false;
        }
        if (!number.test(password)) {
            errorDiv.textContent = 'Password must contain at least one number.';
            errorDiv.style.display = 'block';
            return false;
        }
        if (!special.test(password)) {
            errorDiv.textContent = 'Password must contain at least one special character (!@#$%^&* etc.).';
            errorDiv.style.display = 'block';
            return false;
        }
        if (password !== confirmPassword) {
            errorDiv.textContent = 'Passwords do not match.';
            errorDiv.style.display = 'block';
            return false;
        }
        return true;
    }
    </script>

    <style>
      #loadingOverlay2 {
        display: none;
        position: fixed;
        top: 0; left: 0; width: 100vw; height: 100vh;
        background: rgba(0,0,0,0.5);
        z-index: 99999;
        align-items: center;
        justify-content: center;
      }
      #loadingOverlay2 .loader-box {
        background: #fff;
        padding: 30px 40px;
        border-radius: 10px;
        box-shadow: 0 8px 32px rgba(0,0,0,0.2);
        text-align: center;
        font-size: 1.2em;
        color: #009688;
        display: flex;
        flex-direction: column;
        align-items: center;
      }
      #loadingOverlay2 .spinner {
        border: 4px solid #f3f3f3;
        border-top: 4px solid #009688;
        border-radius: 50%;
        width: 40px;
        height: 40px;
        animation: spin 1s linear infinite;
        margin-bottom: 18px;
      }
      @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
      }
    </style>
    <div id="loadingOverlay2">
      <div class="loader-box">
        <div class="spinner"></div>
        <span>Processing your password reset...</span>
      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const passwordInputs = document.querySelectorAll('.password-input input[type="password"]');
        passwordInputs.forEach(function(input) {
            const toggleEye = input.nextElementSibling;
            toggleEye.addEventListener('click', function() {
                const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
                input.setAttribute('type', type);
                toggleEye.classList.toggle('fa-eye-slash');
            });
        });

        const form = document.getElementById('resetPasswordForm');
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            document.getElementById('loadingOverlay2').style.display = 'flex';
            const formData = new FormData(form);
            fetch('update_password.php', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                credentials: 'same-origin'
            })
            .then(response => response.json())
            .then(data => {
                document.getElementById('loadingOverlay2').style.display = 'none';
                if (data.success) {
                    Swal.fire({
                        icon: "success",
                        title: "Password Updated!",
                        text: data.message,
                        confirmButtonColor: "#009688"
                    }).then(() => {
                        window.location.href = "../Html_Codes/Userlogin.html";
                    });
                } else {
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: data.message || 'Unknown error',
                        confirmButtonColor: "#009688"
                    });
                }
            })
            .catch(error => {
                document.getElementById('loadingOverlay2').style.display = 'none';
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "An error occurred. Please try again.",
                    confirmButtonColor: "#009688"
                });
            });
        });
    });
    </script>

    <?php
    // Debug log for email and reset_token from GET
    if (isset($_GET['email']) || isset($_GET['reset_token'])) {
        error_log('ForgetPass.php GET email: ' . (isset($_GET['email']) ? $_GET['email'] : 'none'));
        error_log('ForgetPass.php GET reset_token: ' . (isset($_GET['reset_token']) ? $_GET['reset_token'] : 'none'));
    }
    ?>
</body>
</html>