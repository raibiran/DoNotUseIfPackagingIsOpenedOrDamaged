<?php
// register_process.php
$host = 'localhost';
$user = 'root'; // your DB username
$pass = '';     // your DB password
$db   = 'student_system';

// Connect to DB
$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get inputs
$student_id = $_POST['student_id'];
$name = $_POST['name'];
$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Secure hashing
$course = $_POST['course'];

// Insert into DB
$sql = "INSERT INTO students (student_id, name, email, password, course) VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssss", $student_id, $name, $email, $password, $course);

if ($stmt->execute()) {
    echo "Registration successful. <a href='login.php'>Login now</a>";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
