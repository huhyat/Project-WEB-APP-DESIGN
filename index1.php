<!DOCTYPE html>
<?php
require 'connector.php';
include 'header.php';
include 'menu.php';
?>
<html>
<head>
    <title>Campus360 - Home</title> 
</head>

<style>
    body {
        font-family: sans-serif;
		background-color: steelblue;     
			background-image: "background.png";
			background-repeat:no-repeat;
			margin-top: 200px;
			background-size: 100%;
    }
</style>

<body background="background.png">
    <br>
    <div class="content">
        <table width="100%" style="border: 1px solid #000; background-color: white;">
            <tr>
                <td style="background-color: white;">
                    <h2>WELCOME TO Campus360 </h2>

                  <?php
                    
                    if (isset($_SESSION['name'])) {
                        // authenticated users
                        echo "<p><strong>Welcome:</strong><br> " . $_SESSION['name'] . "</p>";
                        echo "<p><strong>Group:</strong><br> " . $_SESSION['level'] . "</p>";

                        // Fetch and display the last login timestamp
                        $userid = $_SESSION['userid'];
                        $getLastLoginQuery = "SELECT last_login FROM user WHERE userid = '$userid'";
                        $lastLoginResult = mysqli_query($connect, $getLastLoginQuery);
                        $lastLogin = mysqli_fetch_assoc($lastLoginResult)['last_login'];
                        echo "<p><strong>Last Login:</strong><br> " . $lastLogin . "</p>";
						
                    } else {
                        // user is not authenticated
                        echo "<p>Please <a href='login.php'>login</a> to access the system.</p>";
                    }
                    ?>

                </td>
            </tr>
        </table>
    </div>
</body>

<?php
include('footer.php');
?>
</html>
