<?php
class ListaDetalleReporte
{
    public $detalleReporte;
    public $detalleReportefecha;
    public $vistadetallReporte;
    public $reporte;

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
    public function IngresarReportesUsuario($conn, $nombre, $idUsuario,$fecha)
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
    public function UpdateReportesUsuario($conn,$fecha,$hora,$idReporte)
    {
        $stm = "UPDATE reporte SET  
            ReporteFechaCierre=:fecha,
            ReporteHoraCierre=:hora
            WHERE idReporte=:idReporte";
        $sql = $conn->prepare($stm);
        $sql->bindParam(':hora', $hora);
        $sql->bindParam(':fecha', $fecha);
        $sql->bindParam(':idReporte',$idReporte);
        return $sql->execute() ? TRUE : FALSE;
    }
    /************************************************************************************ */
    public function VistaDetalleReporte($conn, $idusuario, $fecha,$idReporte)
    {
        $select = $conn->prepare("SELECT * FROM detallereportes det
	    INNER JOIN
        reporte rep on det.Reporte_idReporte=rep.idReporte
	    INNER JOIN
        usuariobiologico usu ON det.UsuarioBiologico_idUsuarioBiologico = usu.idUsuarioBiologico
	    INNER JOIN
        biologicos bio ON usu.Biologicos_idBiologicos = bio.idBiologicos
	    INNER JOIN
        lotes lot ON bio.Lotes_idLotes = lot.idLotes
	    WHERE 
        usu.Usuarios_idUsuarios=:idusuario and rep.idReporte=:idReporte and date(ReportesFechaAdd)=:fecha order by idReportes");
        
        $select->bindParam(':idusuario', $idusuario);
        $select->bindParam(':idReporte', $idReporte);
        $select->bindParam(':fecha', $fecha);
        $select->execute();
        $this->vistadetallReporte = $select->fetchALL(PDO::FETCH_ASSOC);
    }

    public function VistaDetalleReporteByBiologico($conn, $idusuario, $fecha, $idBiologico)
    {
        $select = $conn->prepare("SELECT * FROM detallereportes det
                INNER JOIN
            usuariobiologico usu ON det.UsuarioBiologico_idUsuarioBiologico = usu.idUsuarioBiologico
                INNER JOIN
            biologicos bio ON usu.Biologicos_idBiologicos = bio.idBiologicos
                WHERE usu.Usuarios_idUsuarios=:idusuario and usu.Biologicos_idBiologicos=:idBiologico and date(ReportesFechaAdd)=:fecha order by idReportes ");
        $select->bindParam(':idusuario', $idusuario);
        $select->bindParam(':idBiologico', $idBiologico);
        $select->bindParam(':fecha', $fecha);
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
        $ReportesRequerimientoMes,
        $ReporteObservaciones,
        $ReportesArchivo,
        $ReportesFechaAdd,
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
                        ReportesRequerimientoMes,
                        ReporteObservaciones, 
                        ReportesArchivo,
                        ReportesFechaAdd, 
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
                        :ReportesRequerimientoMes,
                        :ReporteObservaciones, 
                        :ReportesArchivo,
                        :ReportesFechaAdd,
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
        $stmt->bindParam(':ReportesRequerimientoMes', $ReportesRequerimientoMes);
        $stmt->bindParam(':ReportesArchivo', $ReportesArchivo);
        $stmt->bindParam(':ReporteObservaciones', $ReporteObservaciones);
        $stmt->bindParam(':ReportesFechaAdd', $ReportesFechaAdd);
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
        $ReportesRequerimientoMes,
        $ReporteObservaciones,
        $ReportesArchivo,
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
                        ReportesRequerimientoMes=:ReportesRequerimientoMes,
                        ReporteObservaciones=:ReporteObservaciones,
                        ReportesArchivo=:ReportesArchivo,
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
        $stmt->bindParam(':ReportesRequerimientoMes', $ReportesRequerimientoMes);
        $stmt->bindParam(':ReporteObservaciones', $ReporteObservaciones);
        $stmt->bindParam(':ReportesArchivo', $ReportesArchivo);
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
        $select = $conn->prepare("SELECT * FROM detallereportes det
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

    public function SearchReporteFechaByUsuario($conn, $idUsuario, $fecha)
    {
        $select = $conn->prepare("SELECT * from  detallereportes det
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


    public function SearchReporteDiaAnterior($conn, $idUsuario,$idReporte, $fecha)
    {
        $select = $conn->prepare("SELECT * from  detallereportes det
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

    public function SearchReporteMes($conn, $idUsuario ,$idReporte)
    {
        $select = $conn->prepare("SELECT 
        bio.BiologicosCod,bio.BiologicosNom,bio.BiologicosUnidad,
        det.ReportesStockAnterior  'StockAnterior',
        sum(det.ReportesIngresos) as 'Ingreso',
        sum(det.ReportesIngresosExtra)as 'IngresoExtra',
        (sum(det.ReportesIngresos)+sum(det.ReportesIngresosExtra)+det.ReportesStockAnterior) as 'sumatotalingreso',
        sum(det.ReportesFrascosAbiertos) as 'Fco',
        sum(det.ReportesDosis) as 'Dosis',
        sum(det.ReportesDevolucion) as 'Devolucion',
        (sum(det.ReportesFrascosAbiertos)+sum(det.ReportesDevolucion)) as 'sumatotalsalida',
        (sum(det.ReportesIngresos)+sum(det.ReportesIngresosExtra)+det.ReportesStockAnterior)-(sum(det.ReportesFrascosAbiertos)+sum(det.ReportesDevolucion)) as 'StockDisponible',
        sum(det.ReportesRequerimientoMes) as 'Requerimientos'
        from detallereportes det 
        inner join reporte re ON det.Reporte_idReporte = re.idReporte
        inner join usuariobiologico usu on det.UsuarioBiologico_idUsuarioBiologico=usu.idUsuarioBiologico 
        inner join biologicos bio on usu.Biologicos_idBiologicos=bio.idBiologicos
        where usu.Usuarios_idUsuarios=:idUsuario and re.idReporte=:idReporte group by bio.BiologicosCod");
        $select->bindParam(':idUsuario', $idUsuario);
        $select->bindParam(':idReporte', $idReporte);
        $select->execute();
        $this->vistadetallReporte = $select->fetchALL(PDO::FETCH_ASSOC);
    }
}
