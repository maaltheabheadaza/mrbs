<?php
// Start session to ensure admin is logged in
session_start();
if (!isset($_SESSION['admin'])) {
    die(json_encode(['success' => false, 'message' => 'Unauthorized access']));
}

require_once __DIR__ . '/../auth_api.php';

// Database connection
$conn = mysqli_connect("localhost", "root", "", "user_info");
if ($conn->connect_error) {
    die(json_encode(['success' => false, 'message' => 'Connection failed: ' . $conn->connect_error]));
}

// Check if ID was provided
if (!isset($_POST['id'])) {
    die(json_encode(['success' => false, 'message' => 'No ID provided']));
}

$id = intval($_POST['id']);

// Get the user's email first
$get_email_sql = "SELECT email FROM users WHERE id = ?";
$stmt = $conn->prepare($get_email_sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
if (!$result || $result->num_rows === 0) {
    echo json_encode(['success' => false, 'message' => 'User not found']);
    $conn->close();
    exit;
}
$user = $result->fetch_assoc();
$email = $user['email'];
$stmt->close();

// Call external API to delete user
$auth_api = new UserAuthAPI('ak_9b668ca54c3669ef57fe218fa4f51773');
$apiResponse = $auth_api->deleteUserByEmail($email);
if ($apiResponse['status'] !== 200 || !isset($apiResponse['data']['success']) || !$apiResponse['data']['success']) {
    echo json_encode([
        'success' => false,
        'message' => 'Failed to delete user in external API: ' . ($apiResponse['data']['message'] ?? 'Unknown error')
    ]);
    $conn->close();
    exit;
}

// Start transaction
mysqli_begin_transaction($conn);

try {
    // Delete the user locally
    $delete_sql = "DELETE FROM users WHERE id = ?";
    $stmt = $conn->prepare($delete_sql);
    $stmt->bind_param("i", $id);
    if (!$stmt->execute()) {
        throw new Exception("Error deleting user");
    }
    $stmt->close();

    // Resequence the IDs
    $resequence_sql = "SET @count = 0; 
                      UPDATE users SET id = @count:= @count + 1 ORDER BY id;
                      ALTER TABLE users AUTO_INCREMENT = 1;";
    if (!$conn->multi_query($resequence_sql)) {
        throw new Exception("Error resequencing IDs");
    }
    while ($conn->more_results() && $conn->next_result());

    // Get updated user list
    $select_sql = "SELECT id, fullname, email, contact_number, full_address, valid_password FROM users ORDER BY id";
    $result = $conn->query($select_sql);
    $users = [];
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }

    // Commit transaction
    mysqli_commit($conn);
    echo json_encode([
        'success' => true,
        'message' => 'User deleted successfully',
        'users' => $users
    ]);
} catch (Exception $e) {
    // Rollback transaction on error
    mysqli_rollback($conn);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}

$conn->close();
?>