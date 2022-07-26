$(function () {
    // alert(1);
    $("#send").on("click",function () {
        add();
    })
})
function add() {
    var formdata = $("#form").serializeArray();
    $.post("birthday.php",formdata,function (rez) {
        alert(rez);
    },"JSON");
}