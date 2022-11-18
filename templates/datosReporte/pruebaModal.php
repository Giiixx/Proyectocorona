<?php
require_once '../../conections/basededatos.php';
require_once '../../entity/ListaProductos.php';
require_once '../../entity/ListaDetalleReporte.php';
require_once '../../entity/Usuario.php';
require_once '../../Functions/sesion/confirm_existuser.php';
require_once '../../Functions/sesion/confirm_password.php';

session_start();
isset($_SESSION['user_id']) ? null : header('Location: ../index.php');
confirm_existuser($_SESSION['user_id'], $conn) == FALSE ? header('Location:../index.php') : null;

$productos = new ListaProductos($conn);
$detalleReporte = new ListaDetalleReporte($conn);
$detalleReporte->VistaDetalleReporte($conn, $_SESSION["myuser_obj"]->getId());
?>
<?php if (!empty($_SESSION['user_id'])) : ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
        <link rel="stylesheet" href="../assets/css/modal.css">
        <link rel="stylesheet" href="../assets/css/styles.css">
        <link rel="stylesheet" href="../assets/css/jquery-ui.css">
        <title>ola</title>
    </head>

    <body>
        <div>
            <div class="contenedor_add">
                <button class="ref" data-bs-toggle="modal" data-bs-target="#modalForm"><i class="fas fa-plus"></i>&nbsp&nbspAgregar Biologico</button>
            </div>
            <div class="modal fade" id="modalForm" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Registrar Detalle Reporte</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="../../Functions/AddDetalleReporte.php" method="post" enctype="multipart/form-data">
                            <div class="modal-body">
                                <div class="outer-wrapper">
                                    <div class="table-wrapper">
                                        <div class="container">

                                            <table class="">
                                                <thead>
                                                    <tr class="fil_1">
                                                        <th class="inmovil" scope="rowgroup" style="width:6%;" rowspan="3">Biologico</th>


                                                        <th scope="colgroup" colspan="3" style="width:10%;">INGRESO</th>
                                                        <th scope="colgroup" colspan="3">SALIDAS</th>

                                                        <th scope="colgroup" colspan="2" style="width:10%;">DISPONIBLE</th>

                                                        <th scope="rowgroup" rowspan="3" style="width:2%;">Requerimiento mes</th>
                                                        <th scope="rowgroup" rowspan="3" style="width:10%;">Observaciones</th>
                                                    </tr>
                                                    <tr class="fil_2">
                                                        <th scope="rowgroup" rowspan="2">Stock</th>
                                                        <th scope="rowgroup" rowspan="2">Ingresos (frascos)</th>
                                                        <th scope="rowgroup" rowspan="2">Ingresos adicionales (frascos)</th>

                                                        <th scope="colgroup" colspan="2">INTERVENCION SANITARIA</th>

                                                        <th style="width:8%" class="col_2">OTRAS SALIDAS</th>
                                                        <th scope="rowgroup" rowspan="2">Fecha de expiracion mas proxima</th>
                                                        <th scope="rowgroup" rowspan="2">Lote</th>
                                                    </tr>
                                                    <tr class="fil_3">
                                                        <th style="width:5%;">FCO (d)</th>
                                                        <th style="width:3%;">Dosis</th>
                                                        <th style="width:5%;">TRANSFE./DEVOLUCION frascos (e)</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="modaltabla">
                                                    <tr>
                                                        <th>
                                                            <select class="comboboxRegistrar" name="DetalleBiologico" id="DetalleBiologico">
                                                                <option class="opcion">SELECCIONAR UN BIOLOGICO</option>
                                                                <?php foreach ($productos->productos as $valor => $value) { ?>
                                                                    <option class="opcion">
                                                                        <?php echo $productos->getNombre($valor) ?></option>
                                                                <?php } ?>
                                                            </select>
                                                            <div id="MensajeError" class="validarErrores">Selecciona un biologico ps mongol</div>
                                                        </th>
                                                        <th>
                                                            <input type="number" class="form-control stock" id="stock" name="stock" placeholder="stock..." required />
                                                        </th>
                                                        <th>
                                                            <input type="number" class="form-control" id="ingreso" name="ingreso" min="0" placeholder="Ingresos..." required />
                                                        </th>
                                                        <th>
                                                            <input type="number" class="form-control" id="ingresoextra" name="ingresoextra" min="0" placeholder="Ingresos Extra..." required />
                                                        </th>
                                                        <th>
                                                            <input type="number" class="form-control frascoabiertos" id="frascoabierto" min="0" name="frascoabierto" placeholder="Frascos Abiertos..." required />
                                                        </th>
                                                        <th>
                                                            <input type="number" class="form-control" id="dosis" name="dosis" min="0" max="1000" placeholder="Dosis..." />
                                                        </th>
                                                        <th>
                                                            <input type="number" class="form-control" id="devolucion" name="devolucion" min="0" placeholder="Devolución...">
                                                        </th>
                                                        <th>
                                                            <input type="date" class="form-control" id="expiracion" name="expiracion" placeholder="Expiración..." required />
                                                        </th>
                                                        <th>
                                                            <input type="text" class="form-control lotes" id="lote" name="lote" placeholder="Lote..." required />
                                                        </th>
                                                        <th>
                                                            <input type="number" class="form-control" id="requerimientos" name="requerimientos" min="0" placeholder="Requerimientos..." />
                                                        </th>
                                                        <th>
                                                            <input type="text" class="form-control" id="observaciones" name="observaciones" placeholder="Observaciones..." />
                                                            <input type="file" class="form-control" id="archivo" name="archivo" placeholder="Archivo..." />
                                                        </th>
                                                    </tr>
                                                </tbody>
                                            </table>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                <button type="submit" class="agregaDetalle" id="agregaDetalle">wardar</button>
                            </div>
                        </form>
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
                                    <select class="comboboxRegistrar" onchange="combobox()" name="DetalleBiologico1" id="DetalleBiologico1">
                                        <?php foreach ($productos->productos as $valor => $value) { ?>
                                            <option class="opcion">
                                                <?php echo $productos->getNombre($valor) ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Ingresos</label>
                                    <input type="number" class="form-control" id="ingreso1" name="ingreso1" placeholder="Ingresos..." required />
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Ingresos Extra</label>
                                    <input type="number" class="form-control" id="ingresoextra1" name="ingresoextra1" placeholder="Ingresos Extra..." required />
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Frascos Abiertos</label>
                                    <input type="number" class="form-control" id="frascoabierto1" name="frascoabierto1" placeholder="Frascos Abiertos..." required />
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Dosis</label>
                                    <input type="number" class="form-control" id="dosis1" name="dosis1" placeholder="Dosis..." required />
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Devolución</label>
                                    <input type="number" class="form-control" id="devolucion1" name="devolucion1" placeholder="Devolución..." required />
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Expiracion</label>
                                    <input type="date" class="form-control" id="expiracion1" name="expiracion1" placeholder="Expiración..." required />
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Lote</label>
                                    <input type="text" class="form-control" id="lote1" name="lote1" placeholder="Lote..." required />
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Requerimientos</label>
                                    <input type="number" class="form-control" id="requerimientos1" name="requerimientos1" placeholder="Requerimientos..." required />
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Observaciones</label>
                                    <input type="text" class="form-control" id="observaciones1" name="observaciones1" placeholder="Observaciones..." required />
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Archivo</label>
                                    <input type="file" class="form-control" id="archivo1" name="archivo1" placeholder="Archivo..." required />
                                </div>

                                <div class="modal-footer d-block btn-block">
                                    <button type="submit" class=""><i class="fas fa-plus"></i>&nbsp&nbspEditar</button>
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
                            <th scope="rowgroup" rowspan="3">CODIGOñÑ</th>
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
                            <th scope="rowgroup" rowspan="2">Saldo del mes anterior (frascos)</th>
                            <th scope="rowgroup" rowspan="2">Ingresos (frascos)</th>
                            <th scope="rowgroup" rowspan="2">Ingresos adicionales (frascos)</th>
                            <th scope="rowgroup" rowspan="2">Total (Saldo + Ingreso) (frascos)</th>

                            <th scope="colgroup" colspan="2">INTERVENCION SANITARIA</th>

                            <th style="width:8%" class="col_2">OTRAS SALIDAS</th>

                            <th scope="rowgroup" rowspan="2">Total salidas (frascos) (f) d + er</th>

                            <th scope="rowgroup" rowspan="2">Saldo final disponible (frascos) (g) c - f</th>
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
                                    <?php echo $detalleReporte->vistadetallReporte[$valor]['UsuarioBiologicoStock'] ?>
                                </td>
                                <td class="fil_5_dat">
                                    <?php echo $detalleReporte->vistadetallReporte[$valor]['ReportesIngresos'] ?>
                                </td>
                                <td class="fil_6_dat">
                                    <?php echo $detalleReporte->vistadetallReporte[$valor]['ReportesIngresosExtra'] ?>
                                </td>
                                <td class="fil_7_dat">
                                    AWFAQF
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
                                    DWAFWAF
                                </td>
                                <td class="fil_12_dat">
                                    DWAD
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
                                    <a href="" id="<?= $detalleReporte->vistadetallReporte[$valor]['idReportes'] ?>" param1="<?= $detalleReporte->vistadetallReporte[$valor]['BiologicosNom'] ?>" param2="<?= $detalleReporte->vistadetallReporte[$valor]['ReportesIngresos'] ?>" } param3="<?= $detalleReporte->vistadetallReporte[$valor]['ReportesIngresosExtra'] ?>" param4="<?= $detalleReporte->vistadetallReporte[$valor]['ReportesFrascosAbiertos'] ?>" param5="<?= $detalleReporte->vistadetallReporte[$valor]['ReportesDosis'] ?>" param6="<?= $detalleReporte->vistadetallReporte[$valor]['ReportesDevolucion'] ?>" param7="<?= $detalleReporte->vistadetallReporte[$valor]['ReportesExpiracionBiologico'] ?>" param8="<?= $detalleReporte->vistadetallReporte[$valor]['LoteBiologicoDescripcion'] ?>" param9="<?= $detalleReporte->vistadetallReporte[$valor]['ReportesRequerimientoMes'] ?>" param10="<?= $detalleReporte->vistadetallReporte[$valor]['ReporteObservaciones'] ?>" param11="<?= $detalleReporte->vistadetallReporte[$valor]['ReportesArchivo'] ?>" class="editarDetalleReporte" data-bs-toggle="modal" data-bs-target="#modalEditForm"><img src="../assets/bootstrap-icons-1.10.1/pen-fill.svg"></a>
                                    <a class="btneliminar" href="../../Functions/DeleteDetalleReporte.php?id=<?= $detalleReporte->vistadetallReporte[$valor]['idReportes'] ?>" onclick="return confirm('DESEA ELIMINAR?')"><img src="../assets/bootstrap-icons-1.10.1/trash.svg"></a>
                                </td>
                            </tr>
                        <?php } ?>
                        <script src="../assets/js/bootstrap.bundle.min.js"></script>
                        <script src="../assets/js/scripts.js"></script>
                        <script src="../assets/js/jquery.js"></script>
                        <script src="../assets/js/jquery-ui.js"></script>
                        <script src="../assets/js/funcionDosis.js"></script>
                        <script src="../assets/js/EditarDetalle.js"></script>



                    </tbody>
                </table>
            </div>
        </div>

    </body>

    </html>
<?php endif; ?>