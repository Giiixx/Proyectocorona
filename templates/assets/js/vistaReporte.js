$(document).ready(function () {
    var tbody = $("#datosreportediario");  
    var data = "";
    $.ajax(
        {
            url: '../../Functions/ObtenerListaPorDia.php',
            method: "POST",
            data: {
                fecha: $("#ReporteDiario").val(),
            }
        }).done(function (res) {
            let arraybio = JSON.parse(res);
            
            $.each(arraybio, function (i, k) {
                let stockingreso = arraybio[i]['ReportesIngresos'] + arraybio[i]['ReportesIngresosExtra'] + arraybio[i]['ReportesStockAnterior'];
                let salidatotal = arraybio[i]['ReportesFrascosAbiertos'] + arraybio[i]['ReportesDevolucion'];
                let stock = stockingreso - salidatotal;

                let tr = `<tr>
                                <td >${arraybio[i]['BiologicosCod']}</td>
                                <td >${arraybio[i]['BiologicosNom']}</td>
                                <td >${arraybio[i]['BiologicosUnidad']}</td>
                                <td >${arraybio[i]['ReportesStockAnterior']}</td>
                                <td >${arraybio[i]['ReportesIngresos']}</td>
                                <td >${arraybio[i]['ReportesIngresosExtra']}</td>
                                <td >${stockingreso}</td>
                                <td >${arraybio[i]['ReportesFrascosAbiertos']}</td>
                                <td >${arraybio[i]['ReportesDosis']}</td>
                                <td >${arraybio[i]['ReportesDevolucion']}</td>
                                <td >${salidatotal}</td>
                                <td >${stock}</td>
                                <td >${arraybio[i]['ReportesExpiracionBiologico']}</td>
                                <td >LOTE</td>
                                <td >${arraybio[i]['ReportesRequerimientoMes']}</td>
                                <td >${arraybio[i]['ReporteObservaciones']}</td>
                                <td >${arraybio[i]['ReportesArchivo']}</td>
                            </tr>`;

                data += tr;
            });
            tbody.append(data);
            console.log(tbody);
        });
    


    $('body').on('change', '.comboboxFecha', function () {
        tbody.empty();
        data="";
        $.ajax(
            {
                url: '../../Functions/ObtenerListaPorDia.php',
                method: "POST",
                data: {
                    fecha: $("#ReporteDiario").val(),
                }
            }).done(function (res) {
                let arraybio = JSON.parse(res);
                
                $.each(arraybio, function (i, k) {
                    let stockingreso = arraybio[i]['ReportesIngresos'] + arraybio[i]['ReportesIngresosExtra'] + arraybio[i]['ReportesStockAnterior'];
                    let salidatotal = arraybio[i]['ReportesFrascosAbiertos'] + arraybio[i]['ReportesDevolucion'];
                    let stock = stockingreso - salidatotal;
    
                    let tr = `<tr>
                                    <td >${arraybio[i]['BiologicosCod']}</td>
                                    <td >${arraybio[i]['BiologicosNom']}</td>
                                    <td >${arraybio[i]['BiologicosUnidad']}</td>
                                    <td >${arraybio[i]['ReportesStockAnterior']}</td>
                                    <td >${arraybio[i]['ReportesIngresos']}</td>
                                    <td >${arraybio[i]['ReportesIngresosExtra']}</td>
                                    <td >${stockingreso}</td>
                                    <td >${arraybio[i]['ReportesFrascosAbiertos']}</td>
                                    <td >${arraybio[i]['ReportesDosis']}</td>
                                    <td >${arraybio[i]['ReportesDevolucion']}</td>
                                    <td >${salidatotal}</td>
                                    <td >${stock}</td>
                                    <td >${arraybio[i]['ReportesExpiracionBiologico']}</td>
                                    <td ></td>
                                    <td >${arraybio[i]['ReportesRequerimientoMes']}</td>
                                    <td >${arraybio[i]['ReporteObservaciones']}</td>
                                    <td >${arraybio[i]['ReportesArchivo']}</td>
                                </tr>`;
    
                    data += tr;
                });
                tbody.append(data);
            });
        

    })

})