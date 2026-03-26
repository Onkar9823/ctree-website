<?php
// Database Configuration
$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "concept_tree";  // Changed from "DB.php"

// Create connection using MySQLi
function connectDB() {
    global $servername, $username, $password, $dbname;
    
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Set charset to UTF-8
    $conn->set_charset("utf8mb4");
    
    return $conn;
}

// Alternative PDO connection (optional, for flexibility)
function connectDBPDO() {
    global $servername, $username, $password, $dbname;
    
    try {
        $pdo = new PDO(
            "mysql:host=$servername;dbname=$dbname;charset=utf8mb4",
            $username,
            $password,
            array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION)
        );
        return $pdo;
    } catch (PDOException $e) {
        die("PDO Connection failed: " . $e->getMessage());
    }
}
?>
