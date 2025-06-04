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
            <form action="update_password.php" method="POST">
                <input type="email" name="email" placeholder="Enter your email" required>
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
                <input type="submit" class="button" value="Update Password">
            </form>
        </div>
    </div>

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
    });
</script>
</body>
</html>