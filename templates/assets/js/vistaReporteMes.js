$(document).ready(function () {
    var tbody = $("#datosreportmes");
    var data = "";
    $.ajax(
        {
            url: '../../Functions/ObtenerListaPorMes.php',
            method: "POST",
            data: {
                nombre: $("#reporteMes").val(),
            }
        }).done(function (res) {    
            let arraybio = JSON.parse(res);
            console.log(arraybio);  

            $.each(arraybio['lista'], function (i, j,) {

                let tr = `<tr>
                                <td class="fil${arraybio['lista'][i]['Categoria_idCategoria']}">${arraybio['lista'][i]['BiologicosCod']}</td>
                                <td class="fil${arraybio['lista'][i]['Categoria_idCategoria']}">${arraybio['lista'][i]['BiologicosNom']}</td>
                                <td class="fil${arraybio['lista'][i]['Categoria_idCategoria']}">${arraybio['lista'][i]['BiologicosUnidad']}</td>
                                <td >${arraybio['lista'][i]['StockAnterior']}</td>
                                <td >${arraybio['lista'][i]['Ingreso']}</td>
                                <td >${arraybio['lista'][i]['IngresoExtra']}</td>
                                <td >${arraybio['lista'][i]['sumatotalingreso']}</td>
                                <td >${arraybio['lista'][i]['Fco']}</td>
                                <td >${arraybio['lista'][i]['Dosis']}</td>
                                <td >${arraybio['lista'][i]['Devolucion']}</td>
                                <td >${arraybio['lista'][i]['sumatotalsalida']}</td>
                                <td >${arraybio['lista'][i]['StockDisponible']}</td>
                                <td >${arraybio['ultimaexpiracion'][i]}</td>
                                <td >${arraybio['lista'][i]['lotes']}</td>
                                <td >${arraybio['lista'][i]['Requerimientos']}</td>
                                <td >
                                    <div class="contenedorObservaciones" >
                                        <div>
                                        ${arraybio['ultimaobservacion'][i]}
                                        </div>
                                        <div id="mostrarArchivos${i}">
                                            <button id="botonMostrarArchivo${i}" type="button"  aux=""   observacion="" class="verArchivos" data-bs-toggle="modal" data-bs-target="#modalArchivo">
                                            Ver Imagen
                                            </button>         
                                            <a id="linkArchivo${i}" href="" download=""> <i class="mdi mdi-arrow-down-bold-circle-outline"></i>ARCHIVO</a>
                                        </div>  
                                    </div>
                                </td>
                            </tr>`;

                data += tr;
            });
            tbody.append(data);

            $.each(arraybio['lista'], function (i, k) {
                let caja='#mostrarArchivos'+i;
                let boton='#botonMostrarArchivo'+i;
                let a='#linkArchivo'+i;

                if(arraybio['ultimaarchivo'][i]!=''){
                    $(caja).fadeIn();
                    if(arraybio['ultimaarchivo'][i].substr(-3) == 'jpg' || arraybio['ultimaarchivo'][i].substr(-3) == 'png' || arraybio['ultimaarchivo'][i].substr(-4) == 'jpeg'){
                        let aux= document.getElementById('botonMostrarArchivo'+i);

                        aux.setAttribute('aux','../../archives/'+arraybio['idUsuario'][i]+'/'+arraybio['ultimafechaAdd'][i]+'/'+arraybio['lista'][i]['BiologicosCod']+'/'+arraybio['ultimaarchivo'][i]);
                        aux.setAttribute('observacion',arraybio['ultimaobservacion'][i]);
                        
                        $(boton).fadeIn();
                        $(a).css("display", "none");
                    }
                    else{
                        let aux= document.getElementById('linkArchivo'+i);
                        aux.setAttribute('aux','../../archives/'+arraybio['idUsuario'][i]+'/'+arraybio['ultimafechaAdd'][i]+'/'+arraybio['lista'][i]['BiologicosCod']+'/'+arraybio['ultimaarchivo'][i]);
                        aux.setAttribute('download',arraybio['ultimaarchivo'][i]);

                        $(a).fadeIn();
                        $(boton).css("display", "none");

                    }
                }else{
                    $(caja).css("display", "none");
                }

            });
        });



    $('body').on('change', '.comboboxReportesMes', function () {

        tbody.empty();
        data = "";
        $.ajax(
            {
                url: '../../Functions/ObtenerListaPorMes.php',
                method: "POST",
                data: {
                    nombre: $("#reporteMes").val(),
                }
            }).done(function (res) {
                let arraybio = JSON.parse(res);

                $.each(arraybio['lista'], function (i, j,) {

                    let tr = `<tr>
                                    <td class="fil${arraybio['lista'][i]['Categoria_idCategoria']}">${arraybio['lista'][i]['BiologicosCod']}</td>
                                    <td class="fil${arraybio['lista'][i]['Categoria_idCategoria']}">${arraybio['lista'][i]['BiologicosNom']}</td>
                                    <td class="fil${arraybio['lista'][i]['Categoria_idCategoria']}">${arraybio['lista'][i]['BiologicosUnidad']}</td>
                                    <td >${arraybio['lista'][i]['StockAnterior']}</td>
                                    <td >${arraybio['lista'][i]['Ingreso']}</td>
                                    <td >${arraybio['lista'][i]['IngresoExtra']}</td>
                                    <td >${arraybio['lista'][i]['sumatotalingreso']}</td>
                                    <td >${arraybio['lista'][i]['Fco']}</td>
                                    <td >${arraybio['lista'][i]['Dosis']}</td>
                                    <td >${arraybio['lista'][i]['Devolucion']}</td>
                                    <td >${arraybio['lista'][i]['sumatotalsalida']}</td>
                                    <td >${arraybio['lista'][i]['StockDisponible']}</td>
                                    <td >${arraybio['ultimaexpiracion'][i]}</td>
                                    <td >${arraybio['lista'][i]['lotes']}</td>
                                    <td >${arraybio['lista'][i]['Requerimientos']}</td>
                                    <td >
                                        <div class="contenedorObservaciones" >
                                            <div>
                                            ${arraybio['ultimaobservacion'][i]}
                                            </div>
                                            <div id="mostrarArchivos${i}">
                                                <button id="botonMostrarArchivo${i}" type="button"  aux=""   observacion="" class="verArchivos" data-bs-toggle="modal" data-bs-target="#modalArchivo">
                                                Ver Imagen
                                                </button>         
                                                <a id="linkArchivo${i}" href="" download=""> <i class="mdi mdi-arrow-down-bold-circle-outline"></i>ARCHIVO</a>
                                            </div>  
                                        </div>
                                    </td>
                                </tr>`;
    
                    data += tr;
                });
                tbody.append(data);

                $.each(arraybio['lista'], function (i, k) {
                    let caja='#mostrarArchivos'+i;
                    let boton='#botonMostrarArchivo'+i;
                    let a='#linkArchivo'+i;
    
                    if(arraybio['ultimaarchivo'][i]!=''){
                        $(caja).fadeIn();
                        if(arraybio['ultimaarchivo'][i].substr(-3) == 'jpg' || arraybio['ultimaarchivo'][i].substr(-3) == 'png' || arraybio['ultimaarchivo'][i].substr(-4) == 'jpeg'){
                            let aux= document.getElementById('botonMostrarArchivo'+i);
    
                            aux.setAttribute('aux','../../archives/'+arraybio['idUsuario'][i]+'/'+arraybio['ultimafechaAdd'][i]+'/'+arraybio['lista'][i]['BiologicosCod']+'/'+arraybio['ultimaarchivo'][i]);
                            aux.setAttribute('observacion',arraybio['ultimaobservacion'][i]);
                            
                            $(boton).fadeIn();
                            $(a).css("display", "none");
                        }
                        else{
                            let aux= document.getElementById('linkArchivo'+i);
                            aux.setAttribute('aux','../../archives/'+arraybio['idUsuario'][i]+'/'+arraybio['ultimafechaAdd'][i]+'/'+arraybio['lista'][i]['BiologicosCod']+'/'+arraybio['ultimaarchivo'][i]);
                            aux.setAttribute('download',arraybio['ultimaarchivo'][i]);
    
                            $(a).fadeIn();
                            $(boton).css("display", "none");
    
                        }
                    }else{
                        $(caja).css("display", "none");
                    }
    
                });
            });


    })

})