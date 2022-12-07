$(document).ready(function () {
    $('body').on('click', '.verArchivos', function () {
        let src= document.getElementById('imagenmodal');
        $('#imagenmodal').css("width","100%");
        $('#imagenmodal').css("heigth","100%");
        src.setAttribute("src",$(this).attr('aux'));
        $('#parrafo').text($(this).attr('observacion'));

    })


})