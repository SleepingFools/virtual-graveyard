<?php 
    require("codeGenerator.php");
    session_start();
    header("Cache-control: private");
?>

<!DOCTYPE html>
    <HEAD>
        <TITLE>Virtual Graveyard: New User</TITLE>
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
            <h1>New user registration form:</h1>
            <form id="registration" action="registerAction.php" method="post">
                <label for="fname">Name:</label><br>
                <input type="text" id="fname" name="fname" placeholder="Jane"><br>
                <label for="fsurname">Surname:</label><br>
                <input type="text" id="fsurname" name="fsurname" placeholder="Doe"><br>
                <label for="fbirth_number">Birth number:</label><br>
                <input type="text" id="fbirth_number" name="fbirth_number" placeholder="XXXXXX/XXXX"><br>
                <label for="fbirth_date">Date of birth:</label><br>
                <input type="date" id="fbirth_date" name="fbirth_date"><br>
                <label for="fgender">Gender:</label><br>
                <select id="fgender" name="fgender">
                    <option value="X">X</option>
                    <option value="F">F</option>
                    <option value="M">M</option>
                </select><br>
                <label for="fphone">Phone number with country code:</label><br>
                <input type="text" id="fphone" name="fphone" placeholder="+420 XXX XXX XXX"><br>
                <label for="fpassword">Password:</label><br>
                <input type="password" id="fpassword" name="fpassword"><br>
                <label for="fpassword2">Password Again:</label><br>
                <input type="password" id="fpassword2" name="fpassword2"><br>
                <input type="button" value="Register" onclick="registerValidation()"><br>
            </form>
        </div>	
        <div class="right"></div>
    </BODY>
</HTML>