<?php

// Handle Student Registration
header('Content-Type: application/json');

require_once 'db_config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $response = ['success' => false, 'message' => ''];
    
    try {
        $conn = connectDB();
        
        // Get form data
        $full_name = trim($_POST['full_name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        $course = trim($_POST['course'] ?? '');
        $password = $_POST['password'] ?? '';
        $confirm_password = $_POST['confirm_password'] ?? '';
        
        // Validation
        if (empty($full_name) || empty($email) || empty($phone) || empty($password)) {
            throw new Exception("All fields are required");
        }
        
        if ($password !== $confirm_password) {
            throw new Exception("Passwords do not match");
        }
        
        if (strlen($password) < 6) {
            throw new Exception("Password must be at least 6 characters");
        }
        
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Invalid email format");
        }
        
        // Check if email already exists
        $stmt = $conn->prepare("SELECT email_id FROM users WHERE email_id = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            throw new Exception("Email already registered");
        }
        
        // Hash password
        $password_hash = password_hash($password, PASSWORD_BCRYPT);
        
        // Insert user
        $stmt = $conn->prepare("
            INSERT INTO users (full_name, mobile_no, email_id, password_hash, role, created_at)
            VALUES (?, ?, ?, ?, 'student', NOW())
        ");
        $stmt->bind_param("ssss", $full_name, $phone, $email, $password_hash);
        
        if ($stmt->execute()) {
            $user_id = $stmt->insert_id;
            
            // Get course ID
            $stmt2 = $conn->prepare("SELECT course_id FROM courses WHERE course_name = ?");
            $stmt2->bind_param("s", $course);
            $stmt2->execute();
            $course_result = $stmt2->get_result();
            
            if ($course_result->num_rows > 0) {
                $course_row = $course_result->fetch_assoc();
                $course_id = $course_row['course_id'];
                
                // Check if there's an open batch for this course
                $stmt3 = $conn->prepare("
                    SELECT batch_id FROM batches 
                    WHERE course_id = ? AND is_open = 1 
                    LIMIT 1
                ");
                $stmt3->bind_param("i", $course_id);
                $stmt3->execute();
                $batch_result = $stmt3->get_result();
                
                if ($batch_result->num_rows > 0) {
                    $batch_row = $batch_result->fetch_assoc();
                    $batch_id = $batch_row['batch_id'];
                    
                    // Create enrollment
                    $stmt4 = $conn->prepare("
                        INSERT INTO enrollments (user_id, batch_id, enrollment_date)
                        VALUES (?, ?, NOW())
                    ");
                    $stmt4->bind_param("ii", $user_id, $batch_id);
                    $stmt4->execute();
                    $stmt4->close();
                }
                $stmt3->close();
            }
            $stmt2->close();
            
            $response['success'] = true;
            $response['message'] = "Registration successful! You can now login.";
        } else {
            throw new Exception("Registration failed: " . $conn->error);
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