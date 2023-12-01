<?php
require 'connector.php';
include 'header.php';
include 'menu.php';

if (isset($_GET['userid'])) {
    $userid = $_GET['userid'];

    // Fetch student information for editing
    $editQuery = "SELECT * FROM user WHERE userid = '$userid'";
    $result = mysqli_query($connect, $editQuery);
    $student = mysqli_fetch_assoc($result);

    // Update student information
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $name = $_POST['name'];
        $course = $_POST['course'];
        $sem = $_POST['sem'];

        $updateQuery = "UPDATE user SET name='$name', course='$course', sem='$sem' WHERE userid='$userid'";
        mysqli_query($connect, $updateQuery);

        header("Location: studentinfo.php");
    }
    ?>

    <html>
    <body background="background.png">
		<style>
			body {
				font-family: sans-serif;
				background-color: steelblue;     
				background-image: "background.png";
				background-repeat:no-repeat;
				margin-top: 200px;
				background-size: 100%;
			}
			
			.edit-container {
        padding: 10px;
        margin: 10px auto;
        width: 98%;
        border: 1px solid white;
        background-color: silver;
    }
		</style>
<div class="edit-container">
        <table width="100%" style="border: 1px solid #000; background-color: white;">
            <tr>
                <td>
    <center><h2>EDIT STUDENT INFORMATION</h2></center>
    <main>
    <form method="post" action="edit_student.php?userid=<?php echo $userid; ?>">
        <table width="60%" border="0" align="center" style='font-size:16px'>
            <tr>
                <td><b>Student Name:</b></td>
                <td><input type="text" name="name" value="<?php echo $student['name']; ?>" required></td>
            </tr>
            <tr>
                <td><b>Course:</b></td>
                <td><input type="text" name="course" value="<?php echo $student['course']; ?>" required></td>
            </tr>
            <tr>
                <td><b>Semester:</b></td>
                <td><input type="text" name="sem" value="<?php echo $student['sem']; ?>" required></td>
            </tr>
			<tr>
                <td><b>Password:</b></td>
                <td><input type="text" name="password" value="<?php echo $student['password']; ?>" required></td>
            </tr>
            <tr>
                <td></td>
                <td><input type="submit" value="Update"></td>
            </tr>
        </table>
    </form>
    </main>
    </body>
    </html>

    <?php
} else {
    echo "Invalid request.";
}
?>
