<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Course Management System</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            font-family: 'Inter', sans-serif;
            background-color: #f4f6f8;
        }
        header {
            background-color: #003366;
            color: white;
            padding: 20px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        header h1 {
            margin: 0;
            font-size: 24px;
        }
        nav a {
            color: white;
            margin-left: 20px;
            text-decoration: none;
            font-weight: 500;
        }
        nav a:hover {
            text-decoration: underline;
        }
        .hero {
            padding: 80px 40px;
            text-align: center;
            background: linear-gradient(135deg, #005f99, #0099cc);
            color: white;
        }
        .hero h2 {
            font-size: 36px;
            margin-bottom: 10px;
        }
        .hero p {
            font-size: 18px;
        }
        .sections {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
            padding: 40px;
            background-color: #fff;
        }
        .card {
            background-color: #f9f9f9;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            width: 300px;
            margin: 20px;
            padding: 20px;
            transition: transform 0.2s;
        }
        .card:hover {
            transform: translateY(-5px);
        }
        .card h3 {
            margin-top: 0;
            color: #003366;
        }
        .card p {
            font-size: 14px;
            color: #555;
        }
        .card a {
            text-decoration: none;
            display: inline-block;
            margin-top: 10px;
            color: #007acc;
            font-weight: 600;
        }
        footer {
            background-color: #003366;
            color: white;
            text-align: center;
            padding: 20px;
            font-size: 14px;
        }
    </style>
</head>
<body>

    <header>
        <h1>Online Course Management</h1>
        <nav>
            <a href="index.html">Home</a>
            <a href="student_register.php">Student Register</a>
            <a href="lecturer_register.php">Lecturer Register</a>
            <a href="login.php">Login</a>
            <a href="contact.php">Contact</a>
        </nav>
    </header>

    <section class="hero">
        <h2>Welcome to the Online Course Management System</h2>
        <p>Streamline course registrations, assignment submissions, and grade tracking online.</p>
    </section>

    <section class="sections">
        <div class="card">
            <h3>Register as Student</h3>
            <p>New students can register and enroll in courses quickly using our registration portal.</p>
            <a href="student_register.php">Register Now →</a>
        </div>

        <div class="card">
            <h3>Register as Lecturer</h3>
            <p>Lecturers can register to manage course content, assignments, and student evaluations.</p>
            <a href="lecturer_register.php">Register Now →</a>
        </div>

        <div class="card">
            <h3>Manage Courses</h3>
            <p>Add, modify, or view course offerings and content from one centralized location.</p>
            <a href="courses.php">Manage Courses →</a>
        </div>

        <div class="card">
            <h3>Submit Assignments</h3>
            <p>Students can log in to upload assignments securely and receive lecturer feedback.</p>
            <a href="login.php">Login to Submit →</a>
        </div>

        <div class="card">
            <h3>Check Grades</h3>
            <p>Tracking the academic performance. Grades are CAN only visible to logged-in students and staff.</p>
            <a href="login.php">Login to View Grades →</a>
        </div>

        <div class="card">
            <h3>Contact & Support</h3>
            <p>Have questions or issues? Reach out to us through the contact form for assistance.</p>
            <a href="contact.php">Contact Us →</a>
        </div>
    </section>

    <footer>
        &copy; 2025 Online Course Management System | Designed for Assignment 2 – Interactive Web Design
    </footer>

</body>
</html>
