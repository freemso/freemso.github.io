<!DOCTYPE html>
<html>
    <head lang="en">
        <meta charset="UTF-8">
        <title>ICS 课程网站</title>

        <link rel="stylesheet" href="css/font-awesome-4.5.0/css/font-awesome.min.css" type="text/css" >
        <link rel="stylesheet" href="css/radiocheck.css" type="text/css">
        <link rel="stylesheet" href="css/heihei.css" type="text/css">
        <script type="text/javascript" src="js/jquery-1.11.2.min.js"></script>
        <script type="text/javascript" src="js/heihei.js"></script>
    </head>
    <body>


   <?php
        $content = array();
        $scored = array();
        require_once("db.php");
        session_start();
        if (!array_key_exists("admin", $_SESSION)) $_SESSION["admin"] = false;


       if ($_SESSION["admin"]) {
               //get json type list scored.
               $result = mysqli_query($conn, "SELECT scored FROM content WHERE userID=" . $_SESSION["userID"]);
               $row = mysqli_fetch_array($result);
               $scored = json_decode($row["scored"], true);
           }




        //Time PPT HW Lab Note Score
        function addItem($time, $ppt, $hw, $lab, $note) {
            global $content;
            $content[count($content)] =  array($time, $ppt, $hw, $lab, $note);
        }

        function showContent($content, $scored) {
            $pre_s = array("ppt", "hw", "lab", "note");

            for ($i=0; $i<count($content); $i++) {
                //time
                echo "<tr><td>".$content[$i][0]."</td>";

                //ppt hw lab note
                for ($j=1; $j<5; $j++) {
                    echo "<td> ";
                    for ($k=0; $k<count($content[$i][$j]); $k++) {
                        $tmp = "";
                        if ($content[$i][$j]) $tmp = $content[$i][$j][$k];
                        echo "<a href='file/" . $pre_s[$j - 1] . "/" . $tmp . "'>" . $tmp . "</a>";
                    }
                    echo "</td>";
                }

                echo "<td class='score-item'>";

                if (($_SESSION["admin"]) && ($scored) &&  (array_key_exists("N".$i, $scored))) {
                    echo "<label class='full small right selected'>".$scored["N".$i]."</label>";
                } else for ($j=1; $j<6; $j++)
                    //score
                    echo "<div class='radio-item'><input type='radio' class='radiocheck'
                            name='score-" . $i . "' id='score-id-" . $i . "-".$j."' value=".$j.">
                        <label class='radio-score full small right' for='score-id-" . $i . "-".$j."'>".$j."</label>
                        </div>";
                "</td>";

                echo "</tr>";
            }
        }
   ?>
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
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST" id="content-form">
                <table cellspacing="0">
                    <tr>
                        <th>Time</th>
                        <th>PPT</th>
                        <th>Homework</th>
                        <th>Lab</th>
                        <th>Notes</th>
                        <th><button id="btn-score-submit" class="btn" type="button" onclick="updateScore()">Submit</button></th>

                        <?php
                        if (!$_SESSION["admin"]){
                        ?>
                            <script>$("#btn-score-submit").css("display","none");</script>
                        <?php
                        }
                        ?>
                    </tr>

                    <?php
                        addItem("", "", "", "", array("ICS笔记－李逢双.pdf","Note%2020140303.doc"));
                        addItem("3/1 Tuesday", array("class1a.pdf"), "", "", "");
                        addItem("3/3 Thursday", array("class2-logic.pdf"), "", "", array("ISA_LOGIC.docx"));
                        addItem("3/8 Tuesday", "", array("HW1.pdf"), "", array("LOGIC2.docx"));
                        addItem("3/10 Thursday", array("class3-sequential.pdf"), "", array("archlab-handout.tar"), array("SEQ.docx"));
                        addItem("3/15 Tuesday", "", "", "", array("SEQ2.docx"));
                        addItem("3/17 Thursday", array("class4-pipeline-a.pdf"), array("HW2.pdf"), "", array("Note0317.docx"));
                        addItem("3/22 Tuesday", array("class5-pipeline-b.pdf"), "", "", array("3_22.docx"));
                        addItem("3/24 Thursday", "", "", "", array("3_24.docx"));
                        addItem("3/29 Tuesday", "", "", "", array("3_29.docx"));
                        addItem("3/31 Thursday", array("class6-wrapup.pdf"), "", "", array("3_31.docx"));
                        addItem("4/5 Tuesday", "", "", "", array("4_5.doc"));
                        addItem("4/5 Tuesday", "", "", "", array("4_5_补档_多记系列.docx"));
                        addItem("4/7 Thursday", array("25-optimization.pdf"), array("HW3.pdf"), "", array("4_7.doc"));
                        addItem("4/12 Tuesday", "", "", array("perflab-handout.tar"), array("4_12.doc"));
                        addItem("4/14 Thursday", array("waside-simd.pdf", "waside-blocking.pdf", "waside-optimized-code.pdf"), "", "", array("4_14.docx"));
                        addItem("4/19 Tuesday", array("4_19.pptx", "15-vm-concepts.pdf"), "", "", array("4_19.docx"));
                        addItem("4/21 Thursday", "", "", "", "");
                        addItem("4/26 Tuesday", "", "",  "", array("4_26.docx"));
                        addItem("4/28 Thursday", array("16-vm-systems.pdf"), "", "", array("4_28.docx"));
                        addItem("5/3 Tuesday", array("17-allocation-basic.pdf"), array("HW4.pdf", "5_19.pptx"), array("malloclab-handout.tar"), array("5_3.docx"));
                        addItem("5/5 Thursday", "", "", "", array("5_5.docx"));
                        addItem("5/10 Tuesday", "", "", "", array("5_10.docx"));
                        addItem("5/12 Thursday", array("18-allocation-advanced.pdf"), "", "", array("5_12.docx"));
                        addItem("5/17 Tuesday", array("19-allocation-advanced.pptx"), array("hw5.pdf", "hw5_sol.docx"), "", array("5_17.docx"));
                        addItem("5/24 Tuesday", array("19-internet.pdf"), "", "", array("5_24.docx"));
                        addItem("5/26 Thursday", array("20-network-programming.pdf"), "", array("proxylab-handout.tar"), array("5_26.docx"));
                        addItem("5/31 Tuesday", "", "", "", array("5_31.docx"));
                        addItem("6/2 Thursday", array("21-webservices.pdf"), "", "", array("6_2.docx"));
                        addItem("6/7 Tuesday", array("22-concurrent-programming.pdf"), "", "", array("6.7.docx"));
                        addItem("6/14 Tuesday", array("23-sync-basic.pdf"), "", "", "");
                        addItem("6/16 Thursday", array("24-sync-advanced.pdf"), "", "", array("6.16.docx"));
                        showContent($content, $scored);


                    ?>


                </table>
            </form>
        </div>
    </body>
</html>


<script>
    function updateScore() {
        var num = <?php echo count($content); ?>;
        var list = <?php echo json_encode($scored); ?>;
        for (var i=1; i<num; i++) {
            var tmp = $("input[name="+"score-"+i+"]:checked").val();
            if (tmp) list["N"+i] = tmp;
        }
        $.post("updateScore.php", {"scored": list} ,function(data){
            $("#content-form").submit();
        });
    }
</script>
