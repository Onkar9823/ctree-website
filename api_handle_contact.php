<?php

// Handle Contact Form Submission
header('Content-Type: application/json');

require_once 'db_config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $response = ['success' => false, 'message' => ''];
    
    try {
        $conn = connectDB();
        
        $full_name = trim($_POST['full_name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $subject = trim($_POST['subject'] ?? '');
        $message = trim($_POST['message'] ?? '');
        $mobile_no = trim($_POST['mobile_no'] ?? '');
        
        // Validation
        if (empty($full_name) || empty($email) || empty($message)) {
            throw new Exception("Name, email, and message are required");
        }
        
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Invalid email format");
        }
        
        // Insert contact message
        $stmt = $conn->prepare("
            INSERT INTO contacts (full_name, email_id, mobile_no, subject, message, received_at, is_read)
            VALUES (?, ?, ?, ?, ?, NOW(), 0)
        ");
        $stmt->bind_param("sssss", $full_name, $email, $mobile_no, $subject, $message);
        
        if ($stmt->execute()) {
            $response['success'] = true;
            $response['message'] = "Message sent successfully! We'll get back to you soon.";
        } else {
            throw new Exception("Failed to send message");
        }
        
        $stmt->close();
        $conn->close();
        
    } catch (Exception $e) {
        $response['message'] = $e->getMessage();
    }
    
    echo json_encode($response);
    exit;
}
?>