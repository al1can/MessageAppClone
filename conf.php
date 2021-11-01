<?php
$servername = 'localhost';
$username = 'root';
$password = '5511114131Ag';
$dbname = 'loginpage';

$conn = mysql_connect($servername,$username,$password,$dbname);
if (!conn) {
	die("Connection failed! : ". mysqli_connect_error());
}
echo "Connection succesfull";
?>
