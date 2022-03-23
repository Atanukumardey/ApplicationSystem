<?php  

$sname = "localhost";
$uname = "root";
$password = "";
$db_name = "application_sysytem";

$conn = mysqli_connect($sname, $uname, $password, $db_name);

//$conn.setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if (!$conn) {
	echo "Connection Failed!";
	exit();
}
?>