$(document).ready(function () {
	$('body').on('click', '.editarDetalleReporte', function () {

		let stockAnterior = parseInt($(this).attr('param'), 10);
		let ingreso = parseInt($(this).attr('param2'), 10);
		let ingresoextra = parseInt($(this).attr('param3'), 10);
		let frasabiertos = parseInt($(this).attr('param4'), 10);
		let devoluciones = parseInt($(this).attr('param6'), 10);


		$('#idEditarDetalles').val($(this).attr('id'));
		$('#DetalleBiologico1').val($(this).attr('param1'));
		$('#ingreso1').val($(this).attr('param2'));
		$('#ingresoextra1').val($(this).attr('param3'));
		$('#frascoabierto1').val($(this).attr('param4'));
		$('#dosis1').val($(this).attr('param5'));
		$('#devolucion1').val($(this).attr('param6'));
		$('#expiracion1').val($(this).attr('param7'));
		$('#lote1').val($(this).attr('param8'));
		$('#requerimientos1').val($(this).attr('param9'));
		$('#observaciones1').val($(this).attr('param10'));
		$("#stock1").val(stockAnterior);
		$("#stockIngreso1").val(stockAnterior + ingreso + ingresoextra);
		$("#salidaTotal1").val(frasabiertos + devoluciones);
		$("#stockNuevo1").val((stockAnterior + ingreso + ingresoextra) - (frasabiertos + devoluciones));
		//Pendiente cuando creamos la carpeta para archivos
		//$('#archivo1').val($(this).attr('param11'));

		$.ajax(
            {
                url: '../../Functions/ObtenerProporcion.php',
                method: "POST",
                data: {
                    proporcion: $("#DetalleBiologico1").val(),
                }
            }).done(function (res) {

                if (res != 1) {
					let ola = document.getElementById("dosis1");
                    $("#dosis1").css("pointer-events", "visiblePainted");
                    $("#dosis1").css("background", "white");
					let canDosis = $("#frascoabierto1").val() * res;

					console.log(ola);
                    ola.setAttribute("max", canDosis);	
                }
                else {
                    $("#dosis1").css("pointer-events", "none");
                    $("#dosis1").css("background", "rgb(161, 160, 161)");

                }

            });
	})
	/**
	 * 
	 * 
	 *  */
	$(document).ready(function () {
		$('body').on('change', '.comboboxRegistrar1', function () {
			//$('body').off();
			$.ajax(
				{
					url: '../..//Functions/ObtenerProporcion.php',
					method: "POST",
					data: {
						proporcion: $("#DetalleBiologico1").val(),
					}
				}).done(function (res) {

					$("#ingreso1").val("");
					$("#ingresoextra1").val("");
					$("#dosis1").val("");
					$("#frascoabierto1").val("");
					$("#lote1").val("");
					$("#stock1").val("");
					$("#stockIngreso1").val("");
					$("#devolucion1").val("");
					$("#salidaTotal1").val("");
					$("#stockNuevo1").val("");
					$("#expiracion1").val("");
					$("#requerimientos1").val("");
					$("#observaciones1").val("");
					$("#MensajeError1").css("display", "none");
					$("#lote1").autocomplete({
						source: ""
					});	
					if (res != 1) {
						$("#dosis1").css("pointer-events", "visiblePainted");
						$("#dosis1").css("background", "white");
					}
					else {
						$("#dosis1").css("pointer-events", "none");
						$("#dosis1").css("background", "rgb(161, 160, 161)");

					}
					$.ajax(
						{
							url: '../../Functions/PasarDatosBiologicos.php',
							method: "POST",
							data: {
								aux: $("#DetalleBiologico1").val(),
							}
						}).done(function (res) {
							let arraybio = JSON.parse(res);
							if (arraybio.length > 0) {
								$("#stock1").css("pointer-events", "none");
								$("#stock1").css("background", "rgb(161, 160, 161)");
							}
							else {		
								$("#stock1").css("pointer-events", "visiblePainted");
								$("#stock1").css("background", "white");
							}

						});

				});

		})

		$('#frascoabierto1').focusout( function () {
			$.ajax(
				{
					url: '../../Functions/ObtenerProporcion.php',
					method: "POST",
					data: {
						proporcion: $("#DetalleBiologico1").val(),
					}
				}).done(function (res) {
					let link = document.getElementById("dosis1");
					if (res != 1) {
						let canDosis = $("#frascoabierto1").val() * res;
						link.setAttribute("max", canDosis);
					}
					else {
						$("#dosis1").val($("#frascoabierto1").val());
						link.setAttribute("max", "1000");
					}

				});

		})



		$('#lote1').focus(function () {
			$("#MensajeErrorLote1").css("display", "none")
			$.ajax(
				{
					url: '../../Functions/PasarDatosBiologicos.php',
					method: "POST",
					data: {
						aux: $("#DetalleBiologico1").val(),
						lote: $("#lote1").val(),
					}
				}).done(function (res) {
					try{
					let lotes = JSON.parse(res);
					console.log(lotes);
					if (lotes != null) {
						$("#lote1").autocomplete({
							source: lotes
						});
					}
					}catch{
						//$("#MensajeError").fadeIn(); 
					}

				});

		})	

		$('#lote1').focusout( function () {
			$("#ingreso1").val("");
			$("#ingresoextra1").val("");
			$("#stockIngreso1").val("");

			$.ajax(
				{
					url: '../../Functions/PasarDatosBiologicos.php',
					method: "POST",
					data: {
						aux: $("#DetalleBiologico1").val(),
					}
				}).done(function (res) {
					let arraybio = JSON.parse(res);
					let bool = false;
					let stock;
					for (let i = 0; i < arraybio.length; i++) {
						if ($("#lote1").val() == arraybio[i]["LoteBiologicoDescripcion"]) {
							bool = true;
							stock = arraybio[i]["UsuarioBiologicoStock"];
							break;
						}
					}
					if (bool) {
						$("#stock1").css("pointer-events", "none");
						$("#stock1").css("background", "rgb(161, 160, 161)");
						$("#stock1").val(stock);
					} else {
						$("#stock1").css("pointer-events", "visiblePainted");
						$("#stock1").css("background", "white");
					}


				});

		})

	})




	/**
	 * 
	 * 
	 *  */



	$('body').on('click', '.editaDetalle', function () {
		let stock = parseInt($("#stock1").val(), 10);
		let ingreso = parseInt($("#ingreso1").val(), 10);
		let ingresoextra = parseInt($("#ingresoextra1").val(), 10);
		let frascoabierto = parseInt($("#frascoabierto1").val(), 10);
		let devolucion = parseInt($("#devolucion1").val(), 10);
		let sumIngreso = stock + ingreso + ingresoextra;
		let sumSalida = frascoabierto + devolucion;

		if ($("#DetalleBiologico1").val() == "SELECCIONAR UN BIOLOGICO") {
			$("#MensajeError1").fadeIn();
			return false;
		} else if ((sumIngreso) < (sumSalida)) {
			$("#MensajeErrorStock1").fadeIn();
			$("#MensajeErrorSalida1").fadeIn();
			return false;
		}


	})

	$('.MensajeError1').focus(function () {
		$("#MensajeErrorStock1").css("display", "none");
		$("#MensajeErrorSalida1").css("display", "none");

	})
	$('.sumIngreso1').focusout(function () {
		let stock = Number.isNaN(parseInt($("#stock1").val(), 10)) ? 0 : parseInt($("#stock1").val(), 10);
		let ingreso = Number.isNaN(parseInt($("#ingreso1").val(), 10)) ? 0 : parseInt($("#ingreso1").val(), 10);
		let ingresoextra = Number.isNaN(parseInt($("#ingresoextra1").val(), 10)) ? 0 : parseInt($("#ingresoextra1").val(), 10);
		$('#stockIngreso1').val(stock + ingreso + ingresoextra);

	})

	$('.sumSalida1').focusout(function () {
		let frasabier = Number.isNaN(parseInt($("#frascoabierto1").val(), 10)) ? 0 : parseInt($("#frascoabierto1").val(), 10);
		let devolucion = Number.isNaN(parseInt($("#devolucion1").val(), 10)) ? 0 : parseInt($("#devolucion1").val(), 10);
		$('#salidaTotal1').val(frasabier + devolucion);

	})

	$('.sumTotal1').focusout(function () {
		let salidaTotal = Number.isNaN(parseInt($("#salidaTotal1").val(), 10)) ? 0 : parseInt($("#salidaTotal1").val(), 10);
		let stockIngreso = Number.isNaN(parseInt($("#stockIngreso1").val(), 10)) ? 0 : parseInt($("#stockIngreso1").val(), 10);
		console.log(stockIngreso - salidaTotal);
		$('#stockNuevo1').val(stockIngreso - salidaTotal);

	})

	$('.verificarLote1').focus(function () {
		$("#lote1").val() != "" ? $("#MensajeErrorLote1").css("display", "none") : $("#MensajeErrorLote1").fadeIn();

	})

	$('.verificarLote1').focusout(function () {
		if ($("#lote1").val() == "" || $("#stock1").val() == "") {
			$("#ingreso1").val("");
			$("#ingresoextra1").val("");
			$("#dosis1").val("");
			$("#frascoabierto1").val("");
			$("#stock1").val("");
			$("#stockIngreso1").val("");
			$("#devolucion1").val("");
		}
	})
});