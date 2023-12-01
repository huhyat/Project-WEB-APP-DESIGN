<?php
// Fetch last login timestamp from the database
$getLastLoginQuery = "SELECT last_login FROM users WHERE idpengguna = '$user'";
$lastLoginResult = mysqli_query($connect, $getLastLoginQuery);
$lastLogin = mysqli_fetch_assoc($lastLoginResult)['last_login'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Welcome to the Dashboard</title>
	<style>
		body{
			background-color: steelblue;     
			background-image: "background.png";
			background-repeat:no-repeat;
			margin-top: 200px;
			background-size: 100%;
		}
	</style>
</head>
<body background="background.png">
    <h1>Welcome, <?php echo $nama; ?>!</h1>
    <p>This is your dashboard. You are now logged in.</p>
    <p><strong>Group:</strong> <?php echo $level; ?></p>
    <p><strong>Last Login:</strong> <?php echo $lastLogin; ?></p>
    <a href="logout.php">Logout</a>
</body>
</html>
