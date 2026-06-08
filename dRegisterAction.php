<?php 
    require("connect.php");

    $name = $_POST["fname"];
    $surname = $_POST["fsurname"];
    $birth_number = $_POST["fbirth_number"];
    $birth_date = $_POST["fbirth_date"];
    $gender = $_POST["fgender"];
    $death_date = $_POST["fdeath_date"];
    $relative_birth_number = $_POST["frelative_birth_number"];

    $connection = new DB;

    if ($connection->insertDeceased($name, $surname, $birth_number, $birth_date, $gender, $death_date, $relative_birth_number)) {
        header("Location: index.php");
        exit;
    }
?>