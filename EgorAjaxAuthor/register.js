$(function () {
    $("#send").on("click",function () {
        reg();
    })
    $("#a_send").on("click",function () {
        enter();
    })
    $("#result").on("click",".btn",function () {
        show();
    })
})
function reg() {
    var name = $("#name").val();
    var login = $("#login").val();
    var tel = $("#tel").val();
    console.log(tel);
    var email = $("#e-mail").val();
    var pass1 = $("#pass1").val();
    var pass2 = $("#pass2").val();
    if(name == "" || name == null &&
    login == "" || login == null &&
    tel == "" || tel == null &&
    email == "" || email == null &&
    pass1 == "" || pass1 == null &&
    pass2 == "" || pass2 == null &&
    pass1 != pass2){
        alert("Неверно заполнены поля!");
    }else{
        $.ajax({
            url:"register.php",
            method:"POST",
            data:{
                name:name,
                login:login,
                tel:tel,
                email:email,
                pass:pass1
            },
            success:function (rez) {
                console.log(rez);
                if(rez == "1"){
                    alert("Вы успешно зарегистрированы!");
                    $("#reg").hide();
                    $("#enter").show();
                    
                }else{
                    alert("Недостаточно данных для регистрации!");
                }
            }
        })
    }
}
function enter() {
    var login = $("#a_login").val();
    var pass = $("#a_pass").val();
    if(login == "" || login == null && pass == "" || pass == null){
        alert("Неверно заполнены поля!");
    }else{
        $.ajax({
            url:"login.php",
            method:"POST",
            data:{
                login:login,
                pass:pass
            },
            success:function (rez) {
                console.log(rez);
                if(rez == "2"){
                    alert("Неверно заполнены поля!");
                }else if(rez == "1"){
                    alert('Неверно введен логин или пароль!')
                }else if(rez == "0"){
                    alert("Ошибка в запросе!");
                }else{
                    alert("Вы авторизировались!");
                    $("#enter").hide();
                    $("#result").html(rez);
                }
            }
        })
    }
}
function show() {
    $.ajax({
        url:"show.php",
        method:"POST",
        data:{
            mode:"show"
        },
        success:function (rez) {
            console.log(rez);
            if(rez == "0"){
                alert("ошибка в запрсе!");
            }else if(rez == "1"){
                alert("что-то не так!");
            }else{
                $("#table").html(rez);
            }
        }
    })
}