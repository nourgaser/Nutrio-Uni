<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./styles/global.css">
    <link rel="stylesheet" href="./styles/register.css">
    <title>Register</title>
</head>

<body>
    <div class="container">
        <a href="./index.php" class="logo">
            <img  src="./images/logo.svg" alt="logo">
        </a>
        <p style="text-align: center;">Your handy calorie tracking buddy █</p>
        <form action="register.php" method="post" class="form">
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
        <p class="bottom-text">Already have an account? <a href="./login.php">Login</a></p>
    </div>
</body>

</html>