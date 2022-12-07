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
$idUsuario = $_SESSION["myuser_obj"]->getId();
$detalleReporte->SearchReporteById($conn, $idUsuario);
$idReporte = $detalleReporte->reporte['idReporte'];
$detalleReporte->SearchReporteMes($conn, $idUsuario, $idReporte);

$detalleReporte->ListaBiologicosByReportMonth($conn,$idReporte, $idUsuario);

foreach($detalleReporte->lista as $valor=>$value){
    $nombreBiologico = $detalleReporte->lista[$valor]['BiologicosNom'];
    $detalleReporte->UltimaFechaAndObservacion($conn,$nombreBiologico,$idReporte,$idUsuario);
    $arrayUltimaFilaExpiracion[$valor]=$detalleReporte->ultimo['ReportesExpiracionBiologico'];
    $arrayUltimaFilaObservacion[$valor]=$detalleReporte->ultimo['ReporteObservaciones'];
    $arrayUltimaFilaArchivo[$valor]=$detalleReporte->ultimo['ReportesArchivo'];
}

$habilitar = $detalleReporte->SearchReporteByIdBool($conn,$idUsuario) ? ($detalleReporte->reporte['ReporteApertura']>$fecha_actual ? FALSE :TRUE ) : TRUE;
$habilitar ?  header('Location:') :header('Location:../../index.php');

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
                            <td class="fil<?= $detalleReporte->vistadetallReporte[$valor]['Categoria_idCategoria'] ?>" >
                                    <?php echo $detalleReporte->vistadetallReporte[$valor]['BiologicosCod'];
                                    ?>
                                </td>
                                <td class="fil<?= $detalleReporte->vistadetallReporte[$valor]['Categoria_idCategoria'] ?>">
                                    <?php echo $detalleReporte->vistadetallReporte[$valor]['BiologicosNom'] ?>
                                </td  >
                                <td class="fil<?= $detalleReporte->vistadetallReporte[$valor]['Categoria_idCategoria'] ?>">
                                    <?php echo $detalleReporte->vistadetallReporte[$valor]['BiologicosUnidad'] ?>
                                </td >
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
                                    <?php echo $arrayUltimaFilaExpiracion[$valor]?>
                                </td>
                                <td class="fil_14_dat">
                                    <?php echo $detalleReporte->vistadetallReporte[$valor]['lotes'] ?>
                                </td>
                                <td class="fil_15_dat">
                                    <?php echo $detalleReporte->vistadetallReporte[$valor]['Requerimientos'] ?>
                                </td>
                                <td class="fil_16_dat   ">
                                    <div class="contenedorObservaciones">
                                        <div>
                                            <?php echo $arrayUltimaFilaObservacion[$valor] ?>
                                        </div>

                                        <?php if ($arrayUltimaFilaArchivo[$valor] != '') { ?>
                                            

                                            <?php if (substr($arrayUltimaFilaArchivo[$valor], -3) == 'jpg' or substr($arrayUltimaFilaArchivo[$valor], -3) == 'png'  or substr($arrayUltimaFilaArchivo[$valor], -4) == 'jpeg') { ?>
                                                <button type="button"  aux="<?= '../../archives/'.$idUsuario.'/'.$fecha_actual.'/'.$detalleReporte->vistadetallReporte[$valor]['BiologicosCod'].'/'.$arrayUltimaFilaArchivo[$valor] ?>"   observacion="<?= $arrayUltimaFilaObservacion[$valor] ?>" class="verArchivos" data-bs-toggle="modal" data-bs-target="#modalArchivo">
                                                    Ver Imagen
                                                </button>
                                            <?php }else { ?>
                                                <a href="<?= '../../archives/'.$idUsuario.'/'.$fecha_actual.'/'.$detalleReporte->vistadetallReporte[$valor]['BiologicosCod'].'/'.$arrayUltimaFilaArchivo[$valor] ?>" download="<?= $arrayUltimaFilaArchivo[$valor]?>">descargar archivo</a>
                                            <?php } ?>
                                        <?php } ?>

                                    </div>

                                </td>
                            </tr>
                        <?php } ?>

                    </tbody>
                </table>
            </div>
            <?php if (date("d")<= 5 and date("d")>0) { ?>    
                
            <div>
                <a class="" href="../../Functions/AddReporte.php">Cierre Mensual</a>
            </div>
            <?php  } ?>

        </div>
        </div>

        
        <script src="../assets/js/vendor.bundle.base.js"></script>
        <script src="../assets/js/off-canvas.js"></script>
        <script src="../assets/js/hoverable-collapse.js"></script>
        <script src="../assets/js/misc.js"></script>
        <script src="../assets/js/scripts.js"></script>
        <script src="../assets/js/jquery.js"></script>
        <script src="../assets/js/jquery-ui.js"></script>
        <script src="../assets/js/EditarDetalle.js"></script>
        <script src="../assets/js/archivos.js"></script>


    <?php endif; ?>
    </body>

    </html>