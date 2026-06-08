<?php
    require("connect.php");
    require("codeGenerator.php");
    session_start();
    header("Cache-control: private");

    $search_link = "";

    if (isset($_GET["ftype"]) && $_GET["finput"] != "") {
        $type = htmlspecialchars($_GET["ftype"]);
        $input = htmlspecialchars($_GET["finput"]);
        $search_link = "&ftype=$type&finput=$input";
    }

    $name_link = "DESC";
    $surname_link = "DESC";
    $gender_link = "DESC";
    $birth_number_link = "DESC";
    $birth_date_link = "DESC";
    $date_of_death_link = "DESC";
    $burial_date_link = "DESC";

    if ($_GET["order_by"] == 'ORDER BY name DESC') {
        $name_link = 'ASC';
    }
    elseif ($_GET["order_by"] == 'ORDER BY surname DESC') {
        $surname_link = 'ASC';
    }
    elseif ($_GET["order_by"] == 'ORDER BY gender DESC') {
        $gender_link = 'ASC';
    }
    elseif ($_GET["order_by"] == 'ORDER BY birth_number DESC') {
        $birth_number_link = 'ASC';
    }
    elseif ($_GET["order_by"] == 'ORDER BY birth_date DESC') {
        $birth_date_link = 'ASC';
    }
    elseif ($_GET["order_by"] == 'ORDER BY date_of_death DESC') {
        $date_of_death = 'ASC';
    }
    elseif ($_GET["order_by"] == 'ORDER BY burial_date DESC') {
        $burial_date_link = 'ASC';
    }
?>


<!DOCTYPE html>
    <HEAD>
        <TITLE>Virtual Graveyard</TITLE>
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
            <h1>Search for deceased:</h1>
            <form id="search" action="index.php" method="get">
                <label for="ftype">What do you want to search by?:</label>
                <select id="ftype" name="ftype" onchange="adjustForm(this.value)">
                    <option value="name">Name</option>
                    <option value="surname">Surname</option>
                    <option value="birth_number">Birth number</option>
                    <option value="date_of_death">Date of death</option>
                    <option value="birth_date">Date of birth</option>
                </select>
                <input type="text" id="finput" name="finput">
                <input type="submit" value="Search">
            </form>	

            <h2> <?php if(isset($_SESSION["user_is_logged"]) && $_SESSION["user_is_logged"] == 1 && $_SESSION["user_is_admin"] == 0) 
                {echo "Your relatives buried or about to be buried in the graveyard.";}
                else {echo "All deceased buried in the graveyard.";} ?></h2>

            <table>
                <tr>
                    <th>Name <a href="index.php?order_by=ORDER+BY+name+<?php echo $name_link.$search_link;?>">
                        <img src="<?php echo $name_link;?>.png"></a></th>
                    <th>Surname <a href="index.php?order_by=ORDER+BY+surname+<?php echo $surname_link.$search_link;?>">
                        <img src="<?php echo $surname_link;?>.png"></a></th>
                    <th>Gender <a href="index.php?order_by=ORDER+BY+gender+<?php echo $gender_link.$search_link;?>">
                        <img src="<?php echo $gender_link;?>.png"></a></th>
                    <th>Birth Number <a href="index.php?order_by=ORDER+BY+birth_number+<?php echo $birth_number_link.$search_link;?>">
                        <img src="<?php echo $birth_number_link;?>.png"></a></th>
                    <th>Date of Birth <a href="index.php?order_by=ORDER+BY+birth_date+<?php echo $birth_date_link.$search_link;?>">
                        <img src="<?php echo $birth_date_link;?>.png"></a></th>
                    <th>Date of Death <a href="index.php?order_by=ORDER+BY+date_of_death+<?php echo $date_of_death_link.$search_link;?>">
                        <img src="<?php echo $date_of_death_link;?>.png"></a></th>
                    <th>Date of Burial <a href="index.php?order_by=ORDER+BY+burial_date+<?php echo $burial_date_link.$search_link;?>">
                        <img src="<?php echo $burial_date_link;?>.png"></a></th>
                    <?php 
                        if (isset($_SESSION["user_is_logged"]) && $_SESSION["user_is_admin"] == 1) {
                            echo "<th>Actions</th>";
                        }
                    ?>
                </tr>
                <?php 
                    $connection = new DB;
                    $order_by = "";
                    if(isset($_GET["order_by"])) {
                        $order_by = $_GET["order_by"];
                    }
                    $buried = TRUE;
                    $birth_number = "";
                    if(isset($_SESSION["user_is_logged"])) {
                        $birth_number = $_SESSION["birth_number"];
                        $buried = FALSE;
                        if($_SESSION["user_is_admin"] == 1) {
                            $birth_number = "";
                        }
                    }
                    $search = "";
                    if (isset($_GET["ftype"]) && $_GET["finput"] != "") {
                        $search = $_GET["ftype"] . " LIKE '%" . $_GET["finput"] . "%'";
                    }

                    $result = $connection->getListOfDeceased($order_by, $birth_number, $buried, $search);

                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td class=\"first\">". $row["name"] ."</td>";
                            echo "<td>". $row["surname"] ."</td>";
                            echo "<td>". $row["gender"] ."</td>";
                            echo "<td>". $row["birth_number"] ."</td>";
                            echo "<td>". $row["birth_date"] ."</td>";
                            echo "<td>". $row["date_of_death"] ."</td>";
                            $burried = $row["burial_date"];
                            if ($burried === NULL) {
                                $burried = "Not yet";
                            }
                            echo "<td>". $burried ."</td>";
                            if ($_SESSION["user_is_admin"] == 1) {
                                $birth_number = $row["birth_number"];
                                echo "<td><form onsubmit=\"return confirm('Do you really want to mark buried?');\" action=\"bury.php\" method=\"POST\">
                                <input type=\"hidden\" id=\"bn\" name=\"bn\" value=\"$birth_number\">
                                <input type=\"submit\" value=\"mark buried\"></form>
                                <form onsubmit=\"return confirm('Do you really want to submit the form?');\" action=\"delete.php\" method=\"POST\">
                                <input type=\"hidden\" id=\"bn\" name=\"bn\" value=\"$birth_number\">
                                <input type=\"submit\" value=\"delete\"></form>" ."</td>";
                            }
                            echo "</tr>";
                        }
                    }
                ?>
            </table>
        </div>
        <div class="right"></div>
    </BODY>
</HTML>