<?php
require 'connector.php';

if (isset($_GET['userid'])) {
    $userid = $_GET['userid'];

    // Delete student record
    $deleteQuery = "DELETE FROM user WHERE userid = '$userid'";
    mysqli_query($connect, $deleteQuery);
	
	echo "<script>alert('STUDENT SUCCESSFULLY DELETED');
	window.location='studentinfo.php'</script>";

} else {
    echo "Invalid request.";
}
?>
