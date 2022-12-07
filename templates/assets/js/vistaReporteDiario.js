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
                                    <td class="fil${arraybio[i]['Categoria_idCategoria']}">${arraybio[i]['BiologicosCod']}</td>
                                    <td class="fil${arraybio[i]['Categoria_idCategoria']}">${arraybio[i]['BiologicosNom']}</td>
                                    <td class="fil${arraybio[i]['Categoria_idCategoria']}">${arraybio[i]['BiologicosUnidad']}</td>
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
                                    <td >${arraybio[i]['ReportesLote']}</td>
                                    <td >${arraybio[i]['ReportesRequerimientoMes']}</td>
                                    <td >
                                        <div class="contenedorObservaciones" >
                                            <div>
                                                ${arraybio[i]['ReporteObservaciones']}
                                            </div>

                                            <div id="mostrarArchivos${i}">
                                                <button id="botonMostrarArchivo${i}" type="button"  aux=""   observacion="" class="verArchivos" data-bs-toggle="modal" data-bs-target="#modalArchivo">
                                                Ver Imagen
                                                </button>         
                                                <a id="linkArchivo${i}" href="" download="">descargar archivo</a>
                                            </div>    
                                        </div>

                                    </td>
                                </tr>`;
                    

                    data += tr;
                    

                });
                tbody.append(data);
                $.each(arraybio, function (i, k) {
                    let caja='#mostrarArchivos'+i;
                    let boton='#botonMostrarArchivo'+i;
                    let a='#linkArchivo'+i;

                    if(arraybio[i]['ReportesArchivo']!=''){
                        $(caja).fadeIn();
                        if(arraybio[i]['ReportesArchivo'].substr(-3) == 'jpg' || arraybio[i]['ReportesArchivo'].substr(-3) == 'png' || arraybio[i]['ReportesArchivo'].substr(-4) == 'jpeg'){
                            let aux= document.getElementById('botonMostrarArchivo'+i);

                            aux.setAttribute('aux','../../archives/'+arraybio[i]['Usuarios_idUsuarios']+'/'+arraybio[i]['fecha']+'/'+arraybio[i]['BiologicosCod']+'/'+arraybio[i]['ReportesArchivo']);
                            aux.setAttribute('observacion',arraybio[i]['ReporteObservaciones']);
                            
                            $(boton).fadeIn();
                            $(a).css("display", "none");
                        }
                        else{
                            let aux= document.getElementById('linkArchivo'+i);
                            aux.setAttribute('aux','../../archives/'+arraybio[i]['Usuarios_idUsuarios']+'/'+arraybio[i]['fecha']+'/'+arraybio[i]['BiologicosCod']+'/'+arraybio[i]['ReportesArchivo']);
                            aux.setAttribute('download',arraybio[i]['ReportesArchivo']);

                            $(a).fadeIn();
                            $(boton).css("display", "none");

                        }
                    }else{
                        $(caja).css("display", "none");
                    }

                });  
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
                                        <td class="fil${arraybio[i]['Categoria_idCategoria']}">${arraybio[i]['BiologicosCod']}</td>
                                        <td class="fil${arraybio[i]['Categoria_idCategoria']}">${arraybio[i]['BiologicosNom']}</td>
                                        <td class="fil${arraybio[i]['Categoria_idCategoria']}">${arraybio[i]['BiologicosUnidad']}</td>
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
                                        <td >${arraybio[i]['ReportesLote']}</td>
                                        <td >${arraybio[i]['ReportesRequerimientoMes']}</td>
        
                                        <td >
                                            <div class="contenedorObservaciones" >
                                                <div>
                                                    ${arraybio[i]['ReporteObservaciones']}
                                                </div>
                                                <div id="mostrarArchivos${i}">
                                                    <button id="botonMostrarArchivo${i}" type="button"  aux=""   observacion="" class="verArchivos" data-bs-toggle="modal" data-bs-target="#modalArchivo">
                                                    Ver Imagen
                                                    </button>         
                                                    <a id="linkArchivo${i}" href="" download="">descargar archivo</a>
                                                </div>
                                            </div>
        
                                        </td>
                                    </tr>`;
                        data += tr;
                        
        
                    });
                    tbody.append(data);
                    $.each(arraybio, function (i, k) {
                        let caja='#mostrarArchivos'+i;
                        let boton='#botonMostrarArchivo'+i;
                        let a='#linkArchivo'+i;
        
                        if(arraybio[i]['ReportesArchivo']!=''){
                            $(caja).fadeIn();
                            if(arraybio[i]['ReportesArchivo'].substr(-3) == 'jpg' || arraybio[i]['ReportesArchivo'].substr(-3) == 'png' || arraybio[i]['ReportesArchivo'].substr(-4) == 'jpeg'){
                                let aux= document.getElementById('botonMostrarArchivo'+i);
        
                                aux.setAttribute('aux','../../archives/'+arraybio[i]['Usuarios_idUsuarios']+'/'+arraybio[i]['fecha']+'/'+arraybio[i]['BiologicosCod']+'/'+arraybio[i]['ReportesArchivo']);
                                aux.setAttribute('observacion',arraybio[i]['ReporteObservaciones']);
                                
                                $(boton).fadeIn();
                                $(a).css("display", "none");
                            }
                            else{
                                let aux= document.getElementById('linkArchivo'+i);
                                aux.setAttribute('aux','../../archives/'+arraybio[i]['Usuarios_idUsuarios']+'/'+arraybio[i]['fecha']+'/'+arraybio[i]['BiologicosCod']+'/'+arraybio[i]['ReportesArchivo']);
                                aux.setAttribute('download',arraybio[i]['ReportesArchivo']);
        
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