/**
 * Created by ct on 2016/3/3.
 */

 $(function() {
    /* For zebra striping */
    $("table tr:nth-child(odd)").addClass("odd-row");
    /* For cell text alignment */
    $("table td:first-child, table th:first-child").addClass("first");
    /* For removing the last border */
    $("table td:last-child, table th:last-child").addClass("last");


     $("#btn-change-password").click(function () {
         if ($("#change-password-form").css("display") == "none")
            $("#change-password-form").css("display", "table");
         else
             $("#change-password-form").css("display", "none");
     })
});


function changePassword() {
    var pass = $("#new-password-input").val();
    if (!pass) return;
    var cont = {password : pass};
    $.post("changePassword.php", cont ,function(data){
        //var res = eval("(" + data + ")");//转为Object对象
        //console.log(res.userID);

        $("#change-password-form").submit();
    });
}
