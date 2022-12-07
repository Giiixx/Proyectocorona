$(document).ready(function () {
    $('body').on('click', '.agregaDetalle', function () {
        let stock = Number.isNaN(parseInt($("#stock").val(), 10)) ? 0 : parseInt($("#stock").val(), 10);
        let ingreso = Number.isNaN(parseInt($("#ingreso").val(), 10)) ? 0 : parseInt($("#ingreso").val(), 10);
        let ingresoextra = Number.isNaN(parseInt($("#ingresoextra").val(), 10)) ? 0 : parseInt($("#ingresoextra").val(), 10);
        let frascoabierto = Number.isNaN(parseInt($("#frascoabierto").val(), 10)) ? 0 : parseInt($("#frascoabierto").val(), 10);
        let devolucion = Number.isNaN(parseInt($("#devolucion").val(), 10)) ? 0 : parseInt($("#devolucion").val(), 10);
        let sumIngreso = stock + ingreso + ingresoextra;
        let sumSalida = frascoabierto + devolucion;
        let extPermitidas = /(.pdf|.PDF|.jpg|.JPG|.jpeg|.JPEG|.png|.PNG|.mp4|.MP4|.mp3|.MP3|.XLSX|.xlsx|.csv|.CSV|.docx|.DOCX)$/i;

        if ($("#DetalleBiologico").val() == "SELECCIONAR UN BIOLOGICO") {
            $("#MensajeError").fadeIn();
            return false;
        } else if ((sumIngreso) < (sumSalida)) {
            $("#MensajeErrorStock").fadeIn();
            $("#MensajeErrorSalida").fadeIn();
            return false;
        }

        $('#stockIngreso').val(stock + ingreso + ingresoextra);
        $('#salidaTotal').val(frascoabierto + devolucion);
        $('#stockNuevo').val(sumIngreso - sumSalida);

        if ($("#ingreso").val() == "") { $("#ingreso").val(0); }
        if ($("#ingresoextra").val() == "") { $("#ingresoextra").val(0); }
        if ($("#frascoabierto").val() == "") { $("#frascoabierto").val(0); }
        if ($("#dosis").val() == "") { $("#dosis").val(0); }
        if ($("#devolucion").val() == "") { $("#devolucion").val(0); }
        if ($("#requerimientos").val() == "") { $("#requerimientos").val(0); }
        if ($("#observaciones").val() == "") { $("#observaciones").val("Sin Observaciones"); }
        if ($("#observaciones").val() == "" ) { $("#observaciones").val("Sin Observaciones"); }
        /**----------------------------------------------------------------------------------------------------- */
        if ($('#archivo').val() != '') {
            if (!extPermitidas.exec($('#archivo').val())) {
                $("#MensajeErrorArchivo").fadeIn();
                $('#archivo').val('');
                return false;
            }
        }   





    })

    $('.MensajeError').focus(function () {
        $("#MensajeErrorStock").css("display", "none");
        $("#MensajeErrorSalida").css("display", "none");

    })
    $('.sumIngreso').focusout(function () {
        let stock = Number.isNaN(parseInt($("#stock").val(), 10)) ? 0 : parseInt($("#stock").val(), 10);
        let ingreso = Number.isNaN(parseInt($("#ingreso").val(), 10)) ? 0 : parseInt($("#ingreso").val(), 10);
        let ingresoextra = Number.isNaN(parseInt($("#ingresoextra").val(), 10)) ? 0 : parseInt($("#ingresoextra").val(), 10);
        $('#stockIngreso').val(stock + ingreso + ingresoextra);

    })

    $('.sumSalida').focusout(function () {
        let frasabier = Number.isNaN(parseInt($("#frascoabierto").val(), 10)) ? 0 : parseInt($("#frascoabierto").val(), 10);
        let devolucion = Number.isNaN(parseInt($("#devolucion").val(), 10)) ? 0 : parseInt($("#devolucion").val(), 10);
        $('#salidaTotal').val(frasabier + devolucion);

    })

    $('.sumTotal').focusout(function () {
        let salidaTotal = Number.isNaN(parseInt($("#salidaTotal").val(), 10)) ? 0 : parseInt($("#salidaTotal").val(), 10);
        let stockIngreso = Number.isNaN(parseInt($("#stockIngreso").val(), 10)) ? 0 : parseInt($("#stockIngreso").val(), 10);
        $('#stockNuevo').val(stockIngreso - salidaTotal);

    })

    $('.verificarStock').focusout(function () {
        if ($("#stock").val() == "") {
            $("#ingreso").val("");
            $("#ingresoextra").val("");
            $("#dosis").val("");
            $("#frascoabierto").val("");
            $("#stock").val("");
            $("#stockIngreso").val("");
            $("#requerimientos").val("");
            $("#devolucion").val("");
            $("#observaciones").val("");
        }
    })

})