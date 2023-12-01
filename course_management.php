<?php
require 'connector.php';
include 'header.php';
include 'menu.php';
?>

<html>
<head>
    <style>
        body {
            font-family: sans-serif;
			background-color: steelblue;     
			background-image: "background.png";
			background-repeat:no-repeat;
			margin-top: 200px;
			background-size: 100%;
        }
        .course-container {
            border: 1px solid #000;
			padding: 10px;
       	 	margin: 10px auto;
        	width: 98%;
        	background-color: silver;
        }
        .add-cs-button {
            margin-top: 10px;
        }
        .delete-subject-button {
            display: block;
        }
        h2 {
            text-align: center;
        }
        
        .subject-info {
            font-weight: bold;
        }
		
    </style>
</head>
<body background="background.png">
    <center>
		
<div class="course-container">
        <table width="100%" style="border: 1px solid #000; background-color: white;">
            <tr>
                <td>
        <h2>COURSE MANAGEMENT</h2>
        <button class="add-cs-button" onclick="location.href='add_course.php'">ADD COURSE</button>
        <button class="add-cs-button" onclick="location.href='add_subject.php'">ADD SUBJECT</button>
    </center>
    <br>
    <main>
        <?php
        $prevCourse = '';
        $prevSubject = '';

        $courseQuery = "SELECT * FROM courses";
        $courseResult = mysqli_query($connect, $courseQuery);

        while ($course = mysqli_fetch_assoc($courseResult)) {
            echo "<div class='course-container'>";
            echo "<h4>{$course['course_id']}</h4>";
            echo "<h4>{$course['course_name']}</h4>";

            $subjectQuery = "SELECT * FROM subjects WHERE course_id = '{$course['course_id']}'";
            $subjectResult = mysqli_query($connect, $subjectQuery);

            while ($subject = mysqli_fetch_assoc($subjectResult)) {
                if ($course['course_id'] !== $prevCourse || $subject['subject_id'] !== $prevSubject) {
                    echo "<p class='subject-info'>{$subject['subject_id']} - {$subject['subject_name']} - Credit Hours: {$subject['credit_hours']}</p>";

                    echo "<button class='delete-subject-button' onclick='location.href=\"delete_subject.php?subject_id={$subject['subject_id']}\"'>Delete Subject</button>";

                    $enrollmentQuery = "SELECT user.name FROM user
                                        JOIN student_enrollment ON user.userid = student_enrollment.userid
                                        WHERE student_enrollment.course_id = '{$course['course_id']}'
                                        AND student_enrollment.subject_id = '{$subject['subject_id']}'
                                        AND user.level = 'STUDENT'
                                        ORDER BY user.name ASC";

                    $enrollmentResult = mysqli_query($connect, $enrollmentQuery);

                    $count = 1;

                    while ($student = mysqli_fetch_assoc($enrollmentResult)) {
                        echo "<ol>{$count}. {$student['name']}</ol>";
                        $count++;
                    }

                    $prevCourse = $course['course_id'];
                    $prevSubject = $subject['subject_id'];
                }
            }
            echo "</div>";
        }
        ?>
    </main>
</body>
</html>
