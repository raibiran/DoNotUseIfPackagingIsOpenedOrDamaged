<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'student') {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["assignment_file"])) {
    require_once 'config.php';

    $userId = $_SESSION['user_id'];
    $courseId = $_POST['course_id'];

    // Get course name from DB
    $courseName = '';
    $stmt = $conn->prepare("SELECT course_name FROM courses WHERE id = ?");
    $stmt->bind_param("i", $courseId);
    $stmt->execute();
    $stmt->bind_result($courseName);
    $stmt->fetch();
    $stmt->close();

    if (empty($courseName)) {
        echo "Invalid course selected.";
        exit();
    }

    $fileName = $_FILES["assignment_file"]["name"];
    $fileTmp = $_FILES["assignment_file"]["tmp_name"];
    $uploadDir = "uploads/";

    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $filePath = $uploadDir . time() . "_" . basename($fileName);

    if (move_uploaded_file($fileTmp, $filePath)) {
        // Save to DB
        $stmt = $conn->prepare("INSERT INTO assignments (student_id, course, file_path, submitted_at) VALUES (?, ?, ?, NOW())");

        if ($stmt) {
            $stmt->bind_param("iss", $userId, $courseName, $filePath);
            $stmt->execute();
            $stmt->close();

            echo "✅ Assignment submitted successfully!<br><a href='student_dashboard.php'>Back to Dashboard</a>";
        } else {
            echo "❌ Database error. Could not prepare statement.";
        }
    } else {
        echo "❌ Failed to upload file.";
    }
}
?>
