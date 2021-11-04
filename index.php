<?php
session_start();

if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: main.php");
    exit;
}

require_once "conf.php";

$email = $password = "";
$email_err = $password_err = $login_err = "";

if($_SERVER["REQUEST_METHOD"] == "POST") {
    if(empty(trim($_POST["email"]))) {
        $email_err = "Please enter your email!";
    } else {
        $email = trim($_POST["email"]);
    }

    if(empty(trim($_POST["password"]))) {
        $password_err = "Please enter your email!";
    } else {
        $password = trim($_POST["password"]);
    }

    if(empty($email_err) && empty($password_err)) {
    $sql = "select id,email,username,password from users where email = ?";
    if($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "s", $param_email);
        $param_email = trim($_POST["email"]);
        if(mysqli_stmt_execute($stmt)) {
            mysqli_stmt_store_result($stmt);
            if(mysqli_stmt_num_rows($stmt) == 1) {
                mysqli_stmt_bind_result($stmt, $id, $email, $username, $hashed_password);
                if(mysqli_stmt_fetch($stmt)) {
                    if(password_verify($password, $hashed_password)) {
                        // Do stuff
                        session_start();

                        $_SESSION["loggedin"] = true;
                        $_SESSION["id"] = $id;
                        $_SESSION["email"] = $email;
                        $_SESSION["username"] = $username;

                        header("location: main.php");
                    } else {
                        // Password is wrong! Doesn't match with database (correct) password
                        $login_err = "Invalid password!";
                    }
                } else {
                    // Email is wrong! Couldn't find email on database. It doesn't exist
                    $login_err = "Invalid email adress!";
                }
            }
        } else {
            echo "Oops! Something went wrong. Please try again later!";
        }
    }

    mysqli_stmt_close($stmt);
    }
    mysqli_close($conn);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body{ font:14px sans-serif; }
        .wrapper{ width:360px; padding:20px; }
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>Login</h2>
        <p>Please fill in your credentials to login.</p>

        <?php
        if(!empty($login_err)) {
            echo '<div class="alert alert-danger">' . $login_err . '</div>';
        }
        ?>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label>Email</label>
                <input type="text" name="email" class="form-control" <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?> value="<?php echo $email_err; ?>">
                <span class="invalid-feedback"><?php echo $email_err; ?></span>
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control" <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?> value="<?php echo $password_err; ?>">
                <span class="invalid-feedback"><?php echo $password_err; ?></span>
            </div>


            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Login">
            </div>
            <p>Don't have an account? <a href="register.php">Sign up now</a>.</p>
        <form>
    </div>
</body>
<html>
