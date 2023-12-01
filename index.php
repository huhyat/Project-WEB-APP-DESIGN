<?php
include('header.php');
?>
<html>

<head>
    <title>Campus Management System</title>
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
<br>
<div class="content">
        <table width="100%" style="border: 1px solid #000; background-color: white;">
            <tr>
                <td style="background-color: white;">
                    <h2>WELCOME TO CAMPUS360</h2>
                    <p>YOU ARE LOGOUT !</p>

                    <?php
        
                        // Content to display when the user is not authenticated
                        echo "<p>Please <a href='login.php'>LOGIN</a> to access the system.</p>";
                    
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
