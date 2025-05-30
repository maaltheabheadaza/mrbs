<?php
// Start session to ensure admin is logged in
session_start();
if (!isset($_SESSION['admin'])) {
    die(json_encode(['success' => false, 'message' => 'Unauthorized access']));
}

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

// Start transaction
mysqli_begin_transaction($conn);

try {
    // Delete the user
    $delete_sql = "DELETE FROM users WHERE id = ?";
    $stmt = $conn->prepare($delete_sql);
    $stmt->bind_param("i", $id);
    
    if (!$stmt->execute()) {
        throw new Exception("Error deleting user");
    }

    // Resequence the IDs
    $resequence_sql = "SET @count = 0; 
                      UPDATE users SET id = @count:= @count + 1 ORDER BY id;
                      ALTER TABLE users AUTO_INCREMENT = 1;";
    
    if (!$conn->multi_query($resequence_sql)) {
        throw new Exception("Error resequencing IDs");
    }

    // Wait for all queries to finish
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