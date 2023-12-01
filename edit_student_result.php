<?php
require 'connector.php';
include 'header.php';
include 'menu.php';

if (isset($_GET['userid'])) {
    $userid = $_GET['userid'];
    $query = "SELECT * FROM user WHERE userid='$userid'";
    $result = mysqli_query($connect, $query);
    $row = mysqli_fetch_assoc($result);
?>

<html>
	<style>
			body {
				font-family: sans-serif;
				background-color: steelblue;     
				background-image: "background.png";
				background-repeat:no-repeat;
				margin-top: 200px;
				background-size: 100%;
			}
			
			.e-container {
				padding: 10px;
				margin: 10px auto;
				width: 98%;
				border: 1px solid white;
				background-color: silver;
			}
		</style>
<body background="background.png">
	<br>
<div class="edit-container">
        <table width="100%" style="border: 1px solid #000; background-color: white;">
            <tr>
                <td>
    <center>
        <h2>Edit Student Result - <?php echo $row['name']; ?></h2>
    </center>

    <form method="post" action="edit_student_result.php">
        <input type="hidden" name="userid" value="<?php echo $row['userid']; ?>">

        <label for="subject">Select Subject:</label>
        <select name="subject" id="subject">
            <?php
            $enrolledSubjectsQuery = "SELECT subjects.subject_id, subjects.subject_name 
                                      FROM subjects 
                                      JOIN student_enrollment ON subjects.subject_id = student_enrollment.subject_id 
                                      WHERE student_enrollment.userid = '$userid'";

            $enrolledSubjectsResult = mysqli_query($connect, $enrolledSubjectsQuery);

            while ($enrolledSubject = mysqli_fetch_assoc($enrolledSubjectsResult)) {
                echo "<option value='{$enrolledSubject['subject_id']}'>{$enrolledSubject['subject_name']}</option>";
            }
            ?>
        </select><br><br>

        <label for="gpa">Enter GPA:</label>
        <input type="text" id="gpa" name="gpa" required><br><br>

        <input type="submit" value="Update GPA">
    </form>

    <?php
    // Display existing GPAs for the student's enrolled subjects
    $enrolledSubjectsGPAQuery = "SELECT subjects.subject_name, student_enrollment.gpa 
                                 FROM subjects 
                                 JOIN student_enrollment ON subjects.subject_id = student_enrollment.subject_id 
                                 WHERE student_enrollment.userid = '$userid'";

    $enrolledSubjectsGPAResult = mysqli_query($connect, $enrolledSubjectsGPAQuery);

    if (mysqli_num_rows($enrolledSubjectsGPAResult) > 0) {
        echo "<h3>Enrolled Subjects and GPAs:</h3>";
        echo "<ul>";
        while ($enrolledSubjectGPA = mysqli_fetch_assoc($enrolledSubjectsGPAResult)) {
            echo "<li>{$enrolledSubjectGPA['subject_name']}: GPA - {$enrolledSubjectGPA['gpa']}</li>";
        }
        echo "</ul>";
    } else {
        echo "No subjects found with GPA for this student.";
    }
    ?>

</body>
</html>

<?php
}
?>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userid = $_POST['userid'];
    $gpa = $_POST['gpa'];
    $selectedSubject = $_POST['subject'];

    // Check if the student has an existing GPA for the selected subject
    $checkGPAQuery = "SELECT * FROM student_enrollment WHERE userid='$userid' AND subject_id='$selectedSubject'";
    $checkGPAResult = mysqli_query($connect, $checkGPAQuery);

    if (mysqli_num_rows($checkGPAResult) > 0) {
        // If a record exists, update the existing GPA
        $updateGPAQuery = "UPDATE student_enrollment SET gpa='$gpa' WHERE userid='$userid' AND subject_id='$selectedSubject'";
        $result = mysqli_query($connect, $updateGPAQuery);

        if ($result) {
            header("Location: edit_student_result.php?userid=$userid");
        } else {
            echo "Error updating GPA: " . mysqli_error($connect);
        }
    } else {
        echo "No existing GPA found for this subject. You may need to add a new GPA.";
        // Handle the scenario where no existing GPA is found for the subject
        // It could prompt users to add a new GPA or provide instructions for adding GPAs for new subjects.
    }
}
?>
