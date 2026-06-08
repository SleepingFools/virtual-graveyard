<?php 
    require("codeGenerator.php");
    session_start();
    header("Cache-control: private");

    if ($_SESSION["user_is_admin"] != 1){
        header("Location: index.php");
        exit();
    }
?>

<!DOCTYPE html>
    <HEAD>
        <TITLE>Virtual Graveyard: Employee form</TITLE>
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
            <h1>New employee registration form:</h1>
            <form id="registration" action="eRegisterAction.php" method="post">
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
                <label for="fjob">Job title:</label><br>
                <input type="text" id="fjob" name="fjob" placeholder="Coroner"><br>
                <label for="fsalary">Monthly salary:</label><br>
                <input type="number" id="fsalary" name="fsalary" placeholder="22400"><br>
                <label for="fpassword">Password:</label><br>
                <input type="password" id="fpassword" name="fpassword"><br>
                <label for="fpassword2">Password Again:</label><br>
                <input type="password" id="fpassword2" name="fpassword2"><br>
                <input type="button" value="Register" onclick="eRegisterValidation()"><br>
            </form>
        </div>	
        <div class="right"></div>
    </BODY>
</HTML>