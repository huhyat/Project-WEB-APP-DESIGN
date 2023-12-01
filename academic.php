<?php
require 'connector.php';
include 'header.php';
include 'menu.php';
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

        h2 {
            text-align: center;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            margin-bottom: 20px;
        }

        .details-container {
            border: 1px solid #000;
            padding: 10px;
            margin: 10px auto;
            width: 98%;
            background-color: #f9f9f9; /* Light gray background */
        }

        .details-container table {
            width: 100%;
        }

        .details-container table tr:nth-child(even) {
            background-color: #f2f2f2; /* Slightly darker gray for even rows */
        }

        .details-container table th,
        .details-container table td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }

        .details-container table th {
            background-color: #e6e6e6; /* Light gray for table headers */
        }

        .details-container table td:nth-child(odd) {
            font-weight: bold; /* Make odd columns bold for better distinction */
        }

        /* Styles for the Add Subject button */
        .add-subject-button {
            text-align: center;
            margin-top: 10px;
        }

        .add-subject-button button {
            padding: 8px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .add-subject-button button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body backgroud="background.png">
    <div class="details-container">
        <table>
            <tr>
                <td colspan="2">
                    <center><h2>STUDENT ACADEMIC DETAILS</h2></center>
                </td>
            </tr>
            <?php
            $studentID = $_SESSION['userid']; // Assuming the student ID is stored in a session after login

            // Retrieve the user's details including course information and enrolled subjects
            $studentDetailsQuery = "SELECT user.userid, user.name, user.course, courses.course_id, courses.course_name, user.session,
                                    subjects.subject_id, subjects.subject_name, subjects.credit_hours, student_enrollment.gpa 
                                    FROM user 
                                    INNER JOIN courses ON user.course = courses.course_id 
                                    INNER JOIN student_enrollment ON user.userid = student_enrollment.userid 
                                    INNER JOIN subjects ON student_enrollment.subject_id = subjects.subject_id 
                                    WHERE user.userid = '$studentID'";
            $studentDetailsResult = mysqli_query($connect, $studentDetailsQuery);

            $totalCreditHours = 0;
            $totalGradePoints = 0;

            // Extracting user details
            $studentDetails = mysqli_fetch_assoc($studentDetailsResult);

            // Display Student Details
            echo "
            <tr>
                <td><b>Student ID</b></td>
                <td>{$studentDetails['userid']}</td>
            </tr>
            <tr>
                <td><b>Student Name</b></td>
                <td>{$studentDetails['name']}</td>
            </tr>
            <tr>
                <td><b>Course ID</b></td>
                <td>{$studentDetails['course']}</td>
            </tr>
            <tr>
                <td><b>Course Name</b></td>
                <td>{$studentDetails['course_name']}</td>
            </tr>
            <tr>
                <td><b>Session</b></td>
                <td>{$studentDetails['session']}</td>
            </tr>";

            // Move the pointer to the next row (which contains subject details)
            mysqli_data_seek($studentDetailsResult, 0);

            echo "
            </table>

            <table>
            <tr>
                <td colspan='4'><b>Enrolled Subjects and GPAs</b></td>
            </tr>
            <tr>
                <td>Subject ID</td>
                <td>Subject Name</td>
                <td>Credit Hours</td>
                <td>GPA</td>
            ";

            // Display Enrolled Subjects and GPAs
            while ($row = mysqli_fetch_assoc($studentDetailsResult)) {
                $totalCreditHours += $row['credit_hours'];
                $totalGradePoints += $row['gpa'] * $row['credit_hours'];
                echo "<tr>";
                echo "<td>{$row['subject_id']}</td>";
                echo "<td>{$row['subject_name']}</td>";
                echo "<td>{$row['credit_hours']}</td>";
                echo "<td>{$row['gpa']}</td>";
                echo "</tr>";
            }

            echo "
            </table>

            <table>
            <tr>
                <td colspan='2'><b>Total Credit Hours</b></td>
                <td><b>$totalCreditHours</b></td>
            </tr>
            <tr>
                <td colspan='2'><b>Total CGPA</b></td>
                <td><b>".number_format((float)($totalGradePoints / $totalCreditHours), 2, '.', '')."</b></td>
            </tr>
            <tr>
    <td colspan='2'><b>Status</b></td>
    <td><b>";
        $weightedAverageRating = $totalGradePoints / $totalCreditHours;
        if ($weightedAverageRating >= 3.5) {
            echo 'DEAN';
        } elseif ($weightedAverageRating < 2.0) {
            echo 'WAR 1';
        } else {
            echo 'PASS';
        }
    echo "</b></td>
</tr>

            ";
            ?>
        </table>

        <!-- Add Subject button -->
        <div class="add-subject-button">
            <button onclick="location.href='add_subject_student.php'">Add Subject</button>
        </div>
		
		<div class="add-subject-button">
            
            <button onclick="window.print()">Print</button>
        </div>
    </div>
</body>
</html>
