<?php 
require("connect.php");
require("codeGenerator.php");
session_start();
header("Cache-control: private");

if (isset($_POST['fbirth_number'])) {
    $birth_number = $_POST['fbirth_number'];
    $password = md5($_POST['fpassword']);

    $connection = new DB;
    $pswd = $connection->getRelativePswd($birth_number);
    if ($pswd == $password) {
        $_SESSION["user_is_logged"] = 1;
        $_SESSION["user_is_relative"] = 1;
        $_SESSION["user_is_admin"] = 0;
        $_SESSION["birth_number"] = $birth_number;
    }

    $pswd = $connection->getEmployeePswd($birth_number);
    if ($pswd == $password) {
        $_SESSION["user_is_logged"] = 1;
        $_SESSION["user_is_admin"] = 1;
        $_SESSION["birth_number"] = $birth_number;
    }

    if ($_SESSION["user_is_logged"] == 1) {
        header("Location: index.php");
        exit;
    }
}
?>
<!DOCTYPE html>
    <HEAD>
        <TITLE>Virtual Graveyard: Log In</TITLE>
        <link rel="stylesheet" href="css.css">
        <script src="js.js"></script>
    </HEAD>
    <BODY>
        <div class="up"><img class="logo" src="logo.png"></div>
        <div class="left">
            <?php 
                echo codeGenerator::generateMenu();
            ?>
        </div>
        <div class="middle">
            <h1>Log in to your account:</h1>
            <form id="login" action="login.php" method="post">
                <label for="fbirth_number">Birth number:</label><br>
                <input type="text" id="fbirth_number" name="fbirth_number" required><br>
                <label for="fpassword">Password:</label><br>
                <input type="password" id="fpassword" name="fpassword"><br>
                <input type="button" value="Log In" onclick="loginSubmit()"><br>
            </form>
        </div>	
        <div class="right"></div>
    </BODY>
</HTML>