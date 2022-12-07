<?php
require_once '../../conections/basededatos.php';
require_once '../../entity/ListaDetalleReporte.php';
require_once '../../entity/Usuario.php';
require_once '../../Functions/sesion/confirm_existuser.php';
require_once '../../Functions/sesion/confirm_password.php';

session_start();
isset($_SESSION['user_id']) ? null : header('Location: ../../index.php');
confirm_existuser($_SESSION['user_id'], $conn) == FALSE ? header('Location:../../index.php') : null;

$detalleReporte = new ListaDetalleReporte($conn);
date_default_timezone_set("America/Bogota");
$fecha_actual = date("Y-m-d");
$idUsuario = $_SESSION["myuser_obj"]->getId();

$detalleReporte->SearchEstablecimientos($conn);

$_SESSION['myuser_obj']->getRol() == 3 or $_SESSION['myuser_obj']->getRol() == 1  ? null : header('Location: ../../index.php');


?>


<?php require '../partials/headerhtmlconfiguracion.php' ?>

<?php if (!empty($_SESSION['user_id'])) : ?>
    <title>Reportes Cerrados</title>
    </head>

    <body>

        <?php require '../partials/navbarConfiguracion.php' ?>
        <div class="main-panel navbar-nav-scroll">

            <!-- Modal Archivo -->
            <div class="modal fade" id="modalArchivo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Observaciones</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <img id="imagenmodal" src="" alt="">
                            <p id="parrafo"></p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>


            <div class="conteiner-selects">
                <div class="conteiner-cajas">
                    <label class="form-label">Buscar Reporte De Establecimiento : </label>
                    <select class="comboboxReportes" name="nombreEstablecimiento" id="nombreEstablecimiento">
                        <?php foreach ($detalleReporte->lista as $valor => $value) { ?>
                            <option class="opcion">
                                <?= $detalleReporte->lista[$valor]['UsuariosDescEstablecimiento'] ?></option>
                        <?php } ?>
                    </select>

                </div>
                <div class="conteiner-cajas2">
                    <label class="form-label">Fecha Cierre :</label>
                    <input type="text" id='fechas' placeholder="Ejemplo: 2022-10-12">
                    <div class="validarErrores" id="MensajeError1">Selecciona un Fecha Mostrada</div>

                </div>
                <div class="conteiner-cajas3">
                    <button class="descargar" id="dowloadexcel">
                        Descargar Vista en Excel
                    </button>
                </div>

            </div>

            <div class="tablefix">
                <table class="datosreporte" id="example-table">
                    <thead class="table-fixed">
                        <tr class="fil_1">
                            <th class="celeste" scope="rowgroup" rowspan="3">CODIGO</th>
                            <th class="inmovil celeste" scope="rowgroup" rowspan="3">DESCRIPCION</th>
                            <th class="celeste" scope="rowgroup" rowspan="3">UNIDAD DE MEDIDA</th>
                            <th class="rosa" scope="colgroup" colspan="4">INGRESO</th>

                            <th class="verde" scope="colgroup" colspan="4">SALIDAS</th>

                            <th class="morado" scope="colgroup" colspan="3">DISPONIBLE</th>

                            <th class="celeste" scope="rowgroup" rowspan="3">Requerimiento mes</th>
                            <th class="celeste" scope="rowgroup" rowspan="3">Observaciones</th>
                        </tr>
                        <tr class="fil_2">
                            <th class="rosa" scope="rowgroup" rowspan="2">Saldo anterior (frascos)</th>
                            <th class="rosa" scope="rowgroup" rowspan="2">Ingresos (frascos)</th>
                            <th class="rosa" scope="rowgroup" rowspan="2">Ingresos adicionales (frascos)</th>
                            <th class="rosa" scope="rowgroup" rowspan="2">Total (Saldo + Ingreso) (frascos)</th>

                            <th class="verde" scope="colgroup" colspan="2">INTERVENCION SANITARIA</th>

                            <th class="verde" class="col_2">OTRAS SALIDAS</th>

                            <th class="verde" scope="rowgroup" rowspan="2">Total salidas (frascos)</th>

                            <th class="morado" scope="rowgroup" rowspan="2">Saldo disponible (frascos) </th>
                            <th class="morado" scope="rowgroup" rowspan="2">Fecha de expiracion mas proxima</th>
                            <th class="morado" scope="rowgroup" rowspan="2">Lote</th>
                        </tr>
                        <tr class="fil_3">
                            <th class="verde">FCO (d)</th>
                            <th class="verde">Dosis</th>
                            <th class="verde">TRANSFE./DEVOLUCION frascos (e)</th>
                        </tr>
                    </thead>
                    <tbody class="datosreportes" id="datosreportes" name="datosreportes">



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
        <script src="../assets/js/vistaReportes.js"></script>
        <script src="../assets/js/archivos.js"></script>
        <script src="../assets/js/table2excel.js"></script>
        <script src="../assets/js/exporttabla.js"></script>

    <?php endif; ?>
    </body>

    </html>