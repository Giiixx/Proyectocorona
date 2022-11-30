$(document).ready(function () {
    $('body').on('change', '.comboboxRegistrar', function () {
        //$('body').off();
        $.ajax(
            {
                url: '../../Functions/ObtenerProporcion.php',
                method: "POST",
                data: {
                    proporcion: $("#DetalleBiologico").val(),
                }
            }).done(function (res) {

                $("#ingreso").val("");
                $("#ingresoextra").val("");
                $("#dosis").val("");
                $("#frascoabierto").val("");
                $("#lote").val("");
                $("#stock").val("");
                $("#stockIngreso").val("");
                $("#devolucion").val("");
                $("#salidaTotal").val("");
                $("#stockNuevo").val("");
                $("#expiracion").val("");
                $("#requerimientos").val("");
                $("#observaciones").val("");
                $("#MensajeError").css("display", "none");
                $("#lote").autocomplete({
                    source: ""
                });
                if (res != 1) {
                    $("#dosis").css("pointer-events", "visiblePainted");
                    $("#dosis").css("background", "white");
                }
                else {
                    $("#dosis").css("pointer-events", "none");
                    $("#dosis").css("background", "rgb(161, 160, 161)");

                }
                
                $.ajax(
                    {
                        url: '../../Functions/PasarDatosBiologicos.php',
                        method: "POST",
                        data: {
                            aux: $("#DetalleBiologico").val(),
                        }
                    }).done(function (res) {
                        let arraybio = JSON.parse(res);
                        if (arraybio) {
                            $("#stock").css("pointer-events", "none");
                            $("#stock").css("background", "rgb(161, 160, 161)");
                            $("#stock").val(arraybio['UsuarioBiologicoStock']);
                            
                        }
                        else {
                            $("#stock").css("pointer-events", "visiblePainted");
                            $("#stock").css("background", "white");
                        }

                    });

            });

    })

    $('#frascoabierto').focusout('.frascoabiertos', function () {
        $.ajax(
            {
                url: '../../Functions/ObtenerProporcion.php',
                method: "POST",
                data: {
                    proporcion: $("#DetalleBiologico").val(),
                }
            }).done(function (res) {
                let link = document.getElementById("dosis");
                if (res != 1) {
                    let canDosis = $("#frascoabierto").val() * res;
                    link.setAttribute("max", canDosis);
                }
                else {

                    $("#dosis").val($("#frascoabierto").val());
                    link.setAttribute("max", "1000");
                }
                
            });

    })

    

    $('#lote').focus(function () {
        $.ajax(
            {
                url: '../../Functions/ObtnerDatosLote.php',
            }).done(function (res) {
				
                try{
                    let lotes = JSON.parse(res);
					for(let i=0;i<lotes.length;i++){
						lotes[i]=lotes[i].toUpperCase();
					}				
                    $("#lote").autocomplete({
                        source: lotes
                    });

                }catch{

                }
                
                
            });

    })

    /*

    $('#lote').focusout('.lotes', function () {
        $("#ingreso").val("");
        $("#ingresoextra").val("");
        $("#stockIngreso").val("");
        $.ajax(
            {
                url: '../../Functions/PasarDatosBiologicos.php',
                method: "POST",
                data: {
                    aux: $("#DetalleBiologico").val(),
                }
            }).done(function (res) {
                let arraybio = JSON.parse(res);
                let bool = false;
                let stock;
                for (let i = 0; i < arraybio.length; i++) {
                    if ($("#lote").val() == arraybio[i]["LoteBiologicoDescripcion"]) {
                        bool = true;
                        stock = arraybio[i]["UsuarioBiologicoStock"];
                        break;
                    }
                }
                if (bool) {
                    $("#stock").css("pointer-events", "none");
                    $("#stock").css("background", "rgb(161, 160, 161)");
                    $("#stock").val(stock);
                } else {
                    $("#stock").val("");
                    $("#stock").css("pointer-events", "visiblePainted");
                    $("#stock").css("background", "white");
                }


            });

    })
    */

})