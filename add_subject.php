<?php
require 'connector.php';
include 'header.php';
include 'menu.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $subjectId = $_POST['subject_id'];
    $subjectName = $_POST['subject_name'];
    $courseId = $_POST['course_id'];
    $creditHours = $_POST['credit_hours'];

    if (empty($subjectId) || empty($subjectName) || empty($courseId) || empty($creditHours)) {
        echo "<p>Please fill in all fields.</p>";
    } else {
        // Check for existing entry
        $checkQuery = "SELECT * FROM subjects WHERE subject_id = '$subjectId'";
        $checkResult = mysqli_query($connect, $checkQuery);

        if (mysqli_num_rows($checkResult) > 0) {
            echo "<script>alert('Subject ID already exists. Please use a different ID.');</script>";
            echo "<script>window.location = 'course_management.php';</script>";
        } else {
            // Insert the new subject into the database
            $insertSubjectQuery = "INSERT INTO subjects (subject_id, subject_name, course_id, credit_hours) VALUES ('$subjectId', '$subjectName', '$courseId', '$creditHours')";
            $result = mysqli_query($connect, $insertSubjectQuery);

            if ($result) {
                echo "<script>alert('Subject added successfully!');</script>";
                echo "<script>window.location = 'course_management.php';</script>";
            } else {
                echo "<script>alert('Error adding subject: " . mysqli_error($connect) . "');</script>";
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
            font-family: sans-serif;
            background-color: steelblue;
            margin: 0;
            padding: 0;     
			background-image: "background.png";
			background-repeat:no-repeat;
			margin-top: 200px;
			background-size: 100%;
        }

        .add-subject-container {
            padding: 20px;
            border: 1px solid #ccc;
            background-color: #fff;
            margin: 20px auto;
            width: 50%;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
            border-radius: 5px;
        }

        h2 {
            text-align: center;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="number"],
        button {
            width: 100%;
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

        input[type="text"]:focus,
        input[type="number"]:focus {
            outline: none;
            border: 1px solid #4CAF50;
        }
    </style>
</head>
<body background="background.png">
	<br>
    
    <div class="add-subject-container">
		<center>
        <h2>ADD NEW SUBJECT</h2>
    	</center>
        <form method="post" action="">
            <label for="subject_id">Subject ID:</label>
            <input type="text" id="subject_id" name="subject_id" required>

            <label for="subject_name">Subject Name:</label>
            <input type="text" id="subject_name" name="subject_name" required>

            <label for="course_id">Course ID:</label>
            <input type="text" id="course_id" name="course_id" required>
			
            <label for="credit_hours">Credit Hours:</label>
            <input type="number" id="credit_hours" name="credit_hours" required>

            <button type="submit">Add Subject</button>
        </form>
    </div>
</body>
</html>
