<?php
session_start();
include 'config.php'; // DB connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect and sanitize form data
    $lect_id = trim($_POST['Lect_ID']);
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Basic validation
    if (empty($lect_id) || empty($name) || empty($email) || empty($password)) {
        die("❌ All fields are required.");
    }

    // Check for duplicate Lecturer ID or Email
    $checkQuery = $conn->prepare("SELECT * FROM lecturers WHERE Lect_ID = ? OR email = ?");
    $checkQuery->bind_param("ss", $lect_id, $email);
    $checkQuery->execute();
    $checkResult = $checkQuery->get_result();

    if ($checkResult->num_rows > 0) {
        echo "⚠️ Lecturer with this ID or email already exists. <a href='lecturer_register.php'>Try again</a>";
    } else {
        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insert new lecturer into the database
        $stmt = $conn->prepare("INSERT INTO lecturers (Lect_ID, name, email, password) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $lect_id, $name, $email, $hashed_password);

        if ($stmt->execute()) {
            echo "✅ Registration successful. <a href='login.php'>Login here</a>";
        } else {
            echo "❌ Error inserting data: " . $stmt->error;
        }

        $stmt->close();
    }

    $checkQuery->close();
    $conn->close();
} else {
    echo "❌ Invalid request method.";
}
?>
