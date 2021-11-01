<?php
$servername = 'localhost';
$username = 'al1can';
$password = '';
$dbname = 'loginpage';

$conn = mysqli_connect($servername,$username,$password,$dbname);

if (!$conn) {
	die("Connection failed! : ". mysqli_connect_error());
}
echo "Connection succesfull";
$sql = 'select * from users';
$result = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_assoc($result)) {
	echo $row['firstname'];
}
?>
