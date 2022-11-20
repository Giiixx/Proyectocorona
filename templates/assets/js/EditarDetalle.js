$(document).ready(function (){
	$('body').on('click','.editarDetalleReporte',function (){
		let ingreso = document.getElementById("ingreso1");	
		let ingresoextra = document.getElementById("ingresoextra1");
		let frasabiertos = document.getElementById("frascoabierto1");
		let devoluciones = document.getElementById("devolucion1");



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


		console.log($("#ingreso1").attr("param2"));
		//Pendiente cuando creamos la carpeta para archivos
		//$('#archivo1').val($(this).attr('param11'));
		
	})

	$('body').on('click','.editaDetalle',function (){
        let stock=parseInt($("#stock1").val(),10);
        let ingreso=parseInt($("#ingreso1").val(),10);
        let ingresoextra=parseInt($("#ingresoextra1").val(),10);
        let frascoabierto=parseInt($("#frascoabierto1").val(),10);
        let devolucion=parseInt($("#devolucion1").val(),10);
        let sumIngreso=stock+ingreso+ingresoextra;
        let sumSalida=frascoabierto+devolucion;

        if($("#DetalleBiologico1").val()=="SELECCIONAR UN BIOLOGICO"){
            $("#MensajeError").fadeIn();    
            return false;
        }else if ((sumIngreso)<(sumSalida)) {
            $("#MensajeErrorStock1").fadeIn();
            $("#MensajeErrorSalida1").fadeIn();
            return false;
        } else {
        }
        

    })

    $('.MensajeError').focus(function () {
        $("#MensajeErrorStock1").css("display", "none");
        $("#MensajeErrorSalida1").css("display", "none");

    })
    $('.sumIngreso').focusout(function () {
        let stock= Number.isNaN(parseInt($("#stock1").val(),10)) ? 0 : parseInt($("#stock1").val(),10);
        let ingreso= Number.isNaN(parseInt($("#ingreso1").val(),10)) ? 0 : parseInt($("#ingreso1").val(),10);
        let ingresoextra= Number.isNaN(parseInt($("#ingresoextra").val(),10)) ? 0 : parseInt($("#ingresoextra1").val(),10);
        $('#stockIngreso1').val(stock+ingreso+ingresoextra);

    })

    $('.sumSalida').focusout(function () {
        let frasabier= Number.isNaN(parseInt($("#frascoabierto1").val(),10)) ? 0 : parseInt($("#frascoabierto1").val(),10);
        let devolucion= Number.isNaN(parseInt($("#devolucion1").val(),10)) ? 0 : parseInt($("#devolucion1").val(),10);
        $('#salidaTotal1').val(frasabier+devolucion);
        
    })

    $('.sumTotal').focusout(function () {
        let salidaTotal= Number.isNaN(parseInt($("#salidaTotal1").val(),10)) ? 0 : parseInt($("#salidaTotal1").val(),10);
        let stockIngreso= Number.isNaN(parseInt($("#stockIngreso1").val(),10)) ? 0 : parseInt($("#stockIngreso1").val(),10);
        console.log(stockIngreso-salidaTotal);
        $('#stockNuevo1').val(stockIngreso-salidaTotal);
        
    })

    $('.verificarLote').focus(function () {
        $("#lote").val()!="" ? $("#MensajeErrorLote1").css("display", "none") :$("#MensajeErrorLote1").fadeIn();    

    })

    $('.verificarLote').focusout(function () { 
        if($("#lote1").val()==""||$("#stock1").val()==""){
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