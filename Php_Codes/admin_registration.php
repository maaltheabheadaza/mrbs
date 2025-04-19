<?php
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

    // Handle image upload
    $imageUrl = null;
    if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === UPLOAD_ERR_OK) {
        $uploadResult = $cloudinary->uploadApi()->upload($_FILES['profile_image']['tmp_name'], [
            'folder' => 'admin_profiles'
        ]);
        $imageUrl = $uploadResult['secure_url'];
    }

    $conn = new mysqli('localhost', 'root', '', 'user_info');
    if($conn->connect_error) {
        die("Connection Failed: " .$conn->connect_error);
    } else {
        $stmt = $conn->prepare("INSERT into admin (fullname, email, contact_number, valid_password, profile_image)
         VALUES (?, ?, ?, ?, ?)");

        $stmt->bind_param("ssiss", $fullname, $email, $contactNumber, $password, $imageUrl);

        $stmt->execute();
        echo '<script>alert("Register Successfully!");</script>';
        echo '<script>window.location.href = "../Html_Codes/adminlogin.html";</script>';

        $stmt->close();
        $conn->close();
    }   
?>