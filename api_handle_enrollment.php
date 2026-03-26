<?php

// Handle Enrollment Form Submission
header('Content-Type: application/json');

require_once 'db_config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $response = ['success' => false, 'message' => ''];
    
    try {
        $conn = connectDB();
        
        $student_name = trim($_POST['studentName'] ?? '');
        $student_email = trim($_POST['studentEmail'] ?? '');
        $student_phone = trim($_POST['studentPhone'] ?? '');
        $course_name = trim($_POST['course'] ?? '');
        
        // Validation
        if (empty($student_name) || empty($student_email) || empty($student_phone)) {
            throw new Exception("All fields are required");
        }
        
        if (!filter_var($student_email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Invalid email format");
        }
        
        // Store inquiry in database
        $stmt = $conn->prepare("
            INSERT INTO course_inquiries (course_id, full_name, mobile_no, email_id, inquiry_date)
            SELECT course_id, ?, ?, ?, NOW()
            FROM courses
            WHERE course_name = ?
            LIMIT 1
        ");
        $stmt->bind_param("ssss", $student_name, $student_phone, $student_email, $course_name);
        
        if ($stmt->execute()) {
            $response['success'] = true;
            $response['message'] = "Enrollment inquiry submitted successfully! We'll contact you soon.";
        } else {
            throw new Exception("Failed to submit inquiry");
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