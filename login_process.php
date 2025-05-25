<?php
session_start();

$host = 'localhost';
$user = 'root';
$pass = '';
$db   = 'student_system';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get POST data
$email = $_POST['email'];
$password = $_POST['password'];
$role = $_POST['role'];

// Validate input
if (empty($email) || empty($password) || empty($role)) {
    die("All fields are required.");
}

if ($role == "student") {
    $stmt = $conn->prepare("SELECT id, password FROM students WHERE email = ?");
    $stmt->bind_param("s", $email);
} elseif ($role == "lecturer") {
    $stmt = $conn->prepare("SELECT Lect_ID, password FROM lecturers WHERE email = ?");
    $stmt->bind_param("s", $email);
} else {
    die("Invalid role selected.");
}

$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    $stmt->bind_result($user_id, $hashed_password);
    $stmt->fetch();

    if (password_verify($password, $hashed_password)) {
        $_SESSION['user_id'] = $user_id;
        $_SESSION['role'] = $role;

        if ($role == "student") {
            header("Location: student_dashboard.php");
        } elseif ($role == "lecturer") {
            header("Location: lecturer_dashboard.php");
        }
        exit();
    } else {
        echo "❌ Invalid password.";
    }
} else {
    echo "❌ No user found with that email.";
}

$stmt->close();
$conn->close();
?>
