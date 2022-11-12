<?php
    class ListaDetalleReporte{
        public $detalleReporte;

        public function __construct($conn){
            $select = $conn->prepare("SELECT * FROM detallereportes");
            $select->execute();
            $this->detalleReporte = $select->fetchAll(PDO::FETCH_ASSOC);
        }
        public function init($conn){
            $select = $conn->prepare("SELECT * FROM detallereportes");
            $select->execute();
            $this->detalleReporte = $select->fetchALL(PDO::FETCH_ASSOC);
        }
        /*======================*/
        public function getId($position){
            return $this->detalleReporte[$position]['idReportes'];
        }
        public function getIngresos($position){
            return $this->detalleReporte[$position]['ReportesIngresos'];
        }
        public function getIngresosExtra($position){
            return $this->detalleReporte[$position]['ReportesIngresosExtra'];
        }
        public function getFrascosAbiertos($position){
            return $this->detalleReporte[$position]['FrascosAbiertos'];
        }

        public function IngresarDetalleReporte($conn,
                                        $ReportesIngresos,
                                        $ReportesIngresosExtra,
                                        $ReportesFrascosAbiertos,
                                        $ReportesDosis,
                                        $ReportesDevolucion,
                                        $ReportesExpiracionFecha,
                                        $ReportesLote,
                                        $ReportesRequerimientoMes,
                                        $ReportesArchivo,
                                        $ReporteObservaciones,
                                        $ReportesFechaAdd,
                                        $Biologicos_idBiologicos,
                                        $Usuarios_idUsuarios){
            $sql = "INSERT INTO detallereportes
                        (ReportesIngresos,
                        ReportesIngresosExtra,
                        ReportesFrascosAbiertos,
                        ReportesDosis,
                        ReportesDevolucion,
                        ReportesExpiracionFecha,
                        ReportesLote,
                        ReportesRequerimientoMes,
                        ReportesArchivo,
                        ReporteObservaciones,
                        ReportesFechaAdd,
                        Biologicos_idBiologicos,
                        Usuarios_idUsuarios)
                    VALUES
                        (:ReportesIngresos,
                        :ReportesIngresosExtra,
                        :ReportesFrascosAbiertos,
                        :ReportesDosis,
                        :ReportesDevolucion,
                        :ReportesExpiracionFecha,
                        :ReportesLote,
                        :ReportesRequerimientoMes,
                        :ReportesArchivo,
                        :ReporteObservaciones,
                        :ReportesFechaAdd,
                        :Biologicos_idBiologicos,
                        :Usuarios_idUsuarios)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':ReportesIngresos', $ReportesIngresos);
            $stmt->bindParam(':ReportesIngresosExtra',$ReportesIngresosExtra);
            $stmt->bindParam(':ReportesFrascosAbiertos', $ReportesFrascosAbiertos);
            $stmt->bindParam(':ReportesDosis',$ReportesDosis);
            $stmt->bindParam(':ReportesDevolucion', $ReportesDevolucion);
            $stmt->bindParam(':ReportesExpiracionFecha',$ReportesExpiracionFecha);
            $stmt->bindParam(':ReportesLote', $ReportesLote);
            $stmt->bindParam(':ReportesRequerimientoMes',$ReportesRequerimientoMes);
            $stmt->bindParam(':ReportesArchivo', $ReportesArchivo);
            $stmt->bindParam(':ReporteObservaciones',$ReporteObservaciones);
            $stmt->bindParam(':ReportesFechaAdd', $ReportesFechaAdd);
            $stmt->bindParam(':Biologicos_idBiologicos',$Biologicos_idBiologicos);
            $stmt->bindParam(':Usuarios_idUsuarios',$Usuarios_idUsuarios);

            return $stmt->execute() ? TRUE : FALSE;
        }
    }
?>