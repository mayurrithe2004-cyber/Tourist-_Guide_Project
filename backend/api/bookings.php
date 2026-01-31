<?php
include '../config/db.php';

$method = $_SERVER['REQUEST_METHOD'];
$action = isset($_GET['action']) ? $_GET['action'] : '';
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($method === 'GET') {
    if ($action === 'user' && isset($_GET['user_id'])) {
        // Get user bookings
        $user_id = intval($_GET['user_id']);
        $result = $conn->query("SELECT b.*, d.name, d.price, d.image_url FROM bookings b 
                                JOIN destinations d ON b.destination_id = d.id 
                                WHERE b.user_id = $user_id ORDER BY b.created_at DESC");
        
        if ($result) {
            $bookings = [];
            while ($row = $result->fetch_assoc()) {
                $bookings[] = $row;
            }
            sendResponse('success', 'Bookings fetched', $bookings);
        } else {
            sendResponse('error', 'Query failed');
        }
    }
    else if ($action === 'all') {
        // Get all bookings (Admin)
        $result = $conn->query("SELECT b.*, u.name as user_name, u.email, d.name as destination_name FROM bookings b 
                                JOIN users u ON b.user_id = u.id 
                                JOIN destinations d ON b.destination_id = d.id 
                                ORDER BY b.created_at DESC");
        
        if ($result) {
            $bookings = [];
            while ($row = $result->fetch_assoc()) {
                $bookings[] = $row;
            }
            sendResponse('success', 'All bookings fetched', $bookings);
        } else {
            sendResponse('error', 'Query failed');
        }
    }
}
else if ($method === 'POST') {
    // Create booking
    $input = json_decode(file_get_contents("php://input"), true);
    
    $user_id = intval($input['user_id'] ?? 0);
    $destination_id = intval($input['destination_id'] ?? 0);
    $check_in = $conn->real_escape_string($input['check_in'] ?? '');
    $check_out = $conn->real_escape_string($input['check_out'] ?? '');
    $travelers = intval($input['travelers'] ?? 1);
    $total_price = floatval($input['total_price'] ?? 0);
    
    if ($user_id <= 0 || $destination_id <= 0) {
        sendResponse('error', 'User ID and Destination ID required');
    }
    
    $sql = "INSERT INTO bookings (user_id, destination_id, check_in, check_out, travelers, total_price, status, created_at) 
            VALUES ($user_id, $destination_id, '$check_in', '$check_out', $travelers, $total_price, 'confirmed', NOW())";
    
    if ($conn->query($sql) === TRUE) {
        $booking_id = $conn->insert_id;
        sendResponse('success', 'Booking created successfully', ['id' => $booking_id]);
    } else {
        sendResponse('error', 'Failed to create booking: ' . $conn->error);
    }
}
else if ($method === 'PUT') {
    // Update booking status (Admin)
    if ($id <= 0) {
        sendResponse('error', 'Booking ID required');
    }
    
    $input = json_decode(file_get_contents("php://input"), true);
    $status = $conn->real_escape_string($input['status'] ?? 'confirmed');
    
    $sql = "UPDATE bookings SET status='$status' WHERE id=$id";
    
    if ($conn->query($sql) === TRUE) {
        sendResponse('success', 'Booking updated successfully');
    } else {
        sendResponse('error', 'Failed to update booking');
    }
}
else if ($method === 'DELETE') {
    // Cancel booking
    if ($id <= 0) {
        sendResponse('error', 'Booking ID required');
    }
    
    $sql = "UPDATE bookings SET status='cancelled' WHERE id=$id";
    
    if ($conn->query($sql) === TRUE) {
        sendResponse('success', 'Booking cancelled successfully');
    } else {
        sendResponse('error', 'Failed to cancel booking');
    }
}
else {
    sendResponse('error', 'Invalid request method');
}
?>
