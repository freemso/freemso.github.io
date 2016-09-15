<!DOCTYPE html>
<html>
    <head lang="en">
        <meta charset="UTF-8">
        <title>ICS 课程网站</title>
        <link rel="stylesheet" href="css/heihei.css" type="text/css">
        <script type="text/javascript" src="js/jquery-1.11.2.min.js"></script>
        <script type="text/javascript" src="js/heihei.js"></script>
    </head>
    <body>
        <div id="content">
            <h1 id="title"> ICS </h1>
            <table id="navigation">
                <tr>
                    <td><a href="index.html" class="nav-a">通知</a></td>
                    <td><a href="content.php" class="nav-a">内容</a></td>
                    <td><a href="other.html" class="nav-a">相关</a></td>
                    <td><a href="login.php" class="nav-a">个人</a> </td>
                </tr>
            </table>




            <form id="login-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
                <input type="text" name="userID" placeholder="user ID">
                <input type="password" name="password" placeholder="password">
                <input type="number" name="login" class="hidden-input" value=1>
                <button type="submit" id="btn-login">Login</button>
            </form>


            <table cellspacing="0" id="score-form">
                <tbody>
                    <tr class="table-title">
                        <th>Test</th>
                        <th>Score</th>
                    </tr>

<?php
            function addItem($name, $score) {
                echo "<tr>";
                echo  "<td>".$name."</td>";
                echo  "<td>".$score."</td>";
                echo "</tr>";
            }
?>


            <?php
                $userId = $password = "";

                require_once("db.php");

                session_start();
                if (!array_key_exists("admin", $_SESSION)) $_SESSION["admin"] = false;

                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    $login_op = $_POST["login"];
                    if ($login_op) {
                        $userId = $_POST["userID"];
                        $password = $_POST["password"];

                        test($userId, $password, $conn);
                    } else {
                        $_SESSION["admin"] = false;
                    }
                }

                if ($_SESSION["admin"]) {
                    showAllScore($_SESSION["userID"], $conn);
//                    undisplayForm();
                }



                function test($userID, $password, $conn) {
                    if (!$userID) return;
                    $result = mysqli_query($conn, "SELECT password FROM content WHERE userID=".$userID);
                    if ($row = mysqli_fetch_array($result)) {
                        if ($row['password'] == $password) {
                        //  保持登录
                            $_SESSION["admin"] = true;
                            $_SESSION["userID"] = $userID;
                        } else {
?>
                            <script>
                                $("#btn-login").html("账号密码不匹配, 重试");
                                $("#btn-login").css("color", "red");
                            </script>
<?php
                        }
                    } else {
?>
                        <script>
                            $("#btn-login").html("账号不存在");
                            $("#btn-login").css("color", "red");
                        </script>
<?php
                    }
                }


                function showAllScore($userID, $conn) {
                    $result = mysqli_query($conn, "SELECT lab_arch, lab_perf, lab_mall, lab_prox, test_mid, test_final, hw, note1, note2 FROM content WHERE userID=".$userID);
                    if ($row = mysqli_fetch_array($result)) {
                        addItem("HW (5)", $row['hw']);
                        addItem("note1 (5)", $row['note1']);
                        addItem("note2 (5)", $row['note2']);
                        addItem("Lab_arch (30:35:40+60)", $row['lab_arch']);
                        addItem("Lab_perf (18:47)", $row['lab_perf']);
                        addItem("Lab_mall (20:35:10)", $row['lab_mall']);
                        addItem("Lab_prox (70)", $row['lab_prox']);
                        addItem("Test_mid", $row['test_mid']);
                        addItem("Test_final", $row['test_final']);
                    }
                }



//            mysql_close($con);
//                echo $password;
            ?>
                </tbody>


            </table>


            <form id="change-password-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
                <input type=text id="new-password-input" placeholder="New Password">
                <input type="number" class="hidden-input" name="login" value=0>
                <button type="button" class="btn" id="btn-change-password-submit" onclick="changePassword()" >Submit</button>
            </form>


            <div id="btn-div">
                <button id="btn-change-password" class="btn">修改密码</button>

                <form id="logout-form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                    <input type="number" class="hidden-input" name="login" value=0>
                    <button id="btn-logout" class="btn">登出</button>
                </form>
            </div>


            <?php
            if ($_SESSION["admin"]) {
                ?>
                <script>
                    $("#login-form").css("display","none");
                    $("#score-form").css("display", "table");
                    $("#logout-form").css("display", "table");
                    $("#btn-change-password").css("display", "table");
                </script>
            <?php
            }
            ?>

        </div>


    </body>
</html>