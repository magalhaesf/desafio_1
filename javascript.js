$(document).ready(function(){
    $('#cpf').mask('000.000.000-00');
    $('#cpf').keyup(function() {
        $('#cpf').mask('000.000.000-00');
    });
    $('#frmLogin').submit(function(e){
        e.preventDefault();
        $.ajax({
            url : "login.php",
            type : 'POST',
            data : $(this).serialize()
        })
        .done(function(msg){
            if (msg == 1) {
                window.location.href = "sys/";
            } else {
                alert('CPF ou senha invalidos');
            }
        })
        .fail(function(jqXHR, textStatus, msg){
            alert(msg);
        }); 
    });
});
