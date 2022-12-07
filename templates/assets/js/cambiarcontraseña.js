$(document).ready(function () {
    $('body').on('click', '.contraseña', function () {
        if ($("#combousuarios").val() == 'Seleccionar Establecimiento') {
            $("#MensajeError1").fadeIn();
            return false;
        }
        if ($("#pass").val() == '') {
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
            })
    })

    $('body').on('change', '.combousuarios', function () {
        $("#MensajeError1").css("display", 'none');
    })


    $('#pass').focus(function(){
        $("#MensajeError").css("display", 'none');

    })
})