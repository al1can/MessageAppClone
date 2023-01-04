<?php
session_start();

if(!defined("redirect")) {
    header("location: index.html");
    die();
}

require_once "conf.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Main</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body{ font: 14px sans-serif; text-align: center; }
    </style>
</head>
<body>
    <h1 class="my-5">Hi, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>. Welcome to our site.</h1>
    <p>
        <a href="reset-password.php" class="btn btn-warning">Reset Your Password</a>
        <a href="logout.php" class="btn btn-danger ml-3">SIgn Out of Your Account</a>
    </p>
    <p>
        <a href="main.php" class="font: 24px sans-serif;">#Global</a>
        <a href="games.php" class="font: 24px sans-serif;">#Games</a>
    </p>
    <p id="pforposts"></p>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
        <textarea name="post"></textarea>
        <input type="submit" value="Post">
    </form>
</body>
</html>
