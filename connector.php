<?php
//Ini adalah untuk menyambung antara file dan database
$host="localhost";
$user="root";
$password="";
$database="Campus360";//Correct database name

$connect=mysqli_connect($host, $user, $password,$database);
if (mysqli_connect_errno()) {
echo "Harap Maaf, Proses membuat sambungan ke pangkalan data GAGAL";
exit();
}

?>