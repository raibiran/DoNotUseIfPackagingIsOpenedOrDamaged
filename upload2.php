<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'student') {
    header("Location: login.php");
    exit();
}

// Include database connection
include 'config.php';

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $student_id = $_SESSION['user_id']; // Securely get student_id from session
    $course_id = intval($_POST['course_id']);

    // Verify that student exists
    $student_check = $conn->prepare("SELECT id FROM students WHERE id = ?");
    $student_check->bind_param("i", $student_id);
    $student_check->execute();
    $student_result = $student_check->get_result();

    if ($student_result->num_rows === 0) {
        die("Error: Student ID does not exist in the system.");
    }
    $student_check->close();

    // Fetch course name from ID
    $course_query = $conn->prepare("SELECT course_name FROM courses WHERE id = ?");
    $course_query->bind_param("i", $course_id);
    $course_query->execute();
    $course_result = $course_query->get_result();

    if ($course_result && $course_result->num_rows === 1) {
        $course_data = $course_result->fetch_assoc();
        $course_name = $course_data['course_name'];
    } else {
        die("Invalid course selected.");
    }
    $course_query->close();

    // Handle file upload
    if (isset($_FILES['assignment_file']) && $_FILES['assignment_file']['error'] === UPLOAD_ERR_OK) {
        $file_tmp = $_FILES['assignment_file']['tmp_name'];
        $file_name = basename($_FILES['assignment_file']['name']);
        $upload_dir = 'uploads/';
        $upload_path = $upload_dir . $file_name;

        // Create upload directory if it doesn't exist
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }

        // Move uploaded file
        if (move_uploaded_file($file_tmp, $upload_path)) {
            // Insert into database
            $stmt = $conn->prepare("INSERT INTO assignments (student_id, course, file_name, submission_date) VALUES (?, ?, ?, NOW())");
            $stmt->bind_param("iss", $student_id, $course_name, $file_name);

            if ($stmt->execute()) {
                echo "<p>✅ Assignment uploaded successfully!</p>";
                echo '<a href="student_dashboard.php">Return to Dashboard</a>';
            } else {
                echo "<p>❌ Database insertion failed: " . $stmt->error . "</p>";
            }

            $stmt->close();
        } else {
            echo "<p>❌ Failed to move uploaded file.</p>";
        }
    } else {
        echo "<p>❌ No file uploaded or upload error.</p>";
    }
} else {
    echo "<p>❌ Invalid request method.</p>";
}
?>
