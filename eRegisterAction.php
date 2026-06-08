<?php 
    require("connect.php");

    $name = $_POST["fname"];
    $surname = $_POST["fsurname"];
    $birth_number = $_POST["fbirth_number"];
    $birth_date = $_POST["fbirth_date"];
    $gender = $_POST["fgender"];
    $job = $_POST["fjob"];
    $salary = $_POST["fsalary"];
    $password = md5($_POST["fpassword"]);

    $connection = new DB;
    $connection->insertEmployee($name, $surname, $birth_number, $birth_date, $gender, $job, $salary, $password);

    header("Location: login.php");
    exit;
?>