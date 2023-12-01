<?php
// Required
require 'connector.php';

//include
include 'header.php';
include 'menu.php';

// Check if the user is logged in, if not, redirect to the login page
if (!isset($_SESSION['userid'])) {
    header("Location: login.php");
    exit();
}

// Fetch user's information from the database
$userid = $_SESSION['userid'];
$query = mysqli_query($connect, "SELECT * FROM user WHERE userid = '$userid'");
$row = mysqli_fetch_assoc($query);
$name = $row['name'];
$section = $row['section'];
$profile_image = $row['profile_image'];
$level = $row['level']; // Additional info: Level
$session = $row['session']; // Additional info: Session
$course = $row['course']; // Additional info: Course
$sem = $row['sem']; // Additional info: Sem

if (!$row) {
    die("User not found.");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Profile - Campus360</title>
    <style>
        body {
            font-family: sans-serif;
            margin: 0;
            padding: 0;
			background-color: steelblue;     
			background-image: "background.png";
			background-repeat:no-repeat;
			margin-top: 200px;
			background-size: 100%;
        }

        .profile-container {
            width: 100%;
            padding: 20px;
            background-color: #f9f9f9;
            border: 1px solid #000; /* Border for the profile container */
            box-sizing: border-box;
        }

        .profile-container h2 {
            color: #333;
            text-align: center;
        }

        .profile-info {
            display: flex;
            align-items: center;
            justify-content: space-around;
            margin-top: 20px;
        }

        .profile-image img {
            width: 130px;
            height: auto;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .profile-details {
            max-width: 60%;
        }

        .profile-details p {
            margin: 10px 0;
            color: #333;
        }

        .profile-details strong {
            font-weight: bold;
        }
    </style>
</head>
<body background="background.png">
	<br>
    <div class="profile-container">
        <h2>STUDENT PROFILE</h2>
        <div class="profile-info">
            <div class="profile-image">
                <img src="display_image.php" alt="Profile Image">
            </div>
            <div class="profile-details">
                <p><strong>Name:</strong> <?php echo $name; ?></p>
                <p><strong>Section:</strong> <?php echo $section; ?></p>
                <p><strong>Group:</strong> <?php echo $level; ?></p>
                <p><strong>Session:</strong> <?php echo $session; ?></p>
                <p><strong>Course:</strong> <?php echo $course; ?></p>
                <p><strong>Sem:</strong> <?php echo $sem; ?></p>
            </div>
        </div>
    </div>
</body>

<?php
include('footer.php');
?>

</html>
