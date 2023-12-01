<?php
require 'connector.php';
include 'header.php';
include 'menu.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $subjectId = $_POST['subject_id'];
    $courseId = $_POST['course_id'];
    $userId = $_SESSION['userid'];

    if (empty($subjectId) || empty($courseId) || empty($userId)) {
        echo "<p>Please fill in all fields.</p>";
    } else {
        // Check for duplicate subject enrollment for the user and course
        $duplicateCheckQuery = "SELECT * FROM student_enrollment 
                                WHERE userid = '$userId' 
                                AND course_id = '$courseId' 
                                AND subject_id = '$subjectId'";

        $duplicateCheckResult = mysqli_query($connect, $duplicateCheckQuery);

        if (mysqli_num_rows($duplicateCheckResult) > 0) {
            echo "<script>alert('You are already enrolled in this subject for this course.');</script>";
        } else {
            // Proceed with inserting the enrolled subject
            $insertEnrollmentQuery = "INSERT INTO student_enrollment (userid, course_id, subject_id) 
                                      VALUES ('$userId', '$courseId', '$subjectId')";
            $result = mysqli_query($connect, $insertEnrollmentQuery);

            if ($result) {
                echo "<script>alert('Subject enrolled successfully!');</script>";
                echo "<script>window.location = 'academic.php';</script>";
            } else {
                echo "<script>alert('Error enrolling subject: " . mysqli_error($connect) . "');</script>";
            }
        }
    }
}

$subjectsQuery = "SELECT * FROM subjects";
$subjectsResult = mysqli_query($connect, $subjectsQuery);

$coursesQuery = "SELECT * FROM courses";
$coursesResult = mysqli_query($connect, $coursesQuery);
?>

<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
			background-color: steelblue;     
			background-image: "background.png";
			background-repeat:no-repeat;
			margin-top: 200px;
			background-size: 100%;
        }

        .add-subject-form {
            padding: 20px;
            border: 1px solid #ccc;
            background-color: #fff;
            margin: 20px auto;
            width: 50%;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
            border-radius: 5px;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="number"],
        select,
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

        input[type="text"]:focus,
        input[type="number"]:focus,
        select:focus {
            outline: none;
            border: 1px solid #4CAF50;
        }
    </style>
</head>
<body background="background.png">
    <div class="add-subject-form">
        <h2>Enroll in Subject</h2>
        <form method="post" action="">
            <label for="subject_id">Subject ID:</label>
            <select id="subject_id" name="subject_id" required>
                <option value="">Select Subject</option>
                <?php
                while ($row = mysqli_fetch_assoc($subjectsResult)) {
                    echo "<option value='{$row['subject_id']}'>{$row['subject_name']}</option>";
                }
                ?>
            </select>

            <label for="course_id">Course ID:</label>
            <select id="course_id" name="course_id" required>
                <option value="">Select Course</option>
                <?php
                while ($row = mysqli_fetch_assoc($coursesResult)) {
                    echo "<option value='{$row['course_id']}'>{$row['course_id']}</option>";
                }
                ?>
            </select>

            <button type="submit">Enroll in Subject</button>
        </form>
    </div>
</body>
</html>
