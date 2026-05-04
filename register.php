<?php
// 1. Tell the browser we are sending back JSON
header("Content-Type: application/json");

// 2. Connect to the database
$servername = "localhost";
$username = "root";
$password = ""; 
$dbname = "logindetail";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    echo json_encode(["status" => "error", "message" => "Connection failed: " . $conn->connect_error]);
    exit;
}

// 3. Get the JSON data from JavaScript
$json = file_get_contents('php://input');
$data = json_decode($json, true);

// 4. Check if data exists and is valid
if ($data && isset($data['name']) && isset($data['email']) && isset($data['pass'])) {
    
    $name = $data['name'];
    $email = $data['email'];
    $plain_pass = $data['pass'];

    // 5. Hash the password for security
    $hashed_pass = password_hash($plain_pass, PASSWORD_DEFAULT);

    // 6. Use a Prepared Statement to prevent SQL Injection
    $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
    
    // Check if prepare() failed
    if (!$stmt) {
        echo json_encode(["status" => "error", "message" => "Prepare failed: " . $conn->error]);
        exit;
    }

    $stmt->bind_param("sss", $name, $email, $hashed_pass);

    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "User registered!"]);
    } else {
        // Handle Duplicate Email
        if ($conn->errno === 1062) {
            echo json_encode(["status" => "error", "message" => "This email is already registered."]);
        } else {
            echo json_encode(["status" => "error", "message" => "Insert error: " . $stmt->error]);
        }
    }

    $stmt->close();
} else {
    echo json_encode(["status" => "error", "message" => "Incomplete data received."]);
}

$conn->close();
?>