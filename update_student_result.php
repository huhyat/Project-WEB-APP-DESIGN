<?php
require 'connector.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userid = $_POST['userid'];
    $gpa = $_POST['gpa'];
    $selectedSubject = $_POST['subject'];

    // Update GPA in the academic_records table for the selected subject
    $updateQuery = "UPDATE academic_data SET gpa='$gpa' WHERE subject='$selectedSubject'";
    $result = mysqli_query($connect, $updateQuery);

    if ($result) {
        header("Location: edit_student_result.php");
    } else {
        echo "Error updating GPA: " . mysqli_error($connect);
    }
}
?>
