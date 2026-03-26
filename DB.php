<?php
// Ensure this file exists and has your database credentials
require_once 'db_config.php'; 

function setupComprehensiveDatabase() {
    // Check if the necessary database connection function is available
    if (!function_exists('connectDB')) {
        die("Error: connectDB() function not found. Please ensure 'db_config.php' is included and configured.");
    }

    $pdo = connectDB();
    
    // SQL Schema Definition
    // Using "CREATE TABLE IF NOT EXISTS" prevents crashes if tables are already there.
    $sql_queries = [
    
    // 1. Users Table
    "CREATE TABLE IF NOT EXISTS users (
        user_id INT AUTO_INCREMENT PRIMARY KEY,
        full_name VARCHAR(255) NOT NULL,
        mobile_no VARCHAR(20) NOT NULL,
        email_id VARCHAR(255) NOT NULL UNIQUE,
        password_hash VARCHAR(255) NOT NULL,
        role ENUM('student', 'admin') NOT NULL DEFAULT 'student',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )",

    // 2. Courses Table
    "CREATE TABLE IF NOT EXISTS courses (
        course_id INT AUTO_INCREMENT PRIMARY KEY,
        course_name VARCHAR(100) NOT NULL UNIQUE,
        description TEXT
    )",

    // 3. Batches Table
    "CREATE TABLE IF NOT EXISTS batches (
        batch_id INT AUTO_INCREMENT PRIMARY KEY,
        course_id INT NOT NULL,
        batch_name VARCHAR(255) NOT NULL,
        batch_description TEXT,
        start_date DATE NOT NULL,
        is_open BOOLEAN NOT NULL DEFAULT TRUE,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (course_id) REFERENCES courses(course_id) ON DELETE RESTRICT
    )",

    // 4. Enrollments Table
    "CREATE TABLE IF NOT EXISTS enrollments (
        enrollment_id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT NOT NULL,
        batch_id INT NOT NULL,
        enrollment_date DATE NOT NULL,
        FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE,
        FOREIGN KEY (batch_id) REFERENCES batches(batch_id) ON DELETE CASCADE,
        UNIQUE KEY unique_enrollment (user_id, batch_id)
    )",

    // 5. Results Table
    "CREATE TABLE IF NOT EXISTS results (
        result_id INT AUTO_INCREMENT PRIMARY KEY,
        title VARCHAR(255) NOT NULL,
        caption TEXT,
        image_path VARCHAR(255) NOT NULL,
        result_year YEAR,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )",

    // 6. Updates Table
    "CREATE TABLE IF NOT EXISTS updates (
        update_id INT AUTO_INCREMENT PRIMARY KEY,
        title VARCHAR(255) NOT NULL,
        content TEXT NOT NULL,
        update_type ENUM('announcement', 'offer', 'news') NOT NULL DEFAULT 'announcement',
        published_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )",
    
    // 7. Contacts Table
    "CREATE TABLE IF NOT EXISTS contacts (
        contact_id INT AUTO_INCREMENT PRIMARY KEY,
        full_name VARCHAR(255) NOT NULL,
        email_id VARCHAR(255),
        mobile_no VARCHAR(20),
        subject VARCHAR(255),
        message TEXT NOT NULL,
        received_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        is_read BOOLEAN NOT NULL DEFAULT FALSE
    )",
    
    // 8. Course Inquiries Table
    "CREATE TABLE IF NOT EXISTS course_inquiries (
        inquiry_id INT AUTO_INCREMENT PRIMARY KEY,
        course_id INT NOT NULL,
        full_name VARCHAR(255) NOT NULL,
        mobile_no VARCHAR(20),
        email_id VARCHAR(255),
        inquiry_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (course_id) REFERENCES courses(course_id) ON DELETE RESTRICT
    )"
    ];

    // Initial Course Data
    $initial_courses = [
        ['JEE', 'Joint Entrance Examination preparation.'],
        ['NEET', 'National Eligibility cum Entrance Test preparation.'],
        ['MHT-CET', 'Maharashtra Common Entrance Test.'],
        ['Class 11', 'Complete curriculum for 11th standard.'],
        ['Class 12', 'Complete curriculum for 12th standard.'],
    ];

    try {
        // Execute all CREATE TABLE statements (support PDO or mysqli)
        if ($pdo instanceof PDO) {
            foreach ($sql_queries as $query) {
                $query = trim($query);
                if ($query !== '') {
                    $pdo->exec($query);
                }
            }
        } elseif ($pdo instanceof mysqli) {
            foreach ($sql_queries as $query) {
                $query = trim($query);
                if ($query !== '') {
                    if ($pdo->query($query) === false) {
                        throw new \Exception("MySQL error: " . $pdo->error);
                    }
                }
            }
        } else {
            throw new \Exception("Unsupported DB connection object. connectDB() must return PDO or mysqli.");
        }

        echo "<h3>✅ Database Setup Status:</h3>";
        echo "<ul><li>Tables created successfully (or already existed).</li>";

        // Insert Initial Courses (only if they don't exist)
        $count = 0;
        if ($pdo instanceof PDO) {
            $insert_course_sql = "INSERT IGNORE INTO courses (course_name, description) VALUES (?, ?)";
            $stmt = $pdo->prepare($insert_course_sql);
            foreach ($initial_courses as $course) {
                $stmt->execute($course);
                $count += $stmt->rowCount();
            }
        } else { // mysqli
            $insert_course_sql = "INSERT IGNORE INTO courses (course_name, description) VALUES (?, ?)";
            $stmt = $pdo->prepare($insert_course_sql);
            if ($stmt === false) {
                throw new \Exception("MySQL prepare failed: " . $pdo->error);
            }
            foreach ($initial_courses as $course) {
                $stmt->bind_param("ss", $course[0], $course[1]);
                $stmt->execute();
                $count += $stmt->affected_rows;
            }
            $stmt->close();
        }

        if ($count > 0) {
            echo "<li>Added $count new courses (JEE, NEET, etc.) to the database.</li>";
        } else {
            echo "<li>Default courses were already present.</li>";
        }
        echo "</ul>";

    } catch (\PDOException $e) {
        echo "<h3>❌ Database Setup Failed:</h3>";
        echo "<p>" . htmlspecialchars($e->getMessage()) . "</p>";
    } catch (\Exception $e) {
        echo "<h3>❌ Database Setup Failed:</h3>";
        echo "<p>" . htmlspecialchars($e->getMessage()) . "</p>";
    }
}

// Execute the setup
setupComprehensiveDatabase(); 
?>