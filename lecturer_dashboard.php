<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'lecturer') {
    header("Location: login.php");
    exit();
}

$host = 'localhost';
$user = 'root';
$pass = '';
$db   = 'student_system';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle feedback/grade submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['assignment_id'])) {
    $assignment_id = $_POST['assignment_id'];
    $feedback = $_POST['feedback'];
    $grade = $_POST['grade'];

    $stmt = $conn->prepare("UPDATE assignments SET feedback = ?, grade = ? WHERE id = ?");
    $stmt->bind_param("ssi", $feedback, $grade, $assignment_id);
    $stmt->execute();
    $stmt->close();
}

// Fetch assignments
$sql = "SELECT a.id, a.student_id, s.name AS student_name, a.course, a.file_name, a.submission_date, a.feedback, a.grade 
        FROM assignments a 
        JOIN students s ON a.student_id = s.id 
        ORDER BY a.submission_date DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Lecturer Dashboard</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f5f7fa;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 1200px;
            margin: auto;
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }

        h2 {
            color: #003366;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 40px;
        }

        table, th, td {
            border: 1px solid #ccc;
        }

        th, td {
            padding: 12px 15px;
            text-align: left;
        }

        th {
            background-color: #003366;
            color: white;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        textarea, input[type="text"], select {
            padding: 10px;
            margin-top: 5px;
            margin-bottom: 15px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        input[type="submit"] {
            background-color: #003366;
            color: white;
            padding: 10px 15px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            width: fit-content;
        }

        input[type="submit"]:hover {
            background-color: #0055a5;
        }

        .grade-section {
            background-color: #f2f2f2;
            padding: 15px;
            border-radius: 5px;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Lecturer Dashboard: Assignment Review</h2>

        <?php if ($result->num_rows > 0): ?>
        <table>
            <tr>
                <th>Student Name</th>
                <th>Course</th>
                <th>File</th>
                <th>Submitted On</th>
                <th>Feedback</th>
                <th>Grade</th>
                <th>Action</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['student_name']) ?></td>
                    <td><?= htmlspecialchars($row['course']) ?></td>
                    <td>
                        <?php if ($row['file_name']): ?>
                            <a href="uploads/<?= htmlspecialchars($row['file_name']) ?>" target="_blank">View</a>
                        <?php else: ?>
                            N/A
                        <?php endif; ?>
                    </td>
                    <td><?= htmlspecialchars($row['submission_date']) ?></td>
                    <td><?= nl2br(htmlspecialchars($row['feedback'])) ?></td>
                    <td><?= htmlspecialchars($row['grade']) ?></td>
                    <td>
                        <form method="POST" class="grade-section">
                            <input type="hidden" name="assignment_id" value="<?= $row['id'] ?>">
                            <label>Feedback:</label>
                            <textarea name="feedback" rows="2"><?= htmlspecialchars($row['feedback']) ?></textarea>
                            <label>Grade:</label>
                            <input type="text" name="grade" value="<?= htmlspecialchars($row['grade']) ?>">
                            <input type="submit" value="Submit">
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
        <?php else: ?>
            <p>No assignments submitted yet.</p>
        <?php endif; ?>

    </div>
</body>
</html>

<?php $conn->close(); ?>
