<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./styles/global.css">
    <link rel="stylesheet" href="./styles/login.css">
    <title>Login</title>
</head>

<body>
    <div class="container">
        <a href="./index.php">
            <img src="./images/logo.svg" alt="logo">
        </a>
        <p style="text-align: center;">Your handy calorie tracking buddy █</p>
        <form action="login.php" method="post" class="form">
            <div class="form-input">
                <label for="email">Email</label>
                <input type="email" name="email" id="email">
            </div>
            <div class="form-input">
                <label for="password">Password</label>
                <input type="password" name="password" id="password">
            </div>
        </form>
        <button type="button" class="btn noselect">Login</button>
        <p class="bottom-text">Don't have an account? <a href="./register.php">Register</a></p>
    </div>
</body>

</html>