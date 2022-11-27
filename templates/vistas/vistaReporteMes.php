<?php
require_once '../../conections/basededatos.php';
require_once '../../entity/ListaProductos.php';
require_once '../../entity/ListaDetalleReporte.php';
require_once '../../entity/Usuario.php';
require_once '../../Functions/sesion/confirm_existuser.php';
require_once '../../Functions/sesion/confirm_password.php';

session_start();
isset($_SESSION['user_id']) ? null : header('Location: ../../index.php');
confirm_existuser($_SESSION['user_id'], $conn) == FALSE ? header('Location:../../index.php') : null;

$productos = new ListaProductos($conn);
$detalleReporte = new ListaDetalleReporte($conn);
date_default_timezone_set("America/Bogota");
$fecha_actual = date("Y-m-d");
$detalleReporte->SearchReporteById($conn, $_SESSION["myuser_obj"]->getId());
$detalleReporte->SearchReporteMes($conn, $_SESSION["myuser_obj"]->getId(), $detalleReporte->reporte['idReporte']);


?>

<?php require '../partials/headerhtml.php' ?>

<?php if (!empty($_SESSION['user_id'])) : ?>
    <title>Reporte Diario</title>
    </head>

    <body>

        <?php require '../partials/navbar.php' ?>
        <div class="clearfix">
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
                                    <div class="validarErrores" id="MensajeError1">Selecciona un biologico</div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Lote</label>
                                    <input type="text" class="form-control  lotes" id="lote1" name="lote1" placeholder="Lote..." required />
                                    <div id="MensajeErrorLote1" class="validarErrores">No se a especificado un lote</div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Stock</label>
                                    <input type="number" class="form-control  display  sumIngreso sumTotal1 verificarLote1 MensajeError1" id="stock1" name="stock1" placeholder="stock..." required />
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
                                    <input type="number" class=" form-control display  MensajeError1" id="stockIngreso1" name="stockIngreso1" placeholder="Total Stock..." />
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
                                    <input type="number" class=" form-control display MensajeError1" id="salidaTotal1" name="salidaTotal1" placeholder="Total Salida..." />
                                    <div id="MensajeErrorSalida" class="validarErrores">El total de salida excede el saldo de biologicos</div>
                                </div>
                                <input type="number" class="form-control display MensajeError1" id="stockNuevo1" name="stockNuevo1" placeholder="Total" />
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
                        </tr>
                        <tr class="fil_2">
                            <th scope="rowgroup" rowspan="2">Saldo anterior (frascos)</th>
                            <th scope="rowgroup" rowspan="2">Ingresos (frascos)</th>
                            <th scope="rowgroup" rowspan="2">Ingresos adicionales (frascos)</th>
                            <th scope="rowgroup" rowspan="2">Total (Saldo + Ingreso) (frascos)</th>

                            <th scope="colgroup" colspan="2">INTERVENCION SANITARIA</th>

                            <th style="width:8%" class="col_2">OTRAS SALIDAS</th>

                            <th scope="rowgroup" rowspan="2">Total salidas (frascos)</th>

                            <th scope="rowgroup" rowspan="2">Saldo disponible (frascos) </th>
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
                                    <?php echo $detalleReporte->vistadetallReporte[$valor]['StockAnterior'] ?>
                                </td>
                                <td class="fil_5_dat">
                                    <?php echo $detalleReporte->vistadetallReporte[$valor]['Ingreso'] ?>
                                </td>
                                <td class="fil_6_dat">
                                    <?php echo $detalleReporte->vistadetallReporte[$valor]['IngresoExtra'] ?>
                                </td>
                                <td class="fil_7_dat">
                                    <?php echo $detalleReporte->vistadetallReporte[$valor]['sumatotalingreso'] ?>
                                </td>
                                <td class="fil_8_dat">
                                    <?php echo $detalleReporte->vistadetallReporte[$valor]['Fco'] ?>
                                </td>
                                <td class="fil_9_dat">
                                    <?php echo $detalleReporte->vistadetallReporte[$valor]['Dosis'] ?>
                                </td>
                                <td class="fil_10_dat">
                                    <?php echo $detalleReporte->vistadetallReporte[$valor]['Devolucion'] ?>
                                </td>
                                <td class="fil_11_dat">
                                    <?php echo $detalleReporte->vistadetallReporte[$valor]['sumatotalsalida'] ?>
                                </td>
                                <td class="fil_12_dat">
                                    <?php echo $detalleReporte->vistadetallReporte[$valor]['StockDisponible'] ?>
                                </td>
                                <td class="fil_13_dat">

                                </td>
                                <td class="fil_14_dat">

                                </td>
                                <td class="fil_15_dat">
                                    <?php echo $detalleReporte->vistadetallReporte[$valor]['Requerimientos'] ?>
                                </td>
                                <td class="fil_16_dat">

                                </td>
                                <td class="fil_17_dat">

                                </td>

                            </tr>
                        <?php } ?>

                    </tbody>
                </table>
            </div>
            <!--habilitar para enviar reporte de 1 a 5 del mes <?php //if (date("d")< 5 and date("d")>0) { ?>-->
                
            <div>
                <a class="" href="../../Functions/AddReporte.php">Cierre Mensual</a>
            </div>
            <!--<?php // } ?>-->

        </div>
        </div>

        <script src="../assets/js/bootstrap.bundle.min.js"></script>
        <script src="../assets/js/scripts.js"></script>
        <script src="../assets/js/jquery.js"></script>
        <script src="../assets/js/jquery-ui.js"></script>
        <script src="../assets/js/EditarDetalle.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/jquery@2.2.4/dist/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.4/dist/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/jquery-match-height@0.7.2/dist/jquery.matchHeight.min.js"></script>
        <script src="../assets/js/dash.js"></script>


    <?php endif; ?>
    </body>

    </html>