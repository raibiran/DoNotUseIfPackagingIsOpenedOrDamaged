<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'student') {
    header("Location: login.php");
    exit();
}

// Connect to database
include 'config.php'; // Contains your DB credentials and connection

// Fetch courses
$courses = [];
$sql = "SELECT id, course_name FROM courses";
$result = $conn->query($sql);
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $courses[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Submit Assignment</title>
    <link rel="stylesheet" href="submit.css">
</head>
<body>
    <div class="dashboard-container">
        <h1>Submit Assignment</h1>
        <form action="upload2.php" method="POST" enctype="multipart/form-data">
            <label for="student_id">Student ID:</label><br>
               <input type="number" name="student_id" id="student_id" required><br><br>
            <label for="course">Select Course:</label><br>
            <select name="course_id" id="course" required>
                <option value="">-- Select Course --</option>
                <?php foreach ($courses as $course): ?>
                    <option value="<?= htmlspecialchars($course['id']) ?>">
                        <?= htmlspecialchars($course['course_name']) ?>
                    </option>
                <?php endforeach; ?>
            </select><br><br>

            <label for="assignment">Choose File:</label><br>
            <input type="file" name="assignment_file" id="assignment" required><br><br>

            <button type="submit">Upload Assignment</button>
        </form>
        <br>
        <a href="student_dashboard.php">Back to Dashboard</a>
    </div>
</body>
</html>
