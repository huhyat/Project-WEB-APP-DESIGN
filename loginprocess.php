<?php 
//wajib fail ini
require 'connector.php';
//perlukan fail ini
include 'header.php';
//mula sesi
session_start();
if (isset($_POST['idpengguna'])) {
$user = $_POST['idpengguna'];
$pass = $_POST['password'];
$query = mysqli_query($connect,
"SELECT * FROM user WHERE idpengguna='$user'
AND password='$pass'");
$row = mysqli_fetch_assoc($query);
if(mysqli_num_rows($query) == 0||$row['password']!=$pass)
{
echo "<script>alert('ID Pengguna atau Katalaluan yang salah');
window.location='login.php'</script>";
}
else
{
$_SESSION['idpengguna']=$row['idpengguna'];
$_SESSION['level'] = $row['level'];
header("Location: index1.php");
}
}
?>