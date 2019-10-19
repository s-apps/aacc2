var base_url = "http://localhost:8000/";
// var base_url = "https://silverio.herokuapp.com/";

$(function(){
    $(".btn-login-loading").hide();
});

$("#frmLogin").on("submit", function(){
    var email = $("#email").val();
    var senha = $("#senha").val();
    $(".btn-login-loading").show();
    $("#email").removeClass("is-invalid");
    $("#senha").removeClass("is-invalid");
    if(camposValidos(email, senha)){    
        $.post({
            url: base_url + "login/entrar",
            dataType: "JSON",
            data: { email: email, senha: senha }
        })
        .done(function(data){
            if(data.sucesso){
                window.location.href = base_url + "area";
            }else{
                $("#loginErro").text("Email ou Senha inválidos");
            }
            $(".btn-login-loading").hide();
        });
    }else{
        $(".btn-login-loading").hide();
    }
    return false;
});

$("#esqueceuSenha").on("click", function(){
    console.log("esqueceu a senha");
});

function camposValidos(email, senha){
    var regexEmail = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/;
    if(email.length === 0){
        $("#email").addClass("is-invalid");
        $("#email").focus();
        return false;
    }else if(!regexEmail.test(email)){
        $("#email").addClass("is-invalid");
        $("#email").focus();
        return false;
    }else if(senha.length === 0){
        $("#senha").addClass("is-invalid");
        $("#senha").focus();
        return false;
    }
    return true;
}