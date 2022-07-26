$(function () {
    // alert(123);
    $("#send").on("click",function () {
        reg();
    })
    $("#a_send").on("click",function () {
        log2();
    })
    $("#result").on("click",".btn",function () {
        show();
    })
    $("#clear").on("click",function () {
        // alert(1);
        clear();
    })
})
function reg() {
   // var formdata = $("#f_reg").serialize();//Функция позволяет получить данные сразу с каждого элемента инпут формы в виде строки где первым значением будет атрибут нэйм элемента инпут а после равно данные котороые ввел пользователь
    var formdata = $("#f_reg").serializeArray();//Функция возвращает массив обьектов поле - значение что из себя предствляет JSON формат данных
    console.log(formdata);
    $.ajax({
        url:"register2.php",
        method:"post",
        data:formdata,
        dataType:"JSON",
        success:function (rez) {
            console.log(rez);
            if(rez.status == "fale"){
                alert(rez.msg);
            }
            if(rez.status == "success"){
                alert(rez.msg);
            }
        }
    })
}
function log(){
    var formdata = $("#f_log").serializeArray();
    console.log(formdata);
    $.getJSON("login2.php",formdata,function (rez) {
        if(rez.status == "fail"){
            alert(rez.msg);
        }
        $("#result").html("<h2>Добро пожаловать, "+rez.name+"!</h2><p>Ваше имя - "+rez.name+"</p><p>Ваш телефон - "+rez.tel+"</p><p>Ваш эмайл - "+rez.email+"</p>");
    });
}
function log2() {
    var formdata = $("#f_log").serializeArray();
    console.log(formdata);
    $.post("login3.php",formdata,function (rez) {
        if(rez.status == "fail"){
            alert(rez.msg);
        }
        $("#result").html("<h2>Добро пожаловать, "+rez.name+"!</h2><p>Ваше имя - "+rez.name+"</p><p>Ваш телефон - "+rez.tel+"</p><p>Ваш эмайл - "+rez.email+"</p><p><button class='btn' id='show'>Показать</button></p>");
    },"JSON");
}
function show() {

    $.post("show2.php",
        "mode=show",
        function (rez) {
            $("#tbody").empty();
        if(rez.status == "fail"){
            alert(rez.msg);
        }
        if(rez.users.length > 0){
            $(rez.users).each(function () {
                // alert(1);
                $("#tbody").append("<tr><td>"+this.num+"</td><td>"+this['name']+"</td><td>"+this.tel+"</td><td>"+this.email+"</td>");

            })
        }
    },"JSON");
}
function clear() {
$("#name").val("");
$("#login").val("");
$("#tel").val("");
$("#e-mail").val("");
$("#pass1").val("");
$("#pass2").val("");
}