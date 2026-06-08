<?php 
    require("connect.php");

    $name = $_POST["fname"];
    $surname = $_POST["fsurname"];
    $birth_number = $_POST["fbirth_number"];
    $birth_date = $_POST["fbirth_date"];
    $gender = $_POST["fgender"];
    $phone = $_POST["fphone"];
    $password = md5($_POST["fpassword"]);

    $connection = new DB;
    $connection->insertRelative($name, $surname, $birth_number, $birth_date, $gender, $phone, $password);

    header("Location: login.php");
    exit;
?>