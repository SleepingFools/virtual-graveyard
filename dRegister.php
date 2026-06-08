<?php 
    require("codeGenerator.php");
    session_start();
    header("Cache-control: private");

    if ($_SESSION["user_is_relative"] != 1){
        header("Location: index.php");
        exit();
    }
?>

<!DOCTYPE html>
    <HEAD>
        <TITLE>Virtual Graveyard: Deceased form</TITLE>
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
            <h1>Request burial of deceased relative form:</h1>
            <form id="registration" action="dRegisterAction.php" method="post">
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
                <label for="fdeath_date">Date of death:</label><br>
                <input type="date" id="fdeath_date" name="fdeath_date"><br>
                <input type="hidden" id="frelative_birth_number" name="frelative_birth_number" value="<?php echo $_SESSION["birth_number"]; ?>">
                <input type="button" value="Register" onclick="dRegisterValidation()"><br>
            </form>
        </div>	
        <div class="right"></div>
    </BODY>
</HTML>