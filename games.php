<?php
session_start();

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !==true) {
    header("location: index.php");
    exit;
}

define("redirect",true);
require "template.php";

if($_REQUEST["post"]) {
    $post = htmlspecialchars(trim($_REQUEST["post"]));
    $user = $_SESSION["username"];
    $sql = "insert into posts (uid,post,hashtag) values (?, ?, ?)";
    if($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "iss", $param_uid, $param_post, $param_hashtag);
        $param_uid = $_SESSION["id"];
        $param_post = $post;
        $param_hashtag = "games";
        if(mysqli_stmt_execute($stmt)){}else {echo "problem occured0";}
    } else { echo "problem occured".mysqli_error($conn);}
}

$result = mysqli_query($conn, "select post,uid,username from posts inner join users where users.id = posts.uid and hashtag = 'games' order by posts.create_date desc limit 100");
echo "<center>";
echo "<style>table,th,td{border:1px solid black;}</style><table style='font:24px sans-serif; width:60%' >";
while($row = mysqli_fetch_assoc($result)) {
    $row_post = $row["post"];
    $row_username = $row["username"];
    echo <<<EOF
    <tr><td>$row_username</td><td>$row_post</td></tr>
    EOF;
}
echo "</table>";
echo "</center>";
?>