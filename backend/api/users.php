<?php
include '../config/db.php';

$method = $_SERVER['REQUEST_METHOD'];
$action = isset($_GET['action']) ? $_GET['action'] : '';
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($method === 'GET') {
    if ($action === 'all') {
        // Get all users (Admin)
        $result = $conn->query("SELECT id, name, email, mobile, created_at FROM users ORDER BY id DESC");
        
        if ($result) {
            $users = [];
            while ($row = $result->fetch_assoc()) {
                $users[] = $row;
            }
            sendResponse('success', 'Users fetched', $users);
        } else {
            sendResponse('error', 'Query failed');
        }
    }
    else if ($action === 'get' && $id > 0) {
        // Get single user
        $result = $conn->query("SELECT id, name, email, mobile, created_at FROM users WHERE id=$id");
        
        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            sendResponse('success', 'User fetched', $user);
        } else {
            sendResponse('error', 'User not found');
        }
    }
}
else if ($method === 'PUT' && $id > 0) {
    // Update user profile
    $input = json_decode(file_get_contents("php://input"), true);
    
    $name = $conn->real_escape_string($input['name'] ?? '');
    $mobile = $conn->real_escape_string($input['mobile'] ?? '');
    
    $sql = "UPDATE users SET name='$name', mobile='$mobile' WHERE id=$id";
    
    if ($conn->query($sql) === TRUE) {
        sendResponse('success', 'User updated successfully');
    } else {
        sendResponse('error', 'Failed to update user');
    }
}
else if ($method === 'DELETE' && $id > 0) {
    // Delete user (Admin)
    $sql = "DELETE FROM users WHERE id=$id";
    
    if ($conn->query($sql) === TRUE) {
        sendResponse('success', 'User deleted successfully');
    } else {
        sendResponse('error', 'Failed to delete user');
    }
}
else {
    sendResponse('error', 'Invalid request');
}
?>
