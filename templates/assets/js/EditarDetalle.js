$(document).ready(function (){
	$('body').on('click','.editarDetalleReporte',function (){
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
		$('#archivo1').val($(this).attr('param11'));
		
	})
});