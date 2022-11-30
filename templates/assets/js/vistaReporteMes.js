$(document).ready(function () {
    var tbody = $("#datosreportmes");
    var data = "";
    $.ajax(
        {
            url: '../../Functions/ObtenerListaPorMes.php',
                method: "POST",
                data: {
                    nombre: $("#creporteMes").val(),
                }
        }).done(function (res) {
            let arraybio = JSON.parse(res);

            $.each(arraybio, function (i, k) {

                let tr = `<tr>
                                <td >${arraybio[i]['BiologicosCod']}</td>
                                <td >${arraybio[i]['BiologicosNom']}</td>
                                <td >${arraybio[i]['BiologicosUnidad']}</td>
                                <td >${arraybio[i]['StockAnterior']}</td>
                                <td >${arraybio[i]['Ingreso']}</td>
                                <td >${arraybio[i]['IngresoExtra']}</td>
                                <td >${arraybio[i]['sumatotalingreso']}</td>
                                <td >${arraybio[i]['Fco']}</td>
                                <td >${arraybio[i]['Dosis']}</td>
                                <td >${arraybio[i]['Devolucion']}</td>
                                <td >${arraybio[i]['sumatotalsalida']}</td>
                                <td >${arraybio[i]['StockDisponible']}</td>
                                <td ></td>
                                <td >${arraybio[i]['lotes']}</td>
                                <td >${arraybio[i]['Requerimientos']}</td>
                                <td ></td>
                                <td ></td>
                            </tr>`;

                data += tr;
            });
            tbody.append(data);
        });



    $('body').on('change', '.comboboxReportes', function () {
        
        tbody.empty();
        data = "";
        $.ajax(
            {
                url: '../../Functions/ObtenerListaPorMes.php',
                method: "POST",
                data: {
                    nombre: $("#creporteMes").val(),
                }
            }).done(function (res) {
                let arraybio = JSON.parse(res);

                $.each(arraybio, function (i, k) {
                    let tr = `<tr>
                                <td >${arraybio[i]['BiologicosCod']}</td>
                                <td >${arraybio[i]['BiologicosNom']}</td>
                                <td >${arraybio[i]['BiologicosUnidad']}</td>
                                <td >${arraybio[i]['StockAnterior']}</td>
                                <td >${arraybio[i]['Ingreso']}</td>
                                <td >${arraybio[i]['IngresoExtra']}</td>
                                <td >${arraybio[i]['sumatotalingreso']}</td>
                                <td >${arraybio[i]['Fco']}</td>
                                <td >${arraybio[i]['Dosis']}</td>
                                <td >${arraybio[i]['Devolucion']}</td>
                                <td >${arraybio[i]['sumatotalsalida']}</td>
                                <td >${arraybio[i]['StockDisponible']}</td>
                                <td ></td>
                                <td >${arraybio[i]['lotes']}</td>
                                <td >${arraybio[i]['Requerimientos']}</td>
                                <td ></td>
                                <td ></td>
                            </tr>`;

                data += tr;
                });
                tbody.append(data);
            });


    })

})