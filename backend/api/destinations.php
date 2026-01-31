<?php
include '../config/db.php';

$method = $_SERVER['REQUEST_METHOD'];
$action = isset($_GET['action']) ? $_GET['action'] : '';
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($method === 'GET') {
    if ($action === 'list' || empty($action)) {
        // Get all destinations
        $result = $conn->query("SELECT id, name, location, price, description, image_url, tags, created_at FROM destinations ORDER BY id");
        
        if ($result) {
            $destinations = [];
            while ($row = $result->fetch_assoc()) {
                $row['tags'] = json_decode($row['tags'], true);
                $row['img'] = $row['image_url'];
                $row['desc'] = $row['description'];
                $destinations[] = $row;
            }
            sendResponse('success', 'Destinations fetched', $destinations);
        } else {
            sendResponse('error', 'Query failed: ' . $conn->error);
        }
    } 
    else if ($action === 'get' && $id > 0) {
        // Get single destination
        $result = $conn->query("SELECT * FROM destinations WHERE id = $id");
        
        if ($result->num_rows === 1) {
            $destination = $result->fetch_assoc();
            $destination['tags'] = json_decode($destination['tags'], true);
            sendResponse('success', 'Destination fetched', $destination);
        } else {
            sendResponse('error', 'Destination not found');
        }
    }
}
else if ($method === 'POST') {
    // Add new destination (Admin only)
    $input = json_decode(file_get_contents("php://input"), true);
    
    $name = $conn->real_escape_string($input['name'] ?? '');
    $location = $conn->real_escape_string($input['location'] ?? '');
    $price = intval($input['price'] ?? 0);
    $description = $conn->real_escape_string($input['desc'] ?? '');
    $image_url = $conn->real_escape_string($input['img'] ?? 'assets/img14.avif');
    $tags = isset($input['tags']) ? $conn->real_escape_string(json_encode($input['tags'])) : '[]';
    
    if (empty($name) || empty($location) || $price <= 0) {
        sendResponse('error', 'All fields required and price must be > 0');
    }
    
    $sql = "INSERT INTO destinations (name, location, price, description, image_url, tags, created_at) 
            VALUES ('$name', '$location', $price, '$description', '$image_url', '$tags', NOW())";
    
    if ($conn->query($sql) === TRUE) {
        sendResponse('success', 'Destination added successfully', ['id' => $conn->insert_id]);
    } else {
        sendResponse('error', 'Failed to add destination: ' . $conn->error);
    }
}
else if ($method === 'PUT') {
    // Update destination (Admin only)
    if ($id <= 0) {
        sendResponse('error', 'Destination ID required');
    }
    
    $input = json_decode(file_get_contents("php://input"), true);
    
    $name = $conn->real_escape_string($input['name'] ?? '');
    $location = $conn->real_escape_string($input['location'] ?? '');
    $price = intval($input['price'] ?? 0);
    $description = $conn->real_escape_string($input['desc'] ?? '');
    $image_url = $conn->real_escape_string($input['img'] ?? '');
    $tags = isset($input['tags']) ? $conn->real_escape_string(json_encode($input['tags'])) : '[]';
    
    $sql = "UPDATE destinations SET name='$name', location='$location', price=$price, description='$description'";
    if (!empty($image_url)) {
        $sql .= ", image_url='$image_url'";
    }
    $sql .= ", tags='$tags' WHERE id=$id";
    
    if ($conn->query($sql) === TRUE) {
        sendResponse('success', 'Destination updated successfully');
    } else {
        sendResponse('error', 'Failed to update destination: ' . $conn->error);
    }
}
else if ($method === 'DELETE') {
    // Delete destination (Admin only)
    if ($id <= 0) {
        sendResponse('error', 'Destination ID required');
    }
    
    $sql = "DELETE FROM destinations WHERE id=$id";
    
    if ($conn->query($sql) === TRUE) {
        sendResponse('success', 'Destination deleted successfully');
    } else {
        sendResponse('error', 'Failed to delete destination: ' . $conn->error);
    }
}
else {
    sendResponse('error', 'Invalid request method');
}
?>
