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
        $param_hashtag = "general";
        if(mysqli_stmt_execute($stmt)){
            //mysqli_query($conn,"select ");
            //mysqli_stmt_bind_result($stmt, $pid);
            //while(mysqli_stmt_fetch($stmt)) {
            //    echo $pid;
            $result_id = mysqli_query($conn,"select last_insert_id()");
            while($row = mysqli_fetch_assoc($result_id)) {
                $pid = $row[0];
            }
            mysqli_stmt_close($stmt);
            //}
        } else {echo "problem occured0";}
    } else { echo "problem occured".mysqli_error($conn);}
}

if(isset($_GET["id_for_delete"])) {
    $id_for_delete = $_GET["id_for_delete"];
    if($_SESSION["username"]==$_GET["username_for_delete"]){
    mysqli_query($conn,"delete from posts where pid = $id_for_delete");
    } 
}
/*
if($_SERVER["REQUEST_METHOD"] === "POST"){
    echo "helloooo";
    if(isset($_POST["delete"])) {
        echo "yes";
    } else { echo "no";}
    if(isset($_POST["delete"])) {
        echo "hello";
        $sql = "delete from posts where pid = ?";
        if($stmt = mysqli_prepare($conn, $sql)) {
            mysqli_stmt_bind_param($stmt, "i", $param_pid);
            //$param_pid = $row_pid;
            echo "hello";
            $param_pid = $pid;
            echo $pid;
            if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_close($stmt);
            } else {echo "problem occured";}
        } else {echo "problem occured";}
    } else {

    }
}*/
//if($_REQUEST["delete"]) {
//    echo "hello";
//    $sql = "delete from posts where post = ?";
//    if($stmt = mysqli_prepare($conn, $sql)) {
//        mysqli_stmt_bind_param($stmt, "i", $param_pid);
//        //$param_pid = $row_pid;
//        if(mysqli_stmt_execute($stmt)){} else {echo "problem occured";}
//    } else {echo "problem occured";}
//}
function get_posts($conn) {
$result = mysqli_query($conn, "select post,pid,uid,username,posts.create_date from posts inner join users where users.id = posts.uid and hashtag = 'general' order by posts.create_date desc limit 100");
echo "<center>";
echo "<style>table,th,td{border:1px solid black;}</style><table style='font:24px sans-serif; width:60%' >";
while($row = mysqli_fetch_assoc($result)) {
    $row_post = $row["post"];
    $row_pid = $row["pid"];
    $row_username = $row["username"];
    $row_date = $row["create_date"];
    echo "<tr><td>$row_username</td><td>$row_post</td><td><a href='?id_for_delete=$row_pid&username_for_delete=$row_username' name='delete'>Delete</a></td></tr>";
}
echo "</table>";
echo "</center>";
}
//get_posts($conn);
//echo mysqli_error($conn);
?>
<script>//function myFunc(){console.log(<?php echo "hello world"?>);}setTimeout(myFunc,1000);</script>
<script>
function get_posts_js() {var get_posts_var = "<?php get_posts($conn);?>"; document.getElementById("pforposts").innerHTML = get_posts_var;console.log("it works")}
window.setInterval(get_posts_js,1000);
</script>
