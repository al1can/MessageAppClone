<?php

$servername = 'localhost';
$username = '';
$password = '';
$dbname = '';

$conn = mysqli_connect($servername,$username,$password,$dbname);

if (!$conn) {
	die("Connection failed! : ". mysqli_connect_error());
}

//$sql = "SELECT username FROM users where username = ''";
//$result = mysqli_query($conn, $sql);
/*
if (mysqli_num_rows($result) > 0) {
  // output data of each row
  while($row = mysqli_fetch_assoc($result)) {
    echo $row["username"];
  }
} else {
  echo "0 results";
}
*/
//while($row = mysqli_fetch_assoc($result)) {
//	print_r($row);
//}

?>
