<?php
require_once "config.php";

session_start();
 
// Check if the user is already logged in, if yes then redirect him to profile page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: profile.php");
    exit;
}
// Define variables and initialize with empty values
$name = $email = $password = $confirm_password = $birth_day = $weight = $height = $weight_goal = "";
$email_err = $password_err = $confirm_password_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate email
    if (empty(trim($_POST["email"]))) {
        $email_err = "Please enter an email.";
    } elseif (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
        $email_err = "Invalid email format";
    } else {
        // Prepare a select statement
        $sql = "SELECT id FROM user WHERE email = ?";

        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_email);

            // Set parameters
            $param_email = trim($_POST["email"]);

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                /* store result */
                mysqli_stmt_store_result($stmt);

                if (mysqli_stmt_num_rows($stmt) == 1) {
                    $email_err = "This email is already taken.";
                } else {
                    $email = trim($_POST["email"]);
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }

    // Validate password
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter a password.";
    } elseif (strlen(trim($_POST["password"])) < 6) {
        $password_err = "Password must have atleast 6 characters.";
    } else {
        $password = trim($_POST["password"]);
    }

    // Validate confirm password
    if (empty(trim($_POST["password2"]))) {
        $confirm_password_err = "Please confirm password.";
    } else {
        $confirm_password = trim($_POST["password2"]);
        if (empty($password_err) && ($password != $confirm_password)) {
            $confirm_password_err = "Password did not match.";
        }
    }

    // Check input errors before inserting in database
    if (empty($email_err) && empty($password_err) && empty($confirm_password_err)) {

        // Prepare an insert statement
        $sql = "INSERT INTO user (name, email, password, birthday, weight, height, weight_goal) VALUES (?,?,?,FROM_UNIXTIME(?),?,?,?)";

        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            //TODO: also validate name, birthday, height, weight and goal
            mysqli_stmt_bind_param($stmt, "sssiiii", $_POST["name"], $param_email, $param_password, $_POST["birthday"], $_POST["weight"], $_POST["height"], $_POST["goal"]);

            // Set parameters
            $param_email = $email;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Redirect to login page
                header("location: login.php");
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    } else {
        if (!empty($email_err)) echo $email_err;
        if (!empty($password_err)) echo $password_err;
        if (!empty($confirm_password_err)) echo $confirm_password_err;
    }

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
    <link rel="stylesheet" href="/styles/register.css">
    <title>Register</title>
</head>

<body>
    <div class="container">
        <a href="/index.php" class="logo">
            <img src="/images/logo.svg" alt="logo">
        </a>
        <p style="text-align: center;">Your handy calorie tracking buddy █</p>
        <form action="register.php" method="post" class="form">
            <div class="form-input">
                <label for="name">Full Name</label>
                <input type="text" name="name" id="name">
            </div>
            <div class="form-input">
                <label for="email">Email</label>
                <input type="email" name="email" id="email">
            </div>
            <div class="form-input">
                <label for="password">Password</label>
                <input type="password" name="password" id="password">
            </div>
            <div class="form-input">
                <label for="password2">Confirm Password</label>
                <input type="password" name="password2" id="password2">
            </div>
            <div class="form-input">
                <label for="age">Birthday</label>
                <input type="date" name="birthday" id="birthday">
            </div>
            <div class="form-input">
                <label for="weight">Weight</label>
                <input type="number" name="weight" id="weight">
            </div>
            <div class="form-input">
                <label for="height">Height</label>
                <input type="number" name="height" id="height">
            </div>
            <div class="form-input">
                <label for="goal">Weight Goal</label>
                <input type="number" name="goal" id="goal">
            </div>
            <button type="submit" class="btn noselect">Register</button>
        </form>
        <p class="bottom-text">Already have an account? <a href="/login.php">Login</a></p>
    </div>
</body>

<script>
    console.log("<?php echo getenv("DB_URL") ?>");
</script>

</html>