$(document).ready(function(){
    $('body').on('click','.contraseña',function () {

        if( $("#pass").val()==''){
            $("#MensajeError").fadeIn();
            return false;
        }

        $.ajax(
            {
                url: '../../Functions/ChangePassUsuario.php',
                method: "POST",
                data: {
                    establecimiento: $("#combousuarios").val(),
                    contra: $("#pass").val(),
                }
            }).done(function (res) {
                console.log(res )

                if(res){
                    $("#MensajeError").css("display",'none');
                    
                }else{
                    $("#MensajeError").fadeIn();
                }

            }); 
        })
})