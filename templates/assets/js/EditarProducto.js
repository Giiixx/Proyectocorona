

$(document).ready(function (){
    $('body').on('click','.editarproductoss',function (){
        $('#idEditarProducto').val($(this).attr('id'));
        $('#codigo1').val($(this).attr('param1'));
        $('#nombre1').val($(this).attr('param2'));
        $('#proporcion1').val($(this).attr('param3'));
        $('#unidad1').val($(this).attr('param4'));    
    })
});