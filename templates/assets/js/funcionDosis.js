$(document).ready(function(){
    $('body').on('change','.comboboxRegistrar',function(){
        //$('body').off();
        $.ajax(
            {
            url:'/public_html/Functions/ObtenerProporcion.php',
            method:"POST",
            data:{
                proporcion:$("#DetalleBiologico").val(),
            }
        }).done(function(res){
            
            $("#ingreso").val("");
            $("#ingresoextra").val("");
            $("#dosis").val("");
            $("#frascoabierto").val("");
            $("#lote").val("");
            $("#stock").val("");
            
            console.log(res);
            if(res!=1){
                $("#dosis").css("pointer-events","visiblePainted"); 
                $("#dosis").css("background","white"); 
            }
            else{
                $("#dosis").css("pointer-events","none"); 
                $("#dosis").css("background","rgb(161, 160, 161)");

            }
            $.ajax(
                {
                url:'/public_html/Functions/PasarDatosBiologicos.php',
                method:"POST",
                data:{
                    aux:$("#DetalleBiologico").val(),
                }
            }).done(function(res){
                let arraybio=JSON.parse(res);
                if(arraybio.length>0){
                $("#stock").css("pointer-events","none"); 
                $("#stock").css("background","rgb(161, 160, 161)");
                }
                else{
                    $("#stock").css("pointer-events","visiblePainted"); 
                    $("#stock").css("background","white");
                }

            });

        });

    })

    $('#frascoabierto').focusout('.frascoabiertos',function(){
        $.ajax(
            {
            url:'/public_html/Functions/ObtenerProporcion.php',
            method:"POST",
            data:{
                proporcion:$("#DetalleBiologico").val(),
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
            /*$.ajax(
                {
                url:'/public_html/Functions/PasarDatosBiologicos.php',
                method:"POST",
                data:{
                    aux:$("#DetalleBiologico").val(),
                }
            }).done(function(res){
                let arraybio=JSON.parse(res);
                if(arraybio.length>0){
               
                }
                else{
                   
                }

            });*/



        });

    })

    $('body').on('click','.agregaDetalle',function (){
        if($("#DetalleBiologico").val()=="SELECCIONAR UN BIOLOGICO"){
            $("#MensajeError").fadeIn();
            return false;
        }
    })

    $('#lote').focus('.lotes',function(){
        $.ajax(
            {
            url:'/public_html/Functions/PasarDatosBiologicos.php',
            method:"POST",
            data:{
                aux:$("#DetalleBiologico").val(),
                lote:$("#lote").val(),  
            }
        }).done(function(res){
            let lotes=JSON.parse(res);
            console.log(lotes);
            if(lotes!=null){
                $("#lote").autocomplete({
                    source : lotes
                });
            }
        });

    })

    $('#lote').focusout('.lotes',function(){
        $.ajax(
            {
            url:'/public_html/Functions/PasarDatosBiologicos.php',
            method:"POST",
            data:{
                aux:$("#DetalleBiologico").val(),
            }
        }).done(function(res){
            let arraybio=JSON.parse(res);
            let bool=false;
            let stock;
            for(let i=0;i<arraybio.length;i++){
                if($("#lote").val()==arraybio[i]["LoteBiologicoDescripcion"]){
                    bool=true;  
                    stock=arraybio[i]["UsuarioBiologicoStock"];
                    break;
                } 
            }
            if(bool){
                $("#stock").css("pointer-events","none"); 
                $("#stock").css("background","rgb(161, 160, 161)");
                $("#stock").val(stock);
            }else{
                $("#stock").css("pointer-events","visiblePainted"); 
                $("#stock").css("background","white");
            }

            
        });

    })

    
})