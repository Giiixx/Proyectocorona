<?php
    class ListaDetalleReporte{
        public $detalleReporte;
        public $vistadetallReporte;
        
        public function __construct($conn) {
            $select = $conn->prepare("SELECT * FROM detallereportes");
            $select->execute();
            $this->detalleReporte = $select->fetchALL(PDO::FETCH_ASSOC);
        }

        public function init($conn){
            $select = $conn->prepare("SELECT * FROM detallereportes");
            $select->execute();
            $this->detalleReporte = $select->fetchALL(PDO::FETCH_ASSOC);
        }

        /*public function getCantidad(){
            $points = 0;
            foreach ($this->requerimientos as $valor=>$value){
                $points++;
            }
            return $points;
        }*/

        public function VistaDetalleReporte($conn,$idusuario,$fecha){
            $select = $conn->prepare("SELECT 
            bio.BiologicosCod,
            bio.BiologicosNom,
            bio.BiologicosUnidad,
            det.idReportes,
            det.ReportesStockAnterior,
            det.ReportesIngresos,
            det.ReportesIngresosExtra,
            det.ReportesFrascosAbiertos,
            det.ReportesDosis,
            det.ReportesDevolucion,
            det.ReportesExpiracionBiologico,
            lot.LoteBiologicoDescripcion,
            det.ReportesRequerimientoMes,
            det.ReporteObservaciones,
            det.ReportesArchivo
        FROM
            detallereportes det
                INNER JOIN
            usuariobiologico usu ON det.UsuarioBiologico_idUsuarioBiologico = usu.idUsuarioBiologico
                INNER JOIN
            biologicos bio ON usu.Biologicos_idBiologicos = bio.idBiologicos
                INNER JOIN
            lotebiologico lot ON usu.LoteBiologico_idLoteBiologico = lot.idLoteBiologico 
                WHERE usu.Usuarios_idUsuarios=:idusuario and date(ReportesFechaAdd)=:fecha order by idReportes ");
            $select->bindParam(':idusuario',$idusuario);
            $select->bindParam(':fecha',$fecha);
            $select->execute();
            $this->vistadetallReporte = $select->fetchALL(PDO::FETCH_ASSOC);
        }

        public function VistaDetalleReporteByBiologico($conn,$idusuario,$fecha,$idBiologico,$idLote){
            $select = $conn->prepare("SELECT * FROM detallereportes det
                INNER JOIN
            usuariobiologico usu ON det.UsuarioBiologico_idUsuarioBiologico = usu.idUsuarioBiologico
                INNER JOIN
            biologicos bio ON usu.Biologicos_idBiologicos = bio.idBiologicos
                INNER JOIN
            lotebiologico lot ON usu.LoteBiologico_idLoteBiologico = lot.idLoteBiologico 
                WHERE usu.Usuarios_idUsuarios=:idusuario and usu.Biologicos_idBiologicos=:idBiologico and usu.LoteBiologico_idLoteBiologico=:idLote and date(ReportesFechaAdd)=:fecha order by idReportes ");
            $select->bindParam(':idusuario',$idusuario);
            $select->bindParam(':idBiologico',$idBiologico);
            $select->bindParam(':idLote',$idLote);  
            $select->bindParam(':fecha',$fecha);
            $select->execute();
            $this->vistadetallReporte = $select->fetchALL(PDO::FETCH_ASSOC);
        }
        
        public function IngresarDetalleReporte($conn,
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
                                        $idUsuarioBiologico){
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
                        UsuarioBiologico_idUsuarioBiologico) 
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
                        :idUsuarioBiologico)";
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

            return $stmt->execute() ? TRUE : FALSE;
        }
        

        
        

        public function UpdateDetalleReporte($conn,
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
                                        $Biologicos_idBiologicos, 
                                        $idReportes){
            $sql = "UPDATE detallereportes SET 
                        Biologicos_idBiologicos=:Biologicos_idBiologicos,
                        ReportesStockAnterior=:ReportesStockAnterior,
                        ReportesIngresos=:ReportesIngresos,
                        ReportesIngresosExtra=:ReportesIngresosExtra,
                        ReportesFrascosAbiertos=:ReportesFrascosAbiertos,
                        ReportesDosis=:ReportesDosis,
                        ReportesDevolucion=:ReportesDevolucion,
                        ReportesExpiracionFecha=:ReportesExpiracionFecha,
                        ReportesRequerimientoMes=:ReportesRequerimientoMes,
                        ReporteObservaciones=:ReporteObservaciones,
                        ReportesArchivo=:ReportesArchivo
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
            $stmt->bindParam(':Biologicos_idBiologicos', $Biologicos_idBiologicos);
            $stmt->bindParam(':idReportes', $idReportes);

            return $stmt->execute() ? TRUE : FALSE;
        }
        
        public function DeleteDetallleReporte($conn,$idReportes){
            $sql="DELETE FROM detallereportes WHERE idReportes=:idReportes";

            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':idReportes', $idReportes);
            return $stmt->execute() ? TRUE : FALSE;
        }

        public function SearchDetalleReporteById($conn,$idReportes){
            $select=$conn->prepare("SELECT * FROM detallereportes det
            INNER JOIN
            usuariobiologico usu ON det.UsuarioBiologico_idUsuarioBiologico = usu.idUsuarioBiologico
            INNER JOIN
            biologicos bio ON usu.Biologicos_idBiologicos = bio.idBiologicos
            INNER JOIN
            lotebiologico lot ON usu.LoteBiologico_idLoteBiologico = lot.idLoteBiologico WHERE idReportes=:idReportes");
            $select->bindParam(':idReportes', $idReportes);
            $select->execute();
            $this->detalleReporte = $select->fetch(PDO::FETCH_ASSOC);
        }

        public function UpdateStockAnteriorById($conn,$idReportes,$stockAnterior){
            $select=$conn->prepare("UPDATE detallereportes SET ReportesStockAnterior=:stockAnterior where idReportes=:idReportes");
            $select->bindParam(':idReportes',$idReportes);
            $select->bindParam(':stockAnterior',$stockAnterior);
            $select->execute();
            $this->detalleReporte = $select->fetch(PDO::FETCH_ASSOC);
        }
    }
?>