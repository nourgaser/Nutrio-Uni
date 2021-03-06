<?php
// Initialize the session
session_start();
require_once "parse_env.php";
 
// Check if the user is already logged in, if yes then redirect him to profile page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: profile.php");
    exit;
}
 
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$email = $password = "";
$email_err = $password_err = $login_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Check if email is empty
    if(empty(trim($_POST["email"]))){
        $email_err = "Please enter email.";
    } else{
        $email = trim($_POST["email"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate credentials
    if(empty($email_err) && empty($password_err)){
        if ($email === getenv("ADMIN_USERNAME") && $password === getenv("ADMIN_PASSWORD")) {
            session_start();
            $_SESSION["loggedin"] = true;
            $_SESSION["id"] = $id;
            $_SESSION["email"] = $email;
            $_SESSION["admin"] = true;
            header("location: admin.php");
        }
        else {
            // Prepare a select statement
            $sql = "SELECT id, email, password FROM user WHERE email = ?";
            
            if($stmt = mysqli_prepare($link, $sql)){
                // Bind variables to the prepared statement as parameters
                mysqli_stmt_bind_param($stmt, "s", $param_email);
                
                // Set parameters
                $param_email = $email;
                
                // Attempt to execute the prepared statement
                if(mysqli_stmt_execute($stmt)){
                    // Store result
                    mysqli_stmt_store_result($stmt);
                    
                    // Check if email exists, if yes then verify password
                    if(mysqli_stmt_num_rows($stmt) == 1){                    
                        // Bind result variables
                        mysqli_stmt_bind_result($stmt, $id, $email, $hashed_password);
                        if(mysqli_stmt_fetch($stmt)){
                            if(password_verify($password, $hashed_password)){
                                // Password is correct, so start a new session
                                session_start();
                                
                                // Store data in session variables
                                $_SESSION["loggedin"] = true;
                                $_SESSION["id"] = $id;
                                $_SESSION["email"] = $email;                            
                                
                                // Redirect user to profile page
                                header("location: profile.php");
                            } else{
                                // Password is not valid, display a generic error message
                                $login_err = "Invalid email or password.";
                            }
                        }
                    } else{
                        // email doesn't exist, display a generic error message
                        $login_err = "Invalid email or password.";
                    }
                } else{
                    echo "Oops! Something went wrong. Please try again later.";
                }
    
                // Close statement
                mysqli_stmt_close($stmt);
            }
        }
    }
    else echo "Wrong password/email.";
    // Close connection
    mysqli_close($link);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/styles/global.css">
    <link rel="stylesheet" href="/styles/login.css">
    <title>Login</title>
</head>

<body>
    <div class="container">
        <a href="/index.php">
            <img src="/images/logo.svg" alt="logo">
        </a>
        <p style="text-align: center;">Your handy calorie tracking buddy ???</p>
        <form action="login.php" method="POST" class="form">
            <div class="form-input">
                <label for="email">Email</label>
                <input type="email" name="email" id="email">
            </div>
            <div class="form-input">
                <label for="password">Password</label>
                <input type="password" name="password" id="password">
            </div>
            <button class="btn noselect">Login</button>
        </form>
        <p class="bottom-text">Don't have an account? <a href="/register.php">Register</a></p>
    </div>
</body>

</html>