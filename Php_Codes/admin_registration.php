<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

    require __DIR__ . '/../vendor/autoload.php';
    use Cloudinary\Cloudinary;
    use Dotenv\Dotenv;

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
    $password = $_POST['valid_password'];

    // Hash the password for security
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Handle image upload
    $imageUrl = null;
    if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === UPLOAD_ERR_OK) {
        try {
            $uploadResult = $cloudinary->uploadApi()->upload($_FILES['profile_image']['tmp_name'], [
                'folder' => 'admin_profiles'
            ]);
            $imageUrl = $uploadResult['secure_url'];
        } catch (Exception $e) {
            echo '<script>alert("Image upload failed: ' . addslashes($e->getMessage()) . '");</script>';
            echo '<script>window.location.href = "../Html_Codes/adminlogin.html";</script>';
            exit();
        }
    }

    $conn = new mysqli('localhost', 'root', '', 'user_info');
    if($conn->connect_error) {
        die("Connection Failed: " .$conn->connect_error);
    } else {
        // Insert NULL for id (auto-increment if set), or remove id if not needed
        $stmt = $conn->prepare("INSERT INTO admin (id, fullname, email, contact_number, valid_password, profile_image) VALUES (NULL, ?, ?, ?, ?, ?)");
        if (!$stmt) {
            echo '<script>alert("Database error: ' . addslashes($conn->error) . '");</script>';
            echo '<script>window.location.href = "../Html_Codes/adminlogin.html";</script>';
            $conn->close();
            exit();
        }
        $stmt->bind_param("sssss", $fullname, $email, $contactNumber, $hashedPassword, $imageUrl);
        if ($stmt->execute()) {
            echo '<script>alert("Register Successfully!");</script>';
            echo '<script>window.location.href = "../Html_Codes/adminlogin.html";</script>';
        } else {
            echo '<script>alert("Registration failed: ' . addslashes($stmt->error) . '");</script>';
            echo '<script>window.location.href = "../Html_Codes/adminlogin.html";</script>';
        }
        $stmt->close();
        $conn->close();
    }   
?>