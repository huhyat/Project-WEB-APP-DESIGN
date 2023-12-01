<?php
require 'connector.php';
include 'header.php';
include 'menu.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $studentID = $_POST['student_id'];
    $password = $_POST['password'];
    $name = $_POST['name'];
    $course = $_POST['course'];
    $semester = $_POST['semester'];

    $checkQuery = "SELECT * FROM user WHERE userid = '$studentID'";
    $checkResult = mysqli_query($connect, $checkQuery);

    if (mysqli_num_rows($checkResult) > 0) {
        echo '<script>alert("Student ID already exists. Please use a different ID.");</script>';
    } else {
        $insertQuery = "INSERT INTO user (userid, password, name, course, sem, level) VALUES ('$studentID', '$password', '$name', '$course', '$semester', 'STUDENT')";
        $result = mysqli_query($connect, $insertQuery);

        if ($result) {
            header("Location: studentinfo.php");
            exit;
        } else {
            echo "Failed to add a new student.";
        }
    }
}
?>

<html>
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: steelblue;     
            background-image: url('background.png');
            background-repeat: no-repeat;
            margin-top: 200px;
            background-size: 100%;
        }

        .student-container {
            width: 50%;
            margin: 20px auto;
            background-color: #fff;
            border: 1px solid #ccc;
            padding: 20px;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
        }

        input[type="submit"] {
            background-color: #4caf50;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 3px;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body background="background.png">
    <div class="student-container">
        <h2>Add New Student</h2>
        <form method="post" action="add_student.php">
            <label for="student_id">Student ID:</label>
            <input type="text" name="student_id" required>

            <label for="password">Password:</label>
            <input type="password" name="password" required>

            <label for="name">Name:</label>
            <input type="text" name="name" required>

            <label for="course">Course:</label>
            <input type="text" name="course" required>

            <label for="semester">Semester:</label>
            <input type="text" name="semester" required>

            <input type="submit" value="Add Student">
        </form>
    </div>
</body>
</html>
