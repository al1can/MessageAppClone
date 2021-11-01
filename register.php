<?php
require "conf.php";

$username = $password = $confirm_password = $email = "";
$username_err = $password_err = $confirm_password_err = $email_err = "";

if($_SERVER["REQUEST_METHOD"] == "POST" ) {
	if(empty(trim($_POST["email"]))) {
		$email_err = "Please enter an email";
	} elseif(!filter_var($trim($_POST["email"], FILTER_VALIDATE_EMAIL)) {
		$email_err = "Please enter a valid email";
	} else {
		$sql = "select email from users where email = ?";
		if($stmt = mysqli_prepare($conn, $sql)) {	
			mysqli_stmt_bind_param($stmt, "s", $param_email);
			$param_email = trim($_POST["email"]);
			if(mysqli_stmt_execute($stmt)) {
				mysqli_stmt_store_result($stmt);
				if(mysqli_stmt_num_rows($stmt) == 1) {
					$email_err = "This email is associated with an already existing account.";
				} else {
					$email = trim($_POST["email"]);
				}
			} else {
				echo "Oops! Something went wrong. Please try again later.";
			}
			mysqli_stmt_close($stmt);
		}
	}

	if(empty(trim($_POST["username"]))) {
		$username_err = "Please enter an username.";
	} elseif(!preg_match("/^[a-zA-Z0-9_ ]+$/", trim($_POST["username"]))) {
		$username_err = "Username can only contain letters, numbers, underscores and white spaces";
	} else {
		$sql = "select id from users where username = ?";
		if($stmt = mysqli_prepare($conn, $sql)) {
			mysqli_stmt_bind_param($stmt, "s", $param_username);
			$param_username = trim($_POST["username"]);
			if(mysqli_stmt_execute($stmt)) {
				mysqli_stmt_store_result($stmt);
				if(mysqli_stmt_num_rows($stmt) == 1) {
					$username_err = "This username is taken.";
				} else {
					$username = trim($_POST["username"]);
				}
			} else {
				echo "Oops! Something went wrong. Please try again later.";
			}
			mysqli_stmt_close($stmt);
		}
	}

	if(empty(trim($_POST["password"]))) {
		$password_err = "Please enter a password!";
	} elseif(strlen(trim($_POST["password"])) < 6) {
		$password_err = "Password must have at least 6 characters!";
	} elseif(!preg_match("/^[0-9]+$/", trim($_POST["password"]))) {
		$password_err = "Password must contain at least 1 number!";
	} elseif(!preg_match("/^[a-zA-Z]+$/", trim($_POST["password"]))) {
		$password_err = "Password must contain at least 1 letter!";
	} else {
		$password = trim($_POST["password"]);
	}

	if(empty(trim($_POST["confirm_password"]))) {
		$confirm_password = "You need to confirm your password!";
	} else {
		$confirm_password = trim($_POST["confirm_password"]);
		if(empty($password_err) && ($password != $confirm_pasword)) {
			$confirm_password_err = "Password did not match.";
		}
	}

	if(empty($email_err) && empty($username_err) && empty($password_err) & empty($confirm_password_err)) {
		$sql = "insert into users (email, username, password)";
		if($stmt = mysqli_prepare($conn, $sql)) {
			mysqli_stmt_bind_param($stmt, "ss", $param_email, $param_username, $param_password)
		$param_email = $email;
		$param_username = $username;
		$param_password = password_hash($password, PASSWORD_DEFAULT);

		if (mysqli_stmt_execute($stmt)) {
			echo "Your account has been succesfully created!";
			header("location: index.php");
		} else {
			echo "Oops! Something went wrong. Please try again later.";
		}

		mysqli_stmt_close($stmt);
		}
	}
	mysqli_close($conn);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Sign up</title>
	<link> rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<style>
		body{font:14px sans-serif; }
		.wrapper{width:360px; padding:20px;}
	</style>
</head>
<body>
	<div class="wrapper">
		<h2>Sign Up</h2>
		<form action="<?php echo htmlspeacialchars($_SERVER["PHP_SELF"]); ?>" method="post">
			<div class="form-group">
				<label>Email</label>
				<input type="text" name="email" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>">
                		<span class="invalid-feedback"><?php echo $email_err; ?></span>
        		</div>
			<div class="form-group">
				<label>Username</label>
				<input type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
				<span class="invalid-feedback"><?php echo $username_err; ?></span>
            		</div>    
            		<div class="form-group">
                		<label>Password</label>
		                <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>">
                		<span class="invalid-feedback"><?php echo $password_err; ?></span>
			</div>
            		<div class="form-group">
                		<label>Confirm Password</label>
		                <input type="password" name="confirm_password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $confirm_password; ?>">
                		<span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
			</div>
			<div class="form-group">
		                <input type="submit" class="btn btn-primary" value="Submit">
                		<input type="reset" class="btn btn-secondary ml-2" value="Reset">
            		</div>
				<p>Already have an account? <a href="login.php">Login here</a>.</p>
        	</form>
    	</div>    
</body>
</html>
