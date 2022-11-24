<?php
require_once '../../conections/basededatos.php';
require_once '../../entity/ListaProductos.php';
require_once '../../entity/ListaDetalleReporte.php';
require_once '../../entity/Usuario.php';
require_once '../../Functions/sesion/confirm_existuser.php';
require_once '../../Functions/sesion/confirm_password.php';

session_start();
isset($_SESSION['user_id']) ? null : header('Location:../../index.php');
confirm_existuser($_SESSION['user_id'], $conn) == FALSE ? header('Location:../../index.php') : null;

$productos = new ListaProductos($conn);
$detalleReporte = new ListaDetalleReporte($conn);
date_default_timezone_set("America/Bogota");
$fecha_actual = date("Y-m-d");
$detalleReporte->VistaDetalleReporte($conn, $_SESSION["myuser_obj"]->getId(),$fecha_actual);
?>
<?php if (!empty($_SESSION['user_id'])) : ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
        <link rel="stylesheet" href="../assets/css/styles.css">
        <link rel="stylesheet" href="../assets/css/jquery-ui.css">
        <title>Reporte Diario</title>
    </head>

    <body>
        <div>
            <div class="contenedor_add">
                <button class="ref" data-bs-toggle="modal" data-bs-target="#modalForm"><i class="fas fa-plus"></i>&nbsp&nbspAgregar Biologico</button>
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
                            <form class="formularioRegistrar" action="../../Functions/AddDetalleReporte.php" method="post" enctype="multipart/form-data">
                                <div class="mb-3">
                                    <label class="form-label">Descripcion Biologico</label>
                                    <select class="comboboxRegistrar" name="DetalleBiologico" id="DetalleBiologico">
                                        <option class="opcion">SELECCIONAR UN BIOLOGICO</option>
                                        <?php foreach ($productos->productos as $valor => $value) { ?>
                                            <option class="opcion">
                                                <?php echo $productos->getNombre($valor) ?></option>
                                        <?php } ?>
                                    </select>
                                    <div class="validarErrores" id="MensajeError" >Selecciona un biologico ps mongol</div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Lote</label>
                                    <input type="text" class="form-control  lotes" id="lote" name="lote" placeholder="Lote..." required />
                                    <div id="MensajeErrorLote" class="validarErrores">No se a especificado un lote</div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Stock</label>
                                    <input type="number"  class="form-control  display  sumIngreso sumTotal verificarLote MensajeError" id="stock" name="stock" placeholder="stock..." required />
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Ingresos</label>
                                    <input type="number" class="form-control  sumIngreso  sumTotal verificarLote MensajeError" id="ingreso" name="ingreso" min="0" placeholder="Ingresos..." required />
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Ingresos Extra</label>
                                    <input type="number" class="form-control  sumIngreso sumTotal verificarLote MensajeError" id="ingresoextra" name="ingresoextra" min="0" placeholder="Ingresos Extra..." required />
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Ingresos total + Stock</label>
                                    <input type="number" class=" form-control display  MensajeError" id="stockIngreso" name="stockIngreso" placeholder="Total Stock..."/>
                                    <div id="MensajeErrorStock" class="validarErrores">El Stock del biologico es insuficiente </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Frascos Abiertos</label>
                                    <input type="number" class="form-control verificarLote frascoabiertos sumSalida sumTotal MensajeError" id="frascoabierto" min="0" name="frascoabierto" placeholder="Frascos Abiertos..." required />
                                </div>
                                <div class="mb-3">          
                                    <label class="form-label">Dosis</label>
                                    <input type="number" class="form-control verificarLote " id="dosis" name="dosis" min="0" max="1000" placeholder="Dosis..." />
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Devolución</label>
                                    <input type="number" class="form-control verificarLote  sumSalida sumTotal MensajeError" id="devolucion" name="devolucion" min="0" placeholder="Devolución...">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Total Salida</label>
                                    <input type="number" class=" form-control display MensajeError" id="salidaTotal" name="salidaTotal" placeholder="Total Salida..."/>
                                    <div id="MensajeErrorSalida" class="validarErrores">El total de salida excede el saldo de biologicos</div>
                                </div>
                                <input type="hidden" class="form-control  MensajeError"  value="2" id="stockNuevo" name="stockNuevo" placeholder="Total"/>
                                <div class="mb-3">
                                    <label class="form-label">Expiracion</label>
                                    <input type="date" class="form-control verificarLote " id="expiracion" name="expiracion" placeholder="Expiración..." required />
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Requerimientos</label>
                                    <input type="number" class="form-control verificarLote" id="requerimientos" name="requerimientos" min="0" placeholder="Requerimientos..." />
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Observaciones</label>
                                    <input type="text" class="form-control verificarLote" id="observaciones" name="observaciones" placeholder="Observaciones..." />
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Archivo</label>
                                    <input type="file" class="form-control verificarLote    " id="archivo" name="archivo" placeholder="Archivo..." />
                                </div>

                                <div class="modal-footer d-block btn-block">
                                    <button type="submit" class="agregaDetalle" id="agregaDetalle"><i class="fas fa-plus"></i>&nbsp&nbspAgregar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal Editar -->
            <div class="modal fade me_1" id="modalEditForm" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog m_2">
                    <div class="modal-content m_3">
                        <div class="modal-header m_4">
                            <h5 class="modal-title" id="exampleModalLabel">Editar Biologico</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body m_4_1">
                            <form action="../../Functions/EditDetalleReporte.php" method="post">
                                <input type="hidden" id="idEditarDetalles" name="idEditarDetalles" />
                                <div class="mb-3">
                                    <label class="form-label">Descripcion Biologico</label>
                                    <select class="comboboxRegistrar1" name="DetalleBiologico1" id="DetalleBiologico1">
                                        <option class="opcion">SELECCIONAR UN BIOLOGICO</option>
                                        <?php foreach ($productos->productos as $valor => $value) { ?>
                                            <option class="opcion1">
                                                <?php echo $productos->getNombre($valor) ?></option>
                                        <?php } ?>
                                    </select>
                                    <div class="validarErrores" id="MensajeError1" >Selecciona un biologico</div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Lote</label>
                                    <input type="text" class="form-control  lotes" id="lote1" name="lote1" placeholder="Lote..." required />
                                    <div id="MensajeErrorLote1" class="validarErrores">No se a especificado un lote</div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Stock</label>
                                    <input type="number"  class="form-control  display  sumIngreso sumTotal1 verificarLote1 MensajeError1" id="stock1" name="stock1" placeholder="stock..." required />
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Ingresos</label>
                                    <input type="number" class="form-control  sumIngreso1  sumTotal1 verificarLote1 MensajeError1" id="ingreso1" name="ingreso1" min="0" placeholder="Ingresos..." required />
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Ingresos Extra</label>
                                    <input type="number" class="form-control  sumIngreso1 sumTotal1 verificarLote1 MensajeError1" id="ingresoextra1" name="ingresoextra1" min="0" placeholder="Ingresos Extra..." required />
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Ingresos total + Stock</label>
                                    <input type="number" class=" form-control display  MensajeError1" id="stockIngreso1" name="stockIngreso1" placeholder="Total Stock..."/>
                                    <div id="MensajeErrorStock1" class="validarErrores">El Stock del biologico es insuficiente </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Frascos Abiertos</label>
                                    <input type="number" class="form-control verificarLote1 frascoabiertos sumSalida1 sumTotal1 MensajeError1" id="frascoabierto1" min="0" name="frascoabierto1" placeholder="Frascos Abiertos..." required />
                                </div>
                                <div class="mb-3">          
                                    <label class="form-label">Dosis</label>
                                    <input type="number" class="form-control verificarLote1 " id="dosis1" name="dosis1" min="0" max="1000" placeholder="Dosis..." />
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Devolución</label>
                                    <input type="number" class="form-control verificarLote1  sumSalida1 sumTotal1 MensajeError1" id="devolucion1" name="devolucion1" min="0" placeholder="Devolución...">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Total Salida</label>
                                    <input type="number" class=" form-control display MensajeError1" id="salidaTotal1" name="salidaTotal1" placeholder="Total Salida..."/>
                                    <div id="MensajeErrorSalida" class="validarErrores">El total de salida excede el saldo de biologicos</div>
                                </div>
                                <input type="number" class="form-control display MensajeError1" id="stockNuevo1" name="stockNuevo1" placeholder="Total"/>
                                <div class="mb-3">
                                    <label class="form-label">Expiracion</label>
                                    <input type="date" class="form-control verificarLote1 " id="expiracion1" name="expiracion1" placeholder="Expiración..." required />
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Requerimientos</label>
                                    <input type="number" class="form-control verificarLote1" id="requerimientos1" name="requerimientos1" min="0" placeholder="Requerimientos..." />
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Observaciones</label>
                                    <input type="text" class="form-control verificarLote1" id="observaciones1" name="observaciones1" placeholder="Observaciones..." />
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Archivo</label>
                                    <input type="file" class="form-control verificarLote1    " id="archivo1" name="archivo1" placeholder="Archivo..." />
                                </div>

                                <div class="modal-footer d-block btn-block">
                                    <button type="submit" class="editaDetalle"><i class="fas fa-plus"></i>&nbsp&nbspEditar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div>
                <table class="datosreporte">
                    <thead>
                        <tr class="fil_1">
                            <th scope="rowgroup" rowspan="3">CODIGO</th>
                            <th class="inmovil" scope="rowgroup" rowspan="3">DESCRIPCION</th>
                            <th scope="rowgroup" rowspan="3">UNIDAD DE MEDIDA</th>
                            <th scope="colgroup" colspan="4">INGRESO</th>

                            <th scope="colgroup" colspan="4">SALIDAS</th>

                            <th scope="colgroup" colspan="3">DISPONIBLE</th>

                            <th scope="rowgroup" rowspan="3">Requerimiento mes</th>
                            <th scope="rowgroup" rowspan="3">Observaciones</th>
                            <th scope="rowgroup" rowspan="3">Archivos</th>
                            <th scope="rowgroup" rowspan="3">Acciones</th>
                        </tr>
                        <tr class="fil_2">
                            <th scope="rowgroup" rowspan="2">Saldo anterior (frascos)</th>
                            <th scope="rowgroup" rowspan="2">Ingresos (frascos)</th>
                            <th scope="rowgroup" rowspan="2">Ingresos adicionales (frascos)</th>
                            <th scope="rowgroup" rowspan="2">Total (Saldo + Ingreso) (frascos)</th>

                            <th scope="colgroup" colspan="2">INTERVENCION SANITARIA</th>

                            <th style="width:8%" class="col_2">OTRAS SALIDAS</th>

                            <th scope="rowgroup" rowspan="2">Total salidas (frascos)</th>

                            <th scope="rowgroup" rowspan="2">Saldo  disponible (frascos) </th>
                            <th scope="rowgroup" rowspan="2">Fecha de expiracion mas proxima</th>
                            <th scope="rowgroup" rowspan="2">Lote</th>
                        </tr>
                        <tr class="fil_3">
                            <th>FCO (d)</th>
                            <th>Dosis</th>
                            <th>TRANSFE./DEVOLUCION frascos (e)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($detalleReporte->vistadetallReporte as $valor => $value) { ?>
                            <tr>
                                <td class="fil_1_dat">
                                    <?php echo $detalleReporte->vistadetallReporte[$valor]['BiologicosCod'];
                                    ?>
                                </td>
                                <td class="fil_2_dat">
                                    <?php echo $detalleReporte->vistadetallReporte[$valor]['BiologicosNom'] ?>
                                </td>
                                <td class="fil_3_dat">
                                    <?php echo $detalleReporte->vistadetallReporte[$valor]['BiologicosUnidad'] ?>
                                </td>
                                <td class="fil_4_dat">
                                    <?php echo $detalleReporte->vistadetallReporte[$valor]['ReportesStockAnterior'] ?>
                                </td>
                                <td class="fil_5_dat">
                                    <?php echo $detalleReporte->vistadetallReporte[$valor]['ReportesIngresos'] ?>
                                </td>
                                <td class="fil_6_dat">
                                    <?php echo $detalleReporte->vistadetallReporte[$valor]['ReportesIngresosExtra'] ?>
                                </td>
                                <td class="fil_7_dat">
                                    <?php $aux = $detalleReporte->vistadetallReporte[$valor]['ReportesStockAnterior'] + $detalleReporte->vistadetallReporte[$valor]['ReportesIngresos'] + $detalleReporte->vistadetallReporte[$valor]['ReportesIngresosExtra'] ?>

                                    <?php echo $detalleReporte->vistadetallReporte[$valor]['ReportesStockAnterior'] + $detalleReporte->vistadetallReporte[$valor]['ReportesIngresos'] + $detalleReporte->vistadetallReporte[$valor]['ReportesIngresosExtra'] ?>
                                    
                                </td>
                                <td class="fil_8_dat">
                                    <?php echo $detalleReporte->vistadetallReporte[$valor]['ReportesFrascosAbiertos'] ?>
                                </td>
                                <td class="fil_9_dat">
                                    <?php echo $detalleReporte->vistadetallReporte[$valor]['ReportesDosis'] ?>
                                </td>
                                <td class="fil_10_dat">
                                    <?php echo $detalleReporte->vistadetallReporte[$valor]['ReportesDevolucion'] ?>
                                </td>
                                <td class="fil_11_dat">
                                    <?php echo $detalleReporte->vistadetallReporte[$valor]['ReportesFrascosAbiertos'] +$detalleReporte->vistadetallReporte[$valor]['ReportesDevolucion'] ?>
                                </td>
                                <td class="fil_12_dat">
                                    <?php echo $aux - ($detalleReporte->vistadetallReporte[$valor]['ReportesFrascosAbiertos'] +$detalleReporte->vistadetallReporte[$valor]['ReportesDevolucion']) ?>
                                </td>
                                <td class="fil_13_dat">
                                    <?php echo $detalleReporte->vistadetallReporte[$valor]['ReportesExpiracionBiologico'] ?>
                                </td>
                                <td class="fil_14_dat">
                                    <?php echo $detalleReporte->vistadetallReporte[$valor]['LoteBiologicoDescripcion'] ?>
                                </td>
                                <td class="fil_15_dat">
                                    <?php echo $detalleReporte->vistadetallReporte[$valor]['ReportesRequerimientoMes'] ?>
                                </td>
                                <td class="fil_16_dat">
                                    <?php echo $detalleReporte->vistadetallReporte[$valor]['ReporteObservaciones'] ?>
                                </td>
                                <td class="fil_17_dat">
                                    <?php echo $detalleReporte->vistadetallReporte[$valor]['ReportesArchivo'] ?>
                                </td>
                                <td class="fil_18_dat">
                                    <a href="" id="<?= $detalleReporte->vistadetallReporte[$valor]['idReportes'] ?>" param="<?= $detalleReporte->vistadetallReporte[$valor]['ReportesStockAnterior'] ?>"  param1="<?= $detalleReporte->vistadetallReporte[$valor]['BiologicosNom'] ?>" param2="<?= $detalleReporte->vistadetallReporte[$valor]['ReportesIngresos'] ?>" } param3="<?= $detalleReporte->vistadetallReporte[$valor]['ReportesIngresosExtra'] ?>" param4="<?= $detalleReporte->vistadetallReporte[$valor]['ReportesFrascosAbiertos'] ?>" param5="<?= $detalleReporte->vistadetallReporte[$valor]['ReportesDosis'] ?>" param6="<?= $detalleReporte->vistadetallReporte[$valor]['ReportesDevolucion'] ?>" param7="<?= $detalleReporte->vistadetallReporte[$valor]['ReportesExpiracionBiologico'] ?>" param8="<?= $detalleReporte->vistadetallReporte[$valor]['LoteBiologicoDescripcion'] ?>" param9="<?= $detalleReporte->vistadetallReporte[$valor]['ReportesRequerimientoMes'] ?>" param10="<?= $detalleReporte->vistadetallReporte[$valor]['ReporteObservaciones'] ?>" param11="<?= $detalleReporte->vistadetallReporte[$valor]['ReportesArchivo'] ?>" class="editarDetalleReporte" data-bs-toggle="modal" data-bs-target="#modalEditForm"><img src="../assets/bootstrap-icons-1.10.1/pen-fill.svg"></a>
                                    <a class="btneliminar" href="../../Functions/DeleteDetalleReporte.php?id=<?= $detalleReporte->vistadetallReporte[$valor]['idReportes'] ?>" onclick="return confirm('DESEA ELIMINAR?')"><img src="../assets/bootstrap-icons-1.10.1/trash.svg"></a>
                                </td>
                            </tr>
                        <?php } ?>
                        
                    </tbody>
                </table>
            </div>
        </div>
    <script src="../assets/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/scripts.js"></script>
    <script src="../assets/js/jquery.js"></script>
    <script src="../assets/js/jquery-ui.js"></script>
    <script src="../assets/js/funcionDosis.js"></script>
    <script src="../assets/js/RestriccionesRegistrarReporte.js"></script>
    <script src="../assets/js/EditarDetalle.js"></script>
    </body>

    </html>
<?php endif; ?>