<?php

// Handle Student Login
header('Content-Type: application/json');
session_start();

require_once 'db_config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $response = ['success' => false, 'message' => ''];
    
    try {
        $conn = connectDB();
        
        $email_or_id = trim($_POST['email_or_id'] ?? '');
        $password = $_POST['password'] ?? '';
        
        if (empty($email_or_id) || empty($password)) {
            throw new Exception("Email/ID and password are required");
        }
        
        // Check if input is email or user ID
        $is_email = filter_var($email_or_id, FILTER_VALIDATE_EMAIL);
        
        if ($is_email) {
            $stmt = $conn->prepare("SELECT user_id, full_name, email_id, password_hash, role FROM users WHERE email_id = ?");
        } else {
            $stmt = $conn->prepare("SELECT user_id, full_name, email_id, password_hash, role FROM users WHERE user_id = ?");
        }
        
        $stmt->bind_param("s", $email_or_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 0) {
            throw new Exception("User not found");
        }
        
        $user = $result->fetch_assoc();
        
        if (!password_verify($password, $user['password_hash'])) {
            throw new Exception("Invalid password");
        }
        
        // Login successful - set session
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['full_name'] = $user['full_name'];
        $_SESSION['email_id'] = $user['email_id'];
        $_SESSION['role'] = $user['role'];
        
        $response['success'] = true;
        $response['message'] = "Login successful";
        $response['redirect'] = "dashboard.php";
        
        $stmt->close();
        $conn->close();
        
    } catch (Exception $e) {
        $response['message'] = $e->getMessage();
    }
    
    echo json_encode($response);
    exit;
}
?>