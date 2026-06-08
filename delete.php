<?php 
    session_start();
    header("Cache-control: private");
    require("connect.php");
    if ($_SESSION["user_is_admin"] != 1){
        header("Location: index.php");
        exit();
    }

    if (isset($_POST["bn"])) {
        $connection = new DB;
        $connection->delete($_POST["bn"]);
    }

    header("Location: index.php");
    exit;
?>