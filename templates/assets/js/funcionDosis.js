$(document).ready(function(){
    $('body').on('change','.comboboxRegistrar',function(){
        //$('body').off();
        $.ajax(
            {
            url:'/public_html/Functions/PasarDatosBiologicos.php',
            method:"POST",
            data:{
                aux:$("#DetalleBiologico").val(),
            }
        }).done(function(res){
            console.log(res);
            $("#dosis").val("");
            $("#frascoabierto").val("");
            if(res!=1){
                $("#dosis").css("pointer-events","visiblePainted"); 
                $("#dosis").css("background","white"); 
    

            }
            else{
                $("#dosis").css("pointer-events","none"); 
                $("#dosis").css("background","rgb(161, 160, 161)");

            }
        });

    })

    $('input').focusout('.frascosDosis',function(){
        $.ajax(
            {
            url:'/public_html/Functions/PasarDatosBiologicos.php',
            method:"POST",
            data:{
                aux:$("#DetalleBiologico").val(),
            }
        }).done(function(res){
            let link = document.getElementById("dosis");

            if(res!=1){
                let canDosis=$("#frascoabierto").val()*res;
                link.setAttribute("max",canDosis);
            }
            else{
                
                $("#dosis").val($("#frascoabierto").val());
                link.setAttribute("max","1000");
            }
        });

    })
<<<<<<< HEAD
   
=======

    $('body').on('click','.agregaDetalle',function (){
        if($("#DetalleBiologico").val()=="SELECCIONAR UN BIOLOGICO"){
            $("#MensajeError").fadeIn();
            return false;
        }
    })
>>>>>>> d969e531ca3981503e80b21a36942b39b560c60b
    
})