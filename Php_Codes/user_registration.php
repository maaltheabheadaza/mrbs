<?php
    require __DIR__ . '/../vendor/autoload.php';
    use Cloudinary\Cloudinary;
    use Dotenv\Dotenv;
    use Google\Client;
    use Google\Service\Gmail;
    use Google\Service\Gmail\Message;

    // Load environment variables
    $dotenv = Dotenv::createImmutable(__DIR__ . '/..');
    $dotenv->load();

    // Configure Cloudinary directly
    $cloudinary = new Cloudinary([
        'cloud' => [
            'cloud_name' => $_ENV['CLOUDINARY_CLOUD_NAME'],
            'api_key' => $_ENV['CLOUDINARY_API_KEY'],
            'api_secret' => $_ENV['CLOUDINARY_API_SECRET']
        ]
    ]);

    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $contactNumber = $_POST['contact_number'];
    $address = $_POST['full_address'];
    $password = $_POST['valid_password'];
    $confirmPassword = $_POST['confirm_password'];

    // Check if passwords match
    if ($password !== $confirmPassword) {
        header('Content-Type: application/json');
        echo json_encode([
            'success' => false,
            'message' => 'Passwords do not match!',
            'error' => 'password_mismatch'
        ]);
        exit;
    }

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $conn = new mysqli('localhost', 'root', '', 'user_info');
    if($conn->connect_error) {
        die("Connection Failed: " .$conn->connect_error);
    } else {
        // Check if email already exists
        $checkEmail = $conn->prepare("SELECT email FROM users WHERE email = ?");
        $checkEmail->bind_param("s", $email);
        $checkEmail->execute();
        $result = $checkEmail->get_result();
        
        if($result->num_rows > 0) {
            // Email already exists
            error_log("Email exists check: Email " . $email . " already exists in database");
            header('Content-Type: application/json');
            echo json_encode([
                'success' => false,
                'message' => 'Email already exists!',
                'error' => 'email_exists'
            ]);
            $checkEmail->close();
            $conn->close();
            exit;
        }
        error_log("Email exists check: Email " . $email . " is available");
        $checkEmail->close();

        // Handle image upload
        $imageUrl = null;
        if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === UPLOAD_ERR_OK) {
            $uploadResult = $cloudinary->uploadApi()->upload($_FILES['profile_image']['tmp_name'], [
                'folder' => 'user_profiles'
            ]);
            $imageUrl = $uploadResult['secure_url'];
        }

        $stmt = $conn->prepare("INSERT into users (fullname, email, contact_number, full_address, valid_password, profile_image)
         VALUES (?, ?, ?, ?, ?, ?)");

        $stmt->bind_param("ssisss", $fullname, $email, $contactNumber, $address, $hashedPassword, $imageUrl);

        $stmt->execute();

        // Send confirmation email using Gmail API
        try {
            // Create Gmail API client
            $client = new Client();
            $client->setAuthConfig(__DIR__ . '/../credentials.json');
            $client->addScope(Gmail::GMAIL_SEND);
            $client->setRedirectUri('http://localhost/mrbs/Php_Codes/oauth2callback.php');
            $client->setAccessType('offline');
            $client->setPrompt('consent');
            
            // Load token from file
            $tokenPath = __DIR__ . '/../token.json';
            if (file_exists($tokenPath)) {
                $accessToken = json_decode(file_get_contents($tokenPath), true);
                $client->setAccessToken($accessToken);
            }

            // If we don't have a token or it's expired, redirect to OAuth flow
            if (!$client->getAccessToken() || $client->isAccessTokenExpired()) {
                if ($client->getRefreshToken()) {
                    $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
                    file_put_contents($tokenPath, json_encode($client->getAccessToken()));
                } else {
                    // Redirect to OAuth flow
                    $auth_url = $client->createAuthUrl();
                    header('Location: ' . filter_var($auth_url, FILTER_SANITIZE_URL));
                    exit;
                }
            }

            // Create Gmail service
            $service = new Gmail($client);

            // Build the email headers and body
            $from = $_ENV['GMAIL_USERNAME'];
            $to = $email; // recipient's email from registration form
            $subject = 'Registration Confirmation';
            $body = "Dear " . htmlspecialchars($fullname) . ",<br><br>"
                  . "Thank you for registering with the Municipality Resource Booking System!<br><br>"
                  . "Your account has been successfully created. You can now log in to access our services.<br><br>"
                  . "Best regards,<br>MRBS Team";

            $rawMessage = "From: Municipality Resource Booking System <{$from}>\r\n";
            $rawMessage .= "To: {$fullname} <{$to}>\r\n";
            $rawMessage .= "Subject: =?utf-8?B?" . base64_encode($subject) . "?=\r\n";
            $rawMessage .= "MIME-Version: 1.0\r\n";
            $rawMessage .= "Content-Type: text/html; charset=utf-8\r\n";
            $rawMessage .= "Content-Transfer-Encoding: base64\r\n\r\n";
            $rawMessage .= base64_encode($body);

            $message = new Message();
            $message->setRaw(strtr(base64_encode($rawMessage), ['+' => '-', '/' => '_'])); // Gmail API safe encoding

            // Send email
            $service->users_messages->send('me', $message);
        } catch (Exception $e) {
            // Log the error
            error_log('Gmail API Error: ' . $e->getMessage());
        }

        $stmt->close();
        $conn->close();

        // Check if the request is AJAX
        if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            // Set JSON content type header
            header('Content-Type: application/json');
            // Return JSON response for AJAX request
            echo json_encode([
                'success' => true,
                'message' => 'Registration successful!',
                'redirect' => '../Html_Codes/Userlogin.html'
            ]);
        } else {
            // For non-AJAX requests, redirect directly
            header('Location: ../Html_Codes/Userlogin.html');
            exit;
        }
    }   
?>