<?php
// Initialize the session
session_start();
require_once "config.php";

// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}
if (!isset($_SESSION["admin"])) {
    header("location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/global.css">
    <title>Admin</title>
</head>

<style>
    th,
    td {
        padding-right: 3em;
    }
</style>

<body>
    <h1>Welcome <?php echo $_SESSION["email"] ?> - You are an admin.</h1>
    <table>
        <th>id</th>
        <th>name</th>
        <th>email</th>
        <th>birthdate</th>
        <th>weigth</th>
        <th>height</th>
        <th>goal</th>
        <?php
        $query = "SELECT * FROM user";
        $stmt = mysqli_prepare($link, $query);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        while ($row = mysqli_fetch_array($result, MYSQLI_NUM)) {
            echo "<tr>";
            $i = 0;
            foreach ($row as $r) {
                if ($i !== 3)
                    echo "<td> $r </td>";
                $i++;
            }
            echo "</tr>";
        }

        ?>
    </table>
    <a href="profile.php"><button class="btn noselect">Back</button></a>
    <a href="logout.php"><button class="btn noselect">Logout</button></a>
</body>

</html>