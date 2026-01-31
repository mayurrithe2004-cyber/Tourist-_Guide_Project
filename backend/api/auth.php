<?php
include '../config/db.php';

$method = $_SERVER['REQUEST_METHOD'];
$action = isset($_GET['action']) ? $_GET['action'] : '';

if ($method === 'POST') {
    $input = json_decode(file_get_contents("php://input"), true);
    
    if ($action === 'register') {
        // Register User
        $name = $conn->real_escape_string($input['name'] ?? '');
        $email = $conn->real_escape_string($input['email'] ?? '');
        $password = password_hash($input['password'] ?? '', PASSWORD_BCRYPT);
        $mobile = $conn->real_escape_string($input['mobile'] ?? '');
        
        if (empty($name) || empty($email) || empty($input['password'])) {
            sendResponse('error', 'All fields are required');
        }
        
        // Check if email already exists
        $check = $conn->query("SELECT id FROM users WHERE email = '$email'");
        if ($check->num_rows > 0) {
            sendResponse('error', 'Email already registered');
        }
        
        $sql = "INSERT INTO users (name, email, password, mobile, created_at) VALUES ('$name', '$email', '$password', '$mobile', NOW())";
        
        if ($conn->query($sql) === TRUE) {
            $user_id = $conn->insert_id;
            sendResponse('success', 'User registered successfully', ['id' => $user_id, 'email' => $email, 'name' => $name]);
        } else {
            sendResponse('error', 'Registration failed: ' . $conn->error);
        }
    } 
    else if ($action === 'login') {
        // Login User
        $email = $conn->real_escape_string($input['email'] ?? '');
        $password = $input['password'] ?? '';
        
        if (empty($email) || empty($password)) {
            sendResponse('error', 'Email and password required');
        }
        
        $result = $conn->query("SELECT id, name, email, password, mobile FROM users WHERE email = '$email'");
        
        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            
            if (password_verify($password, $user['password'])) {
                unset($user['password']);
                sendResponse('success', 'Login successful', $user);
            } else {
                sendResponse('error', 'Invalid password');
            }
        } else {
            sendResponse('error', 'User not found');
        }
    }
    else if ($action === 'admin-login') {
        // Admin Login
        $email = $conn->real_escape_string($input['email'] ?? '');
        $password = $conn->real_escape_string($input['password'] ?? '');
        
        if (empty($email) || empty($password)) {
            sendResponse('error', 'Email and password required');
        }
        
        $result = $conn->query("SELECT id, name, email FROM admin WHERE email = '$email' AND password = '$password'");
        
        if ($result->num_rows === 1) {
            $admin = $result->fetch_assoc();
            sendResponse('success', 'Admin login successful', $admin);
        } else {
            sendResponse('error', 'Invalid credentials');
        }
    }
} else {
    sendResponse('error', 'Invalid request method');
}
?>
