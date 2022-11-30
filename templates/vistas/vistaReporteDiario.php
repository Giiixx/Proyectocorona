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
$listaFechas = new ListaDetalleReporte($conn);
$detalleReporte = new ListaDetalleReporte($conn);
date_default_timezone_set("America/Bogota");
$fecha_actual = date("Y-m-d");  
$idUsuario = $_SESSION["myuser_obj"]->getId();

$listaFechas->ListaFechasUsuario($conn, $idUsuario);
$detalleReporte->SearchReporteFechaByUsuario($conn,$idUsuario,$fecha_actual);
$detalleReporte->SearchReporteById($conn, $idUsuario);
$habilitar = $detalleReporte->SearchReporteByIdBool($conn,$idUsuario) ? ($detalleReporte->reporte['ReporteApertura']>$fecha_actual ? FALSE :TRUE ) : TRUE;
?>


<?php require '../partials/headerhtml.php' ?>

<?php if (!empty($_SESSION['user_id'])) : ?>
    <title>Reporte Diario</title>
    </head>

    <body>

        <?php require '../partials/navbar.php' ?>
        <div class="main-panel">

            <!-- 
            <div class="contenedor_add">
                <button class="ref" data-bs-toggle="modal" data-bs-target="#modalForm"><i class="fas fa-plus"></i>&nbsp&nbspAgregar Biologico</button>
            </div>
            Modal Registrar 
            <div class="modal fade m_1" id="modalForm" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog m_2">
                    <div class="modal-content m_3">
                        <div class="modal-header m_4">
                            <h5 class="modal-title" id="exampleModalLabel">Registrar nueva Biologico</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body m_4_1">
                            <form class="formularioRegistrar" action="../../Functions/AddDetalleReporte.php" method="post" enctype="multipart/form-data">

                            </form>
                        </div>
                    </div>
                </div>
            </div>
            Modal Editar 
            <div class="modal fade me_1" id="modalEditForm" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog m_2">
                    <div class="modal-content m_3">
                        <div class="modal-header m_4">
                            <h5 class="modal-title" id="exampleModalLabel">Editar Biologico</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body m_4_1">
                            <form action="../../Functions/EditDetalleReporte.php" method="post">
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            
            -->
            <div>
                <label class="form-label">Buscar Reporte por Fecha</label>
                <select class="comboboxFecha" name="ReporteDiario" id="ReporteDiario">
                    <?php foreach ($listaFechas->detalleReporte as $valor => $value) { ?>
                        <option class="opcion">
                            <?php echo $listaFechas->detalleReporte[$valor]['fecha'] ?></option>
                    <?php } ?>
                </select>
            </div>
            <div>
                <table >
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
                    <tbody class="datosreportediario" id="datosreportediario" name="datosreportediario">
                        

                    </tbody>
                </table>
            </div>

        </div>
        </div>
        <script src="../assets/js/vendor.bundle.base.js"></script>
        <script src="../assets/js/off-canvas.js"></script>
        <script src="../assets/js/hoverable-collapse.js"></script>
        <script src="../assets/js/misc.js"></script>
        <script src="../assets/js/scripts.js"></script>
        <script src="../assets/js/jquery.js"></script>
        <script src="../assets/js/jquery-ui.js"></script>
        <script src="../assets/js/vistaReporteDiario.js"></script>

    <?php endif; ?>
    </body>

    </html>