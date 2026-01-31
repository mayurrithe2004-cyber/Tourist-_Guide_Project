<?php
include '../config/db.php';

$method = $_SERVER['REQUEST_METHOD'];
$action = isset($_GET['action']) ? $_GET['action'] : '';

if ($method === 'GET' && isset($_GET['user_id'])) {
    // Get user wishlist
    $user_id = intval($_GET['user_id']);
    $result = $conn->query("SELECT d.* FROM wishlist w 
                            JOIN destinations d ON w.destination_id = d.id 
                            WHERE w.user_id = $user_id ORDER BY w.created_at DESC");
    
    if ($result) {
        $wishlist = [];
        while ($row = $result->fetch_assoc()) {
            $row['tags'] = json_decode($row['tags'], true);
            $row['img'] = $row['image_url'];
            $row['desc'] = $row['description'];
            $wishlist[] = $row;
        }
        sendResponse('success', 'Wishlist fetched', $wishlist);
    } else {
        sendResponse('error', 'Query failed');
    }
}
else if ($method === 'POST') {
    // Add to wishlist
    $input = json_decode(file_get_contents("php://input"), true);
    
    $user_id = intval($input['user_id'] ?? 0);
    $destination_id = intval($input['destination_id'] ?? 0);
    
    if ($user_id <= 0 || $destination_id <= 0) {
        sendResponse('error', 'User ID and Destination ID required');
    }
    
    // Check if already in wishlist
    $check = $conn->query("SELECT id FROM wishlist WHERE user_id=$user_id AND destination_id=$destination_id");
    if ($check->num_rows > 0) {
        sendResponse('error', 'Already in wishlist');
    }
    
    $sql = "INSERT INTO wishlist (user_id, destination_id, created_at) VALUES ($user_id, $destination_id, NOW())";
    
    if ($conn->query($sql) === TRUE) {
        sendResponse('success', 'Added to wishlist');
    } else {
        sendResponse('error', 'Failed to add to wishlist');
    }
}
else if ($method === 'DELETE' && isset($_GET['user_id']) && isset($_GET['dest_id'])) {
    // Remove from wishlist
    $user_id = intval($_GET['user_id']);
    $dest_id = intval($_GET['dest_id']);
    
    $sql = "DELETE FROM wishlist WHERE user_id=$user_id AND destination_id=$dest_id";
    
    if ($conn->query($sql) === TRUE) {
        sendResponse('success', 'Removed from wishlist');
    } else {
        sendResponse('error', 'Failed to remove from wishlist');
    }
}
else {
    sendResponse('error', 'Invalid request');
}
?>
