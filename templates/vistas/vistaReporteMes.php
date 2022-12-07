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
$listaReportes= new ListaDetalleReporte($conn);
$detalleReporte = new ListaDetalleReporte($conn);
date_default_timezone_set("America/Bogota");
$fecha_actual = date("Y-m-d");  
$idUsuario = $_SESSION["myuser_obj"]->getId();

$listaReportes->SearchReportesByUsuario($conn, $_SESSION["myuser_obj"]->getId());
//$detalleReporte->SearchReporteFechaByUsuario($conn,$_SESSION["myuser_obj"]->getId(),$fecha_actual);
$detalleReporte->SearchReporteById($conn, $_SESSION["myuser_obj"]->getId());
$habilitar = $detalleReporte->SearchReporteByIdBool($conn,$idUsuario) ? ($detalleReporte->reporte['ReporteApertura']>$fecha_actual ? FALSE :TRUE ) : TRUE;

$detalleReporte->SearchDetallesReporteHabilitados($conn,$_SESSION["myuser_obj"]->getId(),$detalleReporte->reporte['idReporte']);
$habilitar2 = empty($detalleReporte->lista) ? FALSE : TRUE;

?>


<?php require '../partials/headerhtml.php' ?>

<?php if (!empty($_SESSION['user_id'])) : ?>
    <title>Reporte Diario</title>
    </head>

    <body>

        <?php require '../partials/navbar.php' ?>
        <div class="main-panel">
            <!-- Modal Archivo -->
            <div class="modal fade" id="modalArchivo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Observaciones</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <img id ="imagenmodal" src="" alt="">
                            <p id="parrafo" ></p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>


            <div>
                <label class="form-label">Buscar Reporte por Fecha</label>
                <select class="comboboxReportesMes" name="reporteMes" id="reporteMes">
                    <?php foreach ($listaReportes->detalleReporte as $valor => $value) { ?>
                        <option class="opcion">

                            <?php echo $listaReportes->detalleReporte[$valor]['ReporteNombre']."-Cierre ".$listaReportes->detalleReporte[$valor]['ReporteFechaCierre'] ?>
                        
                        </option>
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
                    <tbody class="datosreportmes" id="datosreportmes" name="datosreportmes">
                        

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
        <script src="../assets/js/vistaReporteMes.js"></script>
        <script src="../assets/js/archivos.js"></script>


    <?php endif; ?>
    </body>

    </html>