<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'Unauthorized access']);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $conn = mysqli_connect("localhost", "root", "", "user_info");
    
    if ($conn->connect_error) {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Database connection failed']);
        exit();
    }
    
    // Start transaction
    $conn->begin_transaction();
    
    try {
        $id = mysqli_real_escape_string($conn, $_POST['id']);
        
        // Delete the user
        $sql = "DELETE FROM users WHERE id = '$id'";
        if (!$conn->query($sql)) {
            throw new Exception("Error deleting user");
        }
        
        // Get all remaining users with ID greater than deleted ID
        $sql = "SELECT id FROM users WHERE id > '$id' ORDER BY id";
        $result = $conn->query($sql);
        
        // Update IDs to maintain sequence
        $newId = $id;
        while ($row = $result->fetch_assoc()) {
            $oldId = $row['id'];
            $updateSql = "UPDATE users SET id = '$newId' WHERE id = '$oldId'";
            if (!$conn->query($updateSql)) {
                throw new Exception("Error updating IDs");
            }
            $newId++;
        }
        
        // Reset auto increment value
        $sql = "ALTER TABLE users AUTO_INCREMENT = 1";
        $conn->query($sql);
        
        // Commit transaction
        $conn->commit();
        
        // Get updated user list
        $sql = "SELECT id, fullname, email, contact_number, full_address, valid_password FROM users ORDER BY id";
        $result = $conn->query($sql);
        $users = [];
        while ($row = $result->fetch_assoc()) {
            $users[] = $row;
        }
        
        header('Content-Type: application/json');
        echo json_encode(['success' => true, 'users' => $users]);
        
    } catch (Exception $e) {
        $conn->rollback();
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
    
    $conn->close();
} else {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
}
?>