$(function () {
    // alert(123);
    $("#s_country").on("click",function () {
        add_country();
    })
})
function add_country() {
    var formdata = $("#f_add_country").serializeArray();
    console.log(formdata);
    $.post("add_country.php",formdata,function (rez) {
        if(rez.status == "fail"){
            alert(rez.msg);
        }
        if(rez.status == "success"){
            alert(rez.msg);
        }
    },"JSON")
}function add_city() {
    var formdata = $("#")
}
function sel_country() {
    
}