$(document).ready(function(){
    $('body').on('click','.editarproducto',function(){
        $('#idEditarProducto').val($(this).attr('id'));
        $('#BiologicosCod').val($(this).attr('param1'));
        
    })
})