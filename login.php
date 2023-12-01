<?php 
//Required
require 'connector.php';

//start session
session_start();
if (isset($_POST['userid'])) {
$user = $_POST['userid'];
$pass = $_POST['password'];
$query = mysqli_query($connect,
"SELECT * FROM user WHERE userid='$user'
AND password='$pass'");
$row = mysqli_fetch_assoc($query);
if(mysqli_num_rows($query) == 0||$row['password']!=$pass)
{
echo "<script>alert('WRONG USER ID OR PASSWORD !');
window.location='login.php'</script>";
}
else
{
$_SESSION['userid']=$row['userid'];
$_SESSION['level'] = $row['level'];
$_SESSION['name'] = $row['name'];
$updateLastLoginQuery = "UPDATE user SET last_login = NOW() WHERE userid = '$user'";
mysqli_query($connect, $updateLastLoginQuery);
header("Location: index1.php");
}
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login - Campus360</title>
    <style>
        body {
        margin: 0;
        padding: 0;
        font-family: Arial, sans-serif;
        background-color: steelblue;     
			background-image: "background.png";
			background-repeat:no-repeat;
			margin-top: 200px;
			background-size: 100%;
    }

    .login-container {
        width: 350px;
        margin: 100px auto;
        padding: 20px;
        background-color: #ffffff;
        border-radius: 5px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    h2 {
        text-align: center;
        color: #009FB7;
    }

    .input-group {
        margin-bottom: 15px;
    }

    .input-group label {
        display: block;
        margin-bottom: 5px;
    }

    .input-group input {
        width: 343px;
        height: 40px;
        border: 1px solid #ccc;
        border-radius: 3px;
    
    }

    .btn {
        display: block;
        width: 100%;
        padding: 10px;
        background-color: steelblue;
        color: white;
        border: none;
        border-radius: 3px;
        cursor: pointer;
    }

    .btn:hover {
        background-color: lightblue;
    }
	
	.video-background {
            position: fixed;
            right: 0;
            bottom: 0;
            min-width: 100%;
            min-height: 100%;
            width: auto;
            height: auto;
            z-index: -1000;
            background-size: cover;
            transition: 1s opacity;
        }
    </style>
</head>
<body background="background.png">
	<video class="video-background" autoplay loop muted>
            <source src="uptm.mp4" type="video/mp4">
        </video>
    <div class="login-container">
        <h2>Login</h2>
        <form method="post" action="login.php">
            <div class="input-group">
                <label for="userid">User ID:</label>
                <input type="text" id="userid" name="userid" placeholder="User ID" required>
            </div>
            <div class="input-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" placeholder="Password" required>
            </div>
            <button type="submit" class="btn">Login</button>
        </form>

        <?php
        if (isset($error_message)) {
            echo '<p style="color: red;">' . $error_message . '</p>';
        }
        ?>
    </div>
</body>
<?php
include('footer.php');
?>
</html>




