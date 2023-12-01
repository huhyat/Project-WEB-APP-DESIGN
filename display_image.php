<?php
// Required
require 'connector.php';

// Start session
session_start();

// Check if the user is logged in, if not, redirect to the login page
if (!isset($_SESSION['userid'])) {
    header("Location: login.php");
    exit();
}

// Fetch user's information from the database
$userid = $_SESSION['userid'];
$query = mysqli_query($connect, "SELECT * FROM user WHERE userid = '$userid'");
$row = mysqli_fetch_assoc($query);
$profile_image = $row['profile_image'];
if (!$row) {
    die("User not found.");
}

// Set the appropriate content type header
header("Content-type: image/png");

// Output the image data from the database
echo $profile_image;

?>
