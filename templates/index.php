<?php 
    require '../../conections/basededatos.php';
    require '../../entity/ListaProductos.php';
    require '../../entity/ListaDetalleReporte.php';

    $productos = new ListaProductos($conn);
    $detalleReporte = new ListaDetalleReporte($conn);
    $detalleReporte->VistaDetalleReporte($conn);

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/styles.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
    <title>Document</title>
</head>
<body>
<div>
    <div class="contenedor_add">
        <button  class="ref" data-bs-toggle="modal" data-bs-target="#modalForm"><i class="fas fa-plus"></i>&nbsp&nbspAgregar Biologico</button>
    </div>    
    <!-- Modal Registrar -->
    <div class="modal fade m_1" id="modalForm" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog m_2">
            <div class="modal-content m_3">
                <div class="modal-header m_4">
                    <h5 class="modal-title" id="exampleModalLabel">Registrar nueva Biologico</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body m_4_1">
                    <form action="../Functions/AddDetalleReporte.php" method="post">
                        <div class="mb-3">
                            <label class="form-label">Descripcion Biologico</label>
                            <select class="comboboxRegistrar" onchange="combobox()" name="DetalleBiologico" id="DetalleBiologico" >
                            <?php foreach($productos->productos as $valor=>$value){?>
                                <option  class="opcion">
                                <?php echo $productos->getNombre($valor) ?></option>
                            <?php } ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" >Ingresos</label>
                            <input type="number" class="form-control"  id="ingreso" name="ingreso" placeholder="Ingresos..." required/>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" >Ingresos Extra</label>
                            <input type="number" class="form-control"  id="ingresoextra" name="ingresoextra" placeholder="Ingresos Extra..." required/>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" >Frascos Abiertos</label>
                            <input type="number" class="form-control" id="frascoabierto" name="frascoabierto" placeholder="Frascos Abiertos..." required/>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" >Dosis</label>
                            <input type="number" class="form-control"  id="dosis" name="dosis" placeholder="Dosis..." required/>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" >Devolución</label>
                            <input type="number" class="form-control" id="devolucion" name="devolucion" placeholder="Devolución..." required/>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" >Expiracion</label>
                            <input type="date" class="form-control" id="expiracion" name="expiracion" placeholder="Expiración..." required/>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" >Lote</label>
                            <input type="text" class="form-control" id="lote" name="lote"  placeholder="Lote..." required/>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" >Requerimientos</label>
                            <input type="number" class="form-control" id="requerimientos" name="requerimientos"  placeholder="Requerimientos..." required/>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" >Observaciones</label>
                            <input type="text" class="form-control" id="observaciones" name="observaciones" placeholder="Observaciones..." required/>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" >Archivo</label>
                            <input type="file" class="form-control" id="archivo" name="archivo" placeholder="Archivo..." required/>
                        </div>

                        <div class="modal-footer d-block btn-block">
                            <button type="submit" class="btn-agregar float-end"><i class="fas fa-plus"></i>&nbsp&nbspAgregar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div>
        <table id="example" class="datosreporte" >
            <thead>
                <tr class="fil_1">
                    <th scope="rowgroup" rowspan="3" >CODIGO</th>
                    <th class ="inmovil" scope="rowgroup" rowspan="3">DESCRIPCION</th>
                    <th scope="rowgroup" rowspan="3" >UNIDAD DE MEDIDA</th>
                    <th scope="colgroup" colspan="4" >INGRESO</th>

                    <th scope="colgroup" colspan="4" >SALIDAS</th>

                    <th scope="colgroup" colspan="3" >DISPONIBLE</th>

                    <th scope="rowgroup" rowspan="3" >Requerimiento mes</th>
                    <th scope="rowgroup" rowspan="3" >Observaciones</th>
                    <th scope="rowgroup" rowspan="3" >Archivos</th>
                    <th scope="rowgroup" rowspan="3" >Acciones</th>
                </tr>
                <tr class="fil_2">
                    <th scope="rowgroup" rowspan="2" >Saldo del mes anterior (frascos)</th>
                    <th scope="rowgroup" rowspan="2" >Ingresos (frascos)</th>
                    <th scope="rowgroup" rowspan="2" >Ingresos adicionales (frascos)</th>
                    <th scope="rowgroup" rowspan="2" >Total (Saldo + Ingreso) (frascos)</th>

                    <th scope="colgroup" colspan="2" >INTERVENCION SANITARIA</th>
                    
                    <th style="width:8%" class="col_2">OTRAS SALIDAS</th>
                    
                    <th scope="rowgroup" rowspan="2" >Total salidas (frascos) (f) d + er</th>

                    <th scope="rowgroup" rowspan="2" >Saldo final disponible (frascos) (g)  c - f</th>
                    <th scope="rowgroup" rowspan="2" >Fecha de expiracion mas proxima</th>
                    <th scope="rowgroup" rowspan="2" >Lote</th>
                </tr>
                <tr class="fil_3">
                    <th >FCO (d)</th>
                    <th >Dosis</th>
                    <th >TRANSFE./DEVOLUCION frascos (e)</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($detalleReporte->vistadetallReporte as $valor=>$value) { ?>
                <tr>
                    <td class="fil_1_dat">
                        <?php echo $detalleReporte->vistadetallReporte[$valor]['BiologicosCod']?>
                    </td>
                    <td class="fil_2_dat">
                        <?php echo $detalleReporte->vistadetallReporte[$valor]['BiologicosNom']?>
                    </td>
                    <td class="fil_3_dat">
                        <?php echo $detalleReporte->vistadetallReporte[$valor]['BiologicosUnidad']?>
                    </td>
                    <td class="fil_4_dat">
                        stock
                    </td>
                    <td class="fil_5_dat">
                        <?php echo $detalleReporte->vistadetallReporte[$valor]['ReportesIngresos']?>
                    </td>
                    <td class="fil_6_dat">
                        <?php echo $detalleReporte->vistadetallReporte[$valor]['ReportesIngresosExtra']?>
                    </td>
                    <td class="fil_7_dat">
                        total
                    </td>
                    <td class="fil_8_dat">
                        <?php echo $detalleReporte->vistadetallReporte[$valor]['ReportesFrascosAbiertos']?>
                    </td>
                    <td class="fil_9_dat">
                        <?php echo $detalleReporte->vistadetallReporte[$valor]['ReportesDosis']?>
                    </td>
                    <td class="fil_10_dat">
                        <?php echo $detalleReporte->vistadetallReporte[$valor]['ReportesDevolucion']?>
                    </td>
                    <td class="fil_11_dat">
                        total salida
                    </td>
                    <td class="fil_12_dat">
                        Saldo Disponible
                    </td>
                    <td class="fil_13_dat">
                        <?php echo $detalleReporte->vistadetallReporte[$valor]['ReportesExpiracionFecha']?>
                    </td>
                    <td class="fil_14_dat">
                        <?php echo $detalleReporte->vistadetallReporte[$valor]['ReportesLote']?>
                    </td>
                    <td class="fil_15_dat">
                        <?php echo $detalleReporte->vistadetallReporte[$valor]['ReportesRequerimientoMes']?>
                    </td>
                    <td class="fil_16_dat">
                        <?php echo $detalleReporte->vistadetallReporte[$valor]['ReporteObservaciones']?>
                    </td>
                    <td class="fil_17_dat">
                        <?php echo $detalleReporte->vistadetallReporte[$valor]['ReportesArchivo']?>
                    </td>
                    <td class="fil_18_dat">
                        btn
                    </td>
                </tr>
            <?php } ?> 
            

            </tbody>
        </table>
    </div>
</div>
<script src="./assets/js/bootstrap.bundle.min.js"></script>
        <script src="./assets/js/jquery-3.6.0.min.js"></script>
        <script src="./assets/js/datatables.min.js"></script>
        <script src="./assets/js/pdfmake.min.js"></script>
        <script src="./assets/js/vfs_fonts.js"></script>
        <script src="./assets/js/custom.js"></script>
</body>
</html>