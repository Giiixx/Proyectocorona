<?php
class ListaDetalleReporte
{
    public $detalleReporte;
    public $detalleReportefecha;
    public $vistadetallReporte;
    public $reporte;
    public $lote;
    public $lista;
    public $ultimo;

    public function __construct($conn)
    {
        $select = $conn->prepare("SELECT * FROM detallereportes");
        $select->execute();
        $this->detalleReporte = $select->fetchALL(PDO::FETCH_ASSOC);
    }

    public function init($conn)
    {
        $select = $conn->prepare("SELECT * FROM detallereportes");
        $select->execute();
        $this->detalleReporte = $select->fetchALL(PDO::FETCH_ASSOC);
    }

    /**************************REPORTES*******************************************/


    public function SearchReporteByfecha($conn, $fecha, $idusuario)
    {
        $select = $conn->prepare("SELECT * from  reporte 
        where Usuarios_idEstablecimiento=:idusuario and ReporteFechaApertura between :fecha and date_add(:fecha, interval 1 month)");
        $select->bindParam(':idusuario', $idusuario);
        $select->bindParam(':fecha', $fecha);
        $select->execute();
        $this->reporte = $select->fetch(PDO::FETCH_ASSOC);
    }

    public function SearchReporteById($conn, $idusuario)
    {
        $select = $conn->prepare("SELECT * from  reporte 
        where Usuarios_idEstablecimiento=:idusuario and ReporteFechaCierre IS NULL");
        $select->bindParam(':idusuario', $idusuario);
        $select->execute();
        $this->reporte = $select->fetch(PDO::FETCH_ASSOC);
    }
    public function SearchReporteByIdBool($conn, $idusuario)
    {
        $select = $conn->prepare("SELECT * from  reporte 
        where Usuarios_idEstablecimiento=:idusuario and ReporteFechaCierre IS NULL");
        $select->bindParam(':idusuario', $idusuario);
        return $select->execute() ? TRUE : FALSE;
    }
    public function IngresarReportesUsuario($conn, $nombre, $idUsuario, $fecha)
    {
        $stm = "INSERT INTO reporte (
            ReporteNombre,
            Usuarios_idEstablecimiento,
            ReporteApertura)
            VALUES
            (:nombre,   
            :idUsuario,
            :fecha)";
        $sql = $conn->prepare($stm);
        $sql->bindParam(':nombre', $nombre);
        $sql->bindParam(':idUsuario', $idUsuario);
        $sql->bindParam(':fecha', $fecha);
        return $sql->execute() ? TRUE : FALSE;
    }
    public function UpdateReportesUsuario($conn, $fecha, $hora, $idReporte)
    {
        $stm = "UPDATE reporte SET  
            ReporteFechaCierre=:fecha,
            ReporteHoraCierre=:hora
            WHERE idReporte=:idReporte";
        $sql = $conn->prepare($stm);
        $sql->bindParam(':hora', $hora);
        $sql->bindParam(':fecha', $fecha);
        $sql->bindParam(':idReporte', $idReporte);
        return $sql->execute() ? TRUE : FALSE;
    }
    /************************************************************************************ */
    public function VistaDetalleReporte($conn, $idusuario, $fecha, $idReporte)
    {
        $select = $conn->prepare("SELECT * FROM detallereportes det
	    INNER JOIN
        reporte rep on det.Reporte_idReporte=rep.idReporte
	    INNER JOIN
        usuariobiologico usu ON det.UsuarioBiologico_idUsuarioBiologico = usu.idUsuarioBiologico
	    INNER JOIN
        biologicos bio ON usu.Biologicos_idBiologicos = bio.idBiologicos
	    WHERE 
        usu.Usuarios_idUsuarios=:idusuario and rep.idReporte=:idReporte and date(ReportesFechaAdd)=:fecha order by idReportes");

        $select->bindParam(':idusuario', $idusuario);
        $select->bindParam(':idReporte', $idReporte);
        $select->bindParam(':fecha', $fecha);
        $select->execute();
        $this->vistadetallReporte = $select->fetchALL(PDO::FETCH_ASSOC);
    }

    public function VistaDetalleReporteByBiologico($conn, $idusuario, $idBiologico)
    {
        $select = $conn->prepare("SELECT * FROM detallereportes det
                INNER JOIN
            usuariobiologico usu ON det.UsuarioBiologico_idUsuarioBiologico = usu.idUsuarioBiologico
                INNER JOIN
            biologicos bio ON usu.Biologicos_idBiologicos = bio.idBiologicos
                WHERE usu.Usuarios_idUsuarios=:idusuario and usu.Biologicos_idBiologicos=:idBiologico  order by idReportes ");
        $select->bindParam(':idusuario', $idusuario);
        $select->bindParam(':idBiologico', $idBiologico);
        $select->execute();
        $this->vistadetallReporte = $select->fetchALL(PDO::FETCH_ASSOC);
    }

    public function IngresarDetalleReporte(
        $conn,
        $ReporteSaldoAnterior,
        $ReportesIngresos,
        $ReportesIngresosExtra,
        $ReportesFrascosAbiertos,
        $ReportesDosis,
        $ReportesDevolucion,
        $ReportesExpiracionFecha,
        $Lote,
        $ReportesRequerimientoMes,
        $ReporteObservaciones,
        $ReportesArchivo,
        $ReportesFechaAdd,
        $ReportesHabilitadoEditar,
        $idUsuarioBiologico,
        $Reporte_idReporte
    ) {
        $sql = "INSERT INTO detallereportes 
                        (ReportesStockAnterior,
                        ReportesIngresos, 
                        ReportesIngresosExtra,
                        ReportesFrascosAbiertos, 
                        ReportesDosis,
                        ReportesDevolucion, 
                        ReportesExpiracionBiologico , 
                        ReportesLote,
                        ReportesRequerimientoMes,
                        ReporteObservaciones, 
                        ReportesArchivo,
                        ReportesFechaAdd, 
                        ReportesHabilitadoEditar,
                        UsuarioBiologico_idUsuarioBiologico,
                        Reporte_idReporte) 
                    VALUES 
                        (:ReporteSaldoAnterior,
                        :ReportesIngresos,     
                        :ReportesIngresosExtra,
                        :ReportesFrascosAbiertos,  
                        :ReportesDosis,  
                        :ReportesDevolucion, 
                        :ReportesExpiracionBiologico, 
                        :Lote,
                        :ReportesRequerimientoMes,
                        :ReporteObservaciones, 
                        :ReportesArchivo,
                        :ReportesFechaAdd,
                        :ReportesHabilitadoEditar,
                        :idUsuarioBiologico,
                        :Reporte_idReporte)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':ReporteSaldoAnterior', $ReporteSaldoAnterior);
        $stmt->bindParam(':ReportesIngresos', $ReportesIngresos);
        $stmt->bindParam(':ReportesIngresosExtra', $ReportesIngresosExtra);
        $stmt->bindParam(':ReportesFrascosAbiertos', $ReportesFrascosAbiertos);
        $stmt->bindParam(':ReportesDosis', $ReportesDosis);
        $stmt->bindParam(':ReportesDevolucion', $ReportesDevolucion);
        $stmt->bindParam(':ReportesExpiracionBiologico', $ReportesExpiracionFecha);
        $stmt->bindParam(':Lote', $Lote);
        $stmt->bindParam(':ReportesRequerimientoMes', $ReportesRequerimientoMes);
        $stmt->bindParam(':ReportesArchivo', $ReportesArchivo);
        $stmt->bindParam(':ReporteObservaciones', $ReporteObservaciones);
        $stmt->bindParam(':ReportesFechaAdd', $ReportesFechaAdd);
        $stmt->bindParam(':ReportesHabilitadoEditar', $ReportesHabilitadoEditar);
        $stmt->bindParam(':idUsuarioBiologico', $idUsuarioBiologico);
        $stmt->bindParam(':Reporte_idReporte', $Reporte_idReporte);

        return $stmt->execute() ? TRUE : FALSE;
    }





    public function UpdateDetalleReporte(
        $conn,
        $ReportesStockAnterior,
        $ReportesIngresos,
        $ReportesIngresosExtra,
        $ReportesFrascosAbiertos,
        $ReportesDosis,
        $ReportesDevolucion,
        $ReportesExpiracionFecha,
        $Lote,
        $ReportesRequerimientoMes,
        $ReporteObservaciones,
        $ReportesArchivo,
        $ReportesHabilitadoEditar,
        $idUsuarioBiologico,
        $idReportes
    ) {
        $sql = "UPDATE detallereportes SET 
                        ReportesStockAnterior=:ReportesStockAnterior,
                        ReportesIngresos=:ReportesIngresos,
                        ReportesIngresosExtra=:ReportesIngresosExtra,
                        ReportesFrascosAbiertos=:ReportesFrascosAbiertos,
                        ReportesDosis=:ReportesDosis,
                        ReportesDevolucion=:ReportesDevolucion,
                        ReportesExpiracionBiologico=:ReportesExpiracionFecha,
                        ReportesLote=:Lote,
                        ReportesRequerimientoMes=:ReportesRequerimientoMes,
                        ReporteObservaciones=:ReporteObservaciones,
                        ReportesArchivo=:ReportesArchivo,
                        ReportesHabilitadoEditar=:ReportesHabilitadoEditar,
                        UsuarioBiologico_idUsuarioBiologico=:idUsuarioBiologico
                        WHERE idReportes=:idReportes";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':ReportesStockAnterior', $ReportesStockAnterior);
        $stmt->bindParam(':ReportesIngresos', $ReportesIngresos);
        $stmt->bindParam(':ReportesIngresosExtra', $ReportesIngresosExtra);
        $stmt->bindParam(':ReportesFrascosAbiertos', $ReportesFrascosAbiertos);
        $stmt->bindParam(':ReportesDosis', $ReportesDosis);
        $stmt->bindParam(':ReportesDevolucion', $ReportesDevolucion);
        $stmt->bindParam(':ReportesExpiracionFecha', $ReportesExpiracionFecha);
        $stmt->bindParam(':Lote', $Lote);
        $stmt->bindParam(':ReportesRequerimientoMes', $ReportesRequerimientoMes);
        $stmt->bindParam(':ReporteObservaciones', $ReporteObservaciones);
        $stmt->bindParam(':ReportesArchivo', $ReportesArchivo);
        $stmt->bindParam(':ReportesHabilitadoEditar', $ReportesHabilitadoEditar);
        $stmt->bindParam(':idUsuarioBiologico', $idUsuarioBiologico);
        $stmt->bindParam(':idReportes', $idReportes);

        return $stmt->execute() ? TRUE : FALSE;
    }

    public function DeleteDetallleReporte($conn, $idReportes)
    {
        $sql = "DELETE FROM detallereportes WHERE idReportes=:idReportes";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':idReportes', $idReportes);
        return $stmt->execute() ? TRUE : FALSE;
    }

    public function SearchDetalleReporteById($conn, $idReportes)
    {
        $select = $conn->prepare("SELECT *, date(det.ReportesFechaAdd) as 'fecha' FROM detallereportes det
            INNER JOIN
            usuariobiologico usu ON det.UsuarioBiologico_idUsuarioBiologico = usu.idUsuarioBiologico
            INNER JOIN
            biologicos bio ON usu.Biologicos_idBiologicos = bio.idBiologicos
            WHERE idReportes=:idReportes");
        $select->bindParam(':idReportes', $idReportes);
        $select->execute();
        $this->detalleReporte = $select->fetch(PDO::FETCH_ASSOC);
    }

    public function UpdateStockAnteriorById($conn, $idReportes, $stockAnterior)
    {
        $select = $conn->prepare("UPDATE detallereportes SET ReportesStockAnterior=:stockAnterior where idReportes=:idReportes");
        $select->bindParam(':idReportes', $idReportes);
        $select->bindParam(':stockAnterior', $stockAnterior);
        $select->execute();
        $this->detalleReporte = $select->fetch(PDO::FETCH_ASSOC);
    }


    /***********VISTASSSSSSSSSSSSSSSSSSSSSSSSSSSS********************** */


    public function ListaFechasUsuario($conn, $idUsuario)
    {
        $select = $conn->prepare("SELECT distinct(date(ReportesFechaAdd)) as 'fecha' from detallereportes det
            INNER JOIN
            usuariobiologico usu ON det.UsuarioBiologico_idUsuarioBiologico = usu.idUsuarioBiologico WHERE usu.Usuarios_idUsuarios=:idUsuario order by  ReportesFechaAdd DESC");
        $select->bindParam(':idUsuario', $idUsuario);
        $select->execute();
        $this->detalleReporte = $select->fetchALL(PDO::FETCH_ASSOC);
    }

    public function ListaFechasUsuarioReporte($conn, $idUsuario,$idReporte)
    {
        $select = $conn->prepare("SELECT distinct(date(ReportesFechaAdd)) as 'fecha' from detallereportes det
            INNER JOIN
            reporte rep ON det.Reporte_idReporte=rep.idReporte
            INNER JOIN
            usuariobiologico usu ON det.UsuarioBiologico_idUsuarioBiologico = usu.idUsuarioBiologico 
            WHERE usu.Usuarios_idUsuarios=:idUsuario 
            AND rep.idReporte=:idReporte
            order by  det.ReportesFechaAdd DESC");
        $select->bindParam(':idUsuario', $idUsuario);
        $select->bindParam(':idReporte', $idReporte);
        $select->execute();
        $this->detalleReporte = $select->fetchALL(PDO::FETCH_ASSOC);
    }

    public function SearchReporteFechaByUsuario($conn, $idUsuario, $fecha)
    {
        $select = $conn->prepare("SELECT * ,date(det.ReportesFechaAdd) as 'fecha' from  detallereportes det
                INNER JOIN
            usuariobiologico usu ON det.UsuarioBiologico_idUsuarioBiologico = usu.idUsuarioBiologico
                INNER JOIN
            biologicos bio ON usu.Biologicos_idBiologicos = bio.idBiologicos
            WHERE usu.Usuarios_idUsuarios=:idUsuario and DATE(det.ReportesFechaAdd)=:fecha");
        $select->bindParam(':idUsuario', $idUsuario);
        $select->bindParam(':fecha', $fecha);
        $select->execute();
        $this->vistadetallReporte = $select->fetchALL(PDO::FETCH_ASSOC);
    }

    public function SearchReportesByUsuario($conn, $idUsuario)
    {
        $select = $conn->prepare("SELECT * from  reporte 
            WHERE Usuarios_idEstablecimiento=:idUsuario and ReporteFechaCierre is not null order by ReporteFechaCierre DESC ");
        $select->bindParam(':idUsuario', $idUsuario);
        $select->execute();
        $this->detalleReporte = $select->fetchALL(PDO::FETCH_ASSOC);
    }



    public function SearchReporteDiaAnterior($conn, $idUsuario, $idReporte, $fecha)
    {
        $select = $conn->prepare("SELECT *,date(det.ReportesFechaAdd) as 'fecha' from  detallereportes det
        inner join reporte re ON det.Reporte_idReporte = re.idReporte
                INNER JOIN
            usuariobiologico usu ON det.UsuarioBiologico_idUsuarioBiologico = usu.idUsuarioBiologico
                INNER JOIN
            biologicos bio ON usu.Biologicos_idBiologicos = bio.idBiologicos
            WHERE usu.Usuarios_idUsuarios=:idUsuario and re.idReporte=:idReporte and DATE(det.ReportesFechaAdd)=DATE_ADD(:fecha,INTERVAL -1 DAY)");
        $select->bindParam(':idUsuario', $idUsuario);
        $select->bindParam(':idReporte', $idReporte);
        $select->bindParam(':fecha', $fecha);
        $select->execute();
        $this->vistadetallReporte = $select->fetchALL(PDO::FETCH_ASSOC);
    }

    public function SearchReporteMes($conn, $idUsuario, $idReporte)
    {
        $select = $conn->prepare("SELECT 
                    bio.BiologicosCod,bio.BiologicosNom,bio.BiologicosUnidad,bio.Categoria_idCategoria,
                    det.ReportesStockAnterior  'StockAnterior',
                    sum(det.ReportesIngresos) as 'Ingreso',
                    sum(det.ReportesIngresosExtra)as 'IngresoExtra',
                    (sum(det.ReportesIngresos)+sum(det.ReportesIngresosExtra)+det.ReportesStockAnterior) as 'sumatotalingreso',
                    sum(det.ReportesFrascosAbiertos) as 'Fco',
                    sum(det.ReportesDosis) as 'Dosis',
                    sum(det.ReportesDevolucion) as 'Devolucion',
                    (sum(det.ReportesFrascosAbiertos)+sum(det.ReportesDevolucion)) as 'sumatotalsalida',
                    (sum(det.ReportesIngresos)+sum(det.ReportesIngresosExtra)+det.ReportesStockAnterior)-(sum(det.ReportesFrascosAbiertos)+sum(det.ReportesDevolucion)) as 'StockDisponible',
                    sum(det.ReportesRequerimientoMes) as 'Requerimientos',
                    concat(count(DISTINCT det.ReportesLote ),' Lotes') as 'lotes'    
                    from detallereportes det 
                    inner join reporte re ON det.Reporte_idReporte = re.idReporte
                    inner join usuariobiologico usu on det.UsuarioBiologico_idUsuarioBiologico=usu.idUsuarioBiologico 
                    inner join biologicos bio on usu.Biologicos_idBiologicos=bio.idBiologicos
                    where usu.Usuarios_idUsuarios=:idUsuario and re.idReporte=:idReporte group by bio.BiologicosCod order by bio.idBiologicos");

        $select->bindParam(':idUsuario', $idUsuario);
        $select->bindParam(':idReporte', $idReporte);
        $select->execute();
        $this->vistadetallReporte = $select->fetchALL(PDO::FETCH_ASSOC);
    }


    /*************************************LOTES**************************************************/

    public function SearhLoteByName($conn, $NameLote)
    {
        $select = $conn->prepare("SELECT * from lotes where LotesDescripcion=:NameLote");
        $select->bindParam(':NameLote', $NameLote);
        $select->execute();
        $this->lote = $select->fetch(PDO::FETCH_ASSOC);
    }

    public function ListaLotes($conn)
    {
        $select = $conn->prepare("SELECT * from lotes");
        $select->execute();
        $this->lote = $select->fetchALL(PDO::FETCH_ASSOC);
    }

    public function IngresarLotes($conn, $nombre)
    {
        $stm = "INSERT INTO lotes (
            LotesDescripcion)
            VALUES
            (:nombre)";
        $sql = $conn->prepare($stm);
        $sql->bindParam(':nombre', $nombre);
        return $sql->execute() ? TRUE : FALSE;
    }
    /**************************************************************************************************/

    /*************************************OBTENER FECHA DE EXPIRACION Y OBSERVACIONES ULTIMAS**************************************************/
    public function UltimaFechaAndObservacion($conn, $BiologicoNom, $idreporte, $idUsuario)
    {
        $select = $conn->prepare("SELECT 
        *,date(det.ReportesFechaAdd) as 'fecha'
    FROM
         detallereportes det
            INNER JOIN
        reporte re ON det.Reporte_idReporte = re.idReporte
            INNER JOIN
        usuariobiologico usu ON det.UsuarioBiologico_idUsuarioBiologico = usu.idUsuarioBiologico
            INNER JOIN
        biologicos bio ON usu.Biologicos_idBiologicos = bio.idBiologicos
    WHERE
        usu.Usuarios_idUsuarios = :idUsuario
        AND re.idReporte = :idreporte
        AND bio.BiologicosNom =:BiologicoNom
        order by det.idReportes desc limit 1 ");

        $select->bindParam(':BiologicoNom', $BiologicoNom);
        $select->bindParam(':idreporte', $idreporte);
        $select->bindParam(':idUsuario', $idUsuario);
        $select->execute();
        $this->ultimo = $select->fetch(PDO::FETCH_ASSOC);
    }

    public function ListaBiologicosByReportMonth($conn, $idreporte, $idUsuario)
    {
        $select = $conn->prepare("SELECT 
        bio.BiologicosNom
        FROM
         detallereportes det
            INNER JOIN
        reporte re ON det.Reporte_idReporte = re.idReporte
            INNER JOIN
        usuariobiologico usu ON det.UsuarioBiologico_idUsuarioBiologico = usu.idUsuarioBiologico
            INNER JOIN
        biologicos bio ON usu.Biologicos_idBiologicos = bio.idBiologicos
         WHERE
        usu.Usuarios_idUsuarios = :idUsuario
        AND re.idReporte = :idreporte
        group by bio.BiologicosNom order by bio.idBiologicos");

        $select->bindParam(':idreporte', $idreporte);
        $select->bindParam(':idUsuario', $idUsuario);
        $select->execute();
        $this->lista = $select->fetchALL(PDO::FETCH_ASSOC);
    }

    //------------------------------aarchivos---------------------------------------

    public function ListaArchivos($conn, $idreporte, $idusu, $fecha)
    {
        $select = $conn->prepare("SELECT ReportesArchivo 
        FROM detallereportes 
        where Reporte_idReporte=:idreporte and UsuarioBiologico_idUsuarioBiologico=:idusu AND date(ReportesFechaAdd)=:fecha");

        $select->bindParam(':idreporte', $idreporte);
        $select->bindParam(':idusu', $idusu);
        $select->bindParam(':fecha', $fecha);
        $select->execute();
        $this->lista = $select->fetchALL(PDO::FETCH_ASSOC);
    }


    //*******************************************************REPORTES HABILITADOS************************************************************ */
    public function SearchDetallesReporteHabilitados($conn, $idusu, $idReporte)
    {
        $select = $conn->prepare("SELECT *,date(det.ReportesFechaAdd) as 'fecha' from  detallereportes det 
        inner join reporte re
        on det.Reporte_idReporte=idReporte
        inner join usuariobiologico usu
        on det.UsuarioBiologico_idUsuarioBiologico=usu.idUsuarioBiologico
        inner join biologicos bio
        on usu.Biologicos_idBiologicos = bio.idBiologicos
        where 
        usu.Usuarios_idUsuarios=:idusu
        and re.idReporte=:idReporte
        and det.ReportesHabilitadoEditar='H'");

        $select->bindParam(':idReporte', $idReporte);
        $select->bindParam(':idusu', $idusu);
        $select->execute();
        $this->lista = $select->fetchALL(PDO::FETCH_ASSOC);

        return $select->execute() ? TRUE : FALSE;
    }

    //**************************************************************************************************************************************** */
    public function SearchReportesEstablecimientos($conn)
    {
        $select = $conn->prepare("SELECT UsuariosDescEstablecimiento from usuarios ");

        $select->execute();
        $this->lista = $select->fetchALL(PDO::FETCH_ASSOC);
    }

    public function SearchReportesEstablecimientosAcuales($conn)
    {
        $select = $conn->prepare("SELECT rep.idReporte,usu.UsuariosDescEstablecimiento from reporte  rep inner join usuarios usu 
        on rep.Usuarios_idEstablecimiento=usu.idEstablecimiento
        inner join roles rol
        on usu.Roles_idRoles=rol.idRoles
        where ReporteFechaCierre  is  null and rol.idRoles!=3 order by usu.idEstablecimiento");

        $select->execute();
        $this->lista = $select->fetchALL(PDO::FETCH_ASSOC);
    }

    public function SearchReportesEstablecimientosAcualesJs($conn,$idUsu)
    {
        $select = $conn->prepare("SELECT 
        *,date(det.ReportesFechaAdd) as 'fecha'
        FROM
            detallereportes det
                INNER JOIN
            reporte rep ON det.Reporte_idReporte=rep.idReporte
                INNER JOIN
            usuarios usu ON rep.Usuarios_idEstablecimiento = usu.idEstablecimiento
                INNER JOIN
            usuariobiologico usub ON det.UsuarioBiologico_idUsuarioBiologico = usub.idUsuarioBiologico
                INNER JOIN
            biologicos bio ON usub.Biologicos_idBiologicos = bio.idBiologicos
        WHERE
            ReporteFechaCierre IS NULL
                AND usu.Roles_idRoles != 3
                AND usu.UsuariosDescEstablecimiento = :idUsu
        ORDER BY det.idReportes");
        $select->bindParam(':idUsu', $idUsu);
        $select->execute();
        $this->lista = $select->fetchALL(PDO::FETCH_ASSOC);
    }
    public function SearchReportesEstablecimientosAcualesJs1($conn,$fecha,$idUsu)
    {
        $select = $conn->prepare("SELECT 
        *,date(det.ReportesFechaAdd) as 'fecha'
        FROM
            detallereportes det
                INNER JOIN
            reporte rep ON det.Reporte_idReporte=rep.idReporte
                INNER JOIN
            usuarios usu ON rep.Usuarios_idEstablecimiento = usu.idEstablecimiento
                INNER JOIN
            usuariobiologico usub ON det.UsuarioBiologico_idUsuarioBiologico = usub.idUsuarioBiologico
                INNER JOIN
            biologicos bio ON usub.Biologicos_idBiologicos = bio.idBiologicos
        WHERE
            ReporteFechaCierre IS NULL
                AND usu.Roles_idRoles != 3
                AND usu.UsuariosDescEstablecimiento =:idUsu
                AND date(det.ReportesFechaAdd) = :fecha
        ORDER BY det.idReportes");
        $select->bindParam(':fecha', $fecha);
        $select->bindParam(':idUsu', $idUsu);
        $select->execute();
        $this->lista = $select->fetchALL(PDO::FETCH_ASSOC);
    }

    public function SearchIdUsuarioByName($conn,$name)
    {
        $select = $conn->prepare("SELECT 
        *
        FROM
            usuarios 
        WHERE
            UsuariosDescEstablecimiento =:name");
        $select->bindParam(':name', $name);
        $select->execute();
        $this->lista = $select->fetch(PDO::FETCH_ASSOC);
    }

    public function UpdateEstadoEditar($conn, $estado,  $idDetalleReporte)
    { 
        $stm = "UPDATE detallereportes SET  
            ReportesHabilitadoEditar=:estado
            WHERE idReportes=:idDetalleReporte";
        $sql = $conn->prepare($stm);
        $sql->bindParam(':estado', $estado);
        $sql->bindParam(':idDetalleReporte', $idDetalleReporte);
        return $sql->execute() ? TRUE : FALSE;
    }
    /****************************Cambiar Contrasñeas    ****************************************** */
    public function UpdateContraseña($conn,$establecimiento,$contra)
    {
        $select = $conn->prepare("UPDATE usuarios SET  UsuariosPassword = :contra where UsuariosDescEstablecimiento=:establecimiento");
        $select->bindParam(':contra', $contra);
        $select->bindParam(':establecimiento', $establecimiento);
        $select->execute();

        return $select->execute() ? TRUE : FALSE;
    }


    /****************************ObetnerReportes****************************************** */

    public function SearchEstablecimientos($conn)
    {
        $select = $conn->prepare("SELECT distinct usu.UsuariosDescEstablecimiento from reporte  rep inner join usuarios usu 
        on rep.Usuarios_idEstablecimiento=usu.idEstablecimiento
        inner join roles rol
        on usu.Roles_idRoles=rol.idRoles
        where ReporteFechaCierre  is not null and rol.idRoles!=3 order by usu.idEstablecimiento");
        $select->execute();
        $this->lista = $select->fetchALL(PDO::FETCH_ASSOC);
    }     
    public function SearchFechasCierreOfEstablecimientos($conn,$idEstablecimiento)
    {
        $select = $conn->prepare("SELECT rep.ReporteFechaCierre as 'fecha'from reporte  rep inner join usuarios usu 
        on rep.Usuarios_idEstablecimiento=usu.idEstablecimiento
        inner join roles rol
        on usu.Roles_idRoles=rol.idRoles
        where ReporteFechaCierre  is not null and rol.idRoles!=3 and usu.idEstablecimiento=:idEstablecimiento order by  rep.ReporteFechaCierre desc");
        
        $select->bindParam(':idEstablecimiento', $idEstablecimiento);
        $select->execute();
        $this->lista = $select->fetchALL(PDO::FETCH_ASSOC);
    }    
    
    public function SearchIdReporteByFechaCierreAndIdestablecimiento($conn,$idEstablecimiento,$fechaCierre)
    {
        $select = $conn->prepare("SELECT rep.idReporte from reporte  rep inner join usuarios usu 
        on rep.Usuarios_idEstablecimiento=usu.idEstablecimiento
        inner join roles rol
        on usu.Roles_idRoles=rol.idRoles
        where ReporteFechaCierre  is not null and rol.idRoles!=3 and rep.Usuarios_idEstablecimiento=:idEstablecimiento and rep.ReporteFechaCierre=:fechaCierre  order by  rep.ReporteFechaCierre desc");
        
        $select->bindParam(':idEstablecimiento', $idEstablecimiento);
        $select->bindParam(':fechaCierre', $fechaCierre);
        $select->execute();
        $this->lista = $select->fetch(PDO::FETCH_ASSOC);
    }  


    /* usar para cambiar contraseñas
    public function CONTRASEÑAS($conn)
    {
        $select = $conn->prepare("SELECT 
        * 
        FROM
        usuarios limit 8");
        $select->execute();
        $this->lista = $select->fetchALL(PDO::FETCH_ASSOC);
    }
    */
}
