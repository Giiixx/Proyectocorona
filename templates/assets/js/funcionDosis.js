$(document).ready(function(){
    $('body').on('change','.comboboxRegistrar',function(){
        $.ajax(
            {
            url:'/public_html/Functions/PasarDatosBiologicos.php',
            method:"POST",
            data:{
                aux:$("#DetalleBiologico").val(),
            }
        }).done(function(res){
            var link = document.getElementById("dosis");

            if(res!=1){
                let canDosis=$("#frascoabierto").val()*res;

                $("#dosis").css("pointer-events","visiblePainted"); 
                $("#dosis").css("background","white"); 
                link.setAttribute("max",canDosis);
            }
            else{
                $("#dosis").css("pointer-events","none"); 
                $("#dosis").css("background","rgb(161, 160, 161)");
                $("#dosis").val($("#frascoabierto").val());

            }
        });

    })
})