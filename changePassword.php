<?php

    header("Content-type:text/html;charset=utf-8");

    session_start();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $userID = $_SESSION["userID"];
        $password = $_POST["password"];

        require_once("db.php");

        mysqli_query($conn, "UPDATE content SET password = ".$password." WHERE userID=".$userID);

        mysqli_close($conn);

        $_SESSION["admin"] =false;

        echo json_encode(array("userID"=>$userID, "password"=>$password));
    }
?>