<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'student') {
    header("Location: login.php");
    exit();
}



//require_once 'db_connect.php';
require_once 'config.php';

$userId = $_SESSION['user_id'];
$sql = "SELECT student_id, course, grade, feedback FROM assignments WHERE student_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Your Grades</title>
    <link rel="stylesheet" href="css/dashboard.css">
    <link rel="stylesheet" href="submit.css">
</head>
<body>
    <div class="dashboard-container">
        <h1>Your Grades & Feedback</h1>
        <table border="1" style="width:100%; text-align:left;">
            <tr>
                <th>Student ID </th>
                <th>Course</th>
                <th>Grade</th>
                <th>Feedback</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($row['student_id']) ?></td>
                <td><?= htmlspecialchars($row['course']) ?></td>
                <td><?= htmlspecialchars($row['grade']) ?></td>
                <td><?= nl2br(htmlspecialchars($row['feedback'])) ?></td>
            </tr>
            <?php endwhile; ?>
        </table>
        <br>
        <a href="student_dashboard.php">Back to Dashboard</a>
    </div>
</body>
</html>
