<?php

    header("Content-type:text/html;charset=utf-8");

    session_start();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $userID = $_SESSION["userID"];
        $scored = $_POST["scored"];

        require_once("db.php");

        mysqli_query($conn, "UPDATE content SET scored = '".json_encode($scored)."' WHERE userID=".$userID);

        mysqli_close($conn);

        echo json_encode(array("userID"=>$userID, "scored"=>$scored));
    }
?>