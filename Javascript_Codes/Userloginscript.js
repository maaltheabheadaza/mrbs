const container = document.querySelector(".container"),
      pwShowHide = document.querySelectorAll(".showHidePw"),
      pwFields = document.querySelectorAll(".password"),
      signUpLinks = document.querySelectorAll(".signup-link"),
      loginLinks = document.querySelectorAll(".login-link"),
      forgotLinks = document.querySelectorAll(".forgot-link"),
      forgotForm = document.querySelector(".form.forgot");

    pwShowHide.forEach(eyeIcon =>{
        eyeIcon.addEventListener("click", ()=>{
            pwFields.forEach(pwField =>{
                if(pwField.type ==="password"){
                    pwField.type = "text";

                    pwShowHide.forEach(icon =>{
                        icon.classList.replace("uil-eye-slash", "uil-eye");
                    })
                }else{
                    pwField.type = "password";

                    pwShowHide.forEach(icon =>{
                        icon.classList.replace("uil-eye", "uil-eye-slash");
                    })
                }
            }) 
        })
    })

    // Signup link
    signUpLinks.forEach(link => {
        link.addEventListener("click", (e) => {
            if (e) e.preventDefault();
            container.classList.remove("login-active", "forgot-active");
            container.classList.add("signup-active");
        });
    });
    // Login link (from signup or forgot)
    loginLinks.forEach(link => {
        link.addEventListener("click", (e) => {
            if (e) e.preventDefault();
            container.classList.remove("signup-active", "forgot-active");
            container.classList.add("login-active");
        });
    });
    // Forgot password link
    forgotLinks.forEach(link => {
        link.addEventListener("click", (e) => {
            if (e) e.preventDefault();
            container.classList.remove("login-active", "signup-active");
            container.classList.add("forgot-active");
        });
    });
    // Back to login from forgot form (all .login-link in forgot form)
    document.querySelectorAll(".form.forgot .login-link").forEach(link => {
        link.addEventListener("click", (e) => {
            if (e) e.preventDefault();
            container.classList.remove("forgot-active", "signup-active");
            container.classList.add("login-active");
        });
    });

    // Forgot password form submit
    const forgotPasswordForm = document.getElementById('forgotPasswordForm');
    if (forgotPasswordForm) {
        forgotPasswordForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const email = this.forgot_email.value.trim();
            const newPassword = this.forgot_new_password.value;
            const confirmPassword = this.forgot_confirm_password.value;
            // Validate email
            if (!email.match(/^\S+@\S+\.\S+$/)) {
                Swal.fire({
                    icon: "error",
                    title: "Invalid Email",
                    text: "Please enter a valid email address.",
                    confirmButtonColor: "#009688"
                });
                return;
            }
            // Validate passwords match
            if (newPassword !== confirmPassword) {
                Swal.fire({
                    icon: "error",
                    title: "Password Mismatch",
                    text: "The passwords do not match. Please try again.",
                    confirmButtonColor: "#009688"
                });
                return;
            }
            // AJAX call to update_password.php
            fetch('../Php_Codes/update_password.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `email=${encodeURIComponent(email)}&new_password=${encodeURIComponent(newPassword)}&confirm_password=${encodeURIComponent(confirmPassword)}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: "success",
                        title: "Password Updated!",
                        text: data.message,
                        confirmButtonColor: "#009688"
                    }).then(() => {
                        container.classList.remove("forgot-active", "signup-active");
                        container.classList.add("login-active");
                    });
                } else {
                    Swal.fire({
                        icon: "error",
                        title: "Update Failed",
                        text: data.message,
                        confirmButtonColor: "#009688"
                    });
                }
            })
            .catch(error => {
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "An error occurred. Please try again.",
                    confirmButtonColor: "#009688"
                });
            });
        });
    }

    // Login form submit with SweetAlert
    const loginForm = document.getElementById('loginForm');
    if (loginForm) {
        loginForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            fetch('../Php_Codes/user_login.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: "success",
                        title: "Login Successful!",
                        text: data.message,
                        confirmButtonColor: "#009688"
                    }).then(() => {
                        window.location.href = data.redirect;
                    });
                } else {
                    let title = "Login Failed";
                    if (data.error === 'recaptcha_failed') title = "reCAPTCHA Failed";
                    else if (data.error === 'wrong_password' || data.error === 'wrong_email') title = "Incorrect Email or Password";
                    Swal.fire({
                        icon: "error",
                        title: title,
                        text: data.message,
                        confirmButtonColor: "#009688"
                    });
                }
            })
            .catch(error => {
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "An error occurred. Please try again.",
                    confirmButtonColor: "#009688"
                });
            });
        });
    }