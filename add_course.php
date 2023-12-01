<?php
require 'connector.php';
include 'header.php';
include 'menu.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $courseId = $_POST['course_id'];
    $courseName = $_POST['course_name'];

    if (empty($courseId) || empty($courseName)) {
        echo "<p>Please fill in all fields.</p>";
    } else {
        $checkQuery = "SELECT * FROM courses WHERE course_id = '$courseId'";
        $checkResult = mysqli_query($connect, $checkQuery);

        if (mysqli_num_rows($checkResult) > 0) {
            echo "<script>alert('Course ID already exists. Please use a different ID.');</script>";
            echo "<script>window.location = 'course_management.php';</script>";
        } else {
            $insertCourseQuery = "INSERT INTO courses (course_id, course_name) VALUES ('$courseId', '$courseName')";
            $result = mysqli_query($connect, $insertCourseQuery);

            if ($result) {
                echo "<script>alert('Course added successfully!');</script>";
                echo "<script>window.location = 'course_management.php';</script>";
            } else {
                echo "<script>alert('Error adding course: " . mysqli_error($connect) . "');</script>";
                echo "<script>window.location = 'course_management.php';</script>";
            }
        }
    }
}
?>
<!DOCTYPE html>
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

        .add-course-container {
            width: 50%;
            margin: 50px auto;
            background-color: #fff;
            border: 1px solid #ccc;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin-bottom: 5px;
        }

        input[type="text"],
        button {
            width: calc(100% - 10px);
            padding: 8px;
            margin: 5px 0;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }

        input[type="text"]:focus {
            outline: none;
            border: 1px solid #4CAF50;
        }
    </style>
</head>
<body background="background.png">
    <div class="add-course-container">
        <h2>ADD NEW COURSE</h2>
        <form method="post" action="">
            <label for="course_id">Course ID:</label>
            <input type="text" id="course_id" name="course_id" required>

            <label for="course_name">Course Name:</label>
            <input type="text" id="course_name" name="course_name" required>

            <button type="submit">Add Course</button>
        </form>
    </div>
</body>
</html>
