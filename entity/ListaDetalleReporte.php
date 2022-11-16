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

        public function VistaDetalleReporte($conn){
            $select = $conn->prepare("SELECT bio.BiologicosCod , bio.BiologicosNom ,bio.BiologicosUnidad  ,det.idReportes,det.ReportesIngresos ,det.ReportesIngresosExtra ,det.ReportesFrascosAbiertos ,det.ReportesDosis,det.ReportesDevolucion ,det.ReportesExpiracionFecha ,det.ReportesLote ,det.ReportesRequerimientoMes ,det.ReporteObservaciones,det.ReportesArchivo  from detallereportes det inner join biologicos bio on det.Biologicos_idBiologicos=bio.idBiologicos inner join categoria cat on bio.Categoria_idCategoria=cat.idCategoria");
            
            $select->execute();
            $this->vistadetallReporte = $select->fetchALL(PDO::FETCH_ASSOC);
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
                                        $ReporteObservaciones, 
                                        $ReportesArchivo,
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
                        ReporteObservaciones, 
                        ReportesArchivo,
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
                        :ReporteObservaciones, 
                        :ReportesArchivo,
                        :ReportesFechaAdd,
                        :Biologicos_idBiologicos, 
                        :Usuarios_idUsuarios)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':ReportesIngresos', $ReportesIngresos);
            $stmt->bindParam(':ReportesIngresosExtra', $ReportesIngresosExtra);
            $stmt->bindParam(':ReportesFrascosAbiertos', $ReportesFrascosAbiertos);
            $stmt->bindParam(':ReportesDosis', $ReportesDosis);
            $stmt->bindParam(':ReportesDevolucion', $ReportesDevolucion);
            $stmt->bindParam(':ReportesExpiracionFecha', $ReportesExpiracionFecha);
            $stmt->bindParam(':ReportesLote', $ReportesLote);
            $stmt->bindParam(':ReportesRequerimientoMes', $ReportesRequerimientoMes);
            $stmt->bindParam(':ReportesArchivo', $ReportesArchivo);
            $stmt->bindParam(':ReporteObservaciones', $ReporteObservaciones);
            $stmt->bindParam(':ReportesFechaAdd', $ReportesFechaAdd);
            $stmt->bindParam(':Biologicos_idBiologicos', $Biologicos_idBiologicos);
            $stmt->bindParam(':Usuarios_idUsuarios', $Usuarios_idUsuarios); 
            

            return $stmt->execute() ? TRUE : FALSE;
        }
        

        
        

        public function UpdateDetalleReporte($conn,
                                        $ReportesIngresos, 
                                        $ReportesIngresosExtra, 
                                        $ReportesFrascosAbiertos, 
                                        $ReportesDosis,
                                        $ReportesDevolucion, 
                                        $ReportesExpiracionFecha, 
                                        $ReportesLote, 
                                        $ReportesRequerimientoMes,
                                        $ReporteObservaciones, 
                                        $ReportesArchivo,
                                        $Biologicos_idBiologicos, 
                                        $idReportes){
            $sql = "UPDATE detallereportes SET 
                        Biologicos_idBiologicos=:Biologicos_idBiologicos,
                        ReportesIngresos=:ReportesIngresos,
                        ReportesIngresosExtra=:ReportesIngresosExtra,
                        ReportesFrascosAbiertos=:ReportesFrascosAbiertos,
                        ReportesDosis=:ReportesDosis,
                        ReportesDevolucion=:ReportesDevolucion,
                        ReportesExpiracionFecha=:ReportesExpiracionFecha,
                        ReportesLote=:ReportesLote,
                        ReportesRequerimientoMes=:ReportesRequerimientoMes,
                        ReporteObservaciones=:ReporteObservaciones,
                        ReportesArchivo=:ReportesArchivo
                        WHERE idReportes=:idReportes";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':ReportesIngresos', $ReportesIngresos);
            $stmt->bindParam(':ReportesIngresosExtra', $ReportesIngresosExtra);
            $stmt->bindParam(':ReportesFrascosAbiertos', $ReportesFrascosAbiertos);
            $stmt->bindParam(':ReportesDosis', $ReportesDosis);
            $stmt->bindParam(':ReportesDevolucion', $ReportesDevolucion);
            $stmt->bindParam(':ReportesExpiracionFecha', $ReportesExpiracionFecha);
            $stmt->bindParam(':ReportesLote', $ReportesLote);
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
        /*

        public function init_selectById($conexion, $user_id){
            $select = $conexion->prepare("SELECT * FROM requerimientos WHERE establecimiento_id=:establecimiento_id");
            $select->bindParam(':establecimiento_id', $user_id);
            $select->execute();
            $this->requerimientos = $select->fetchALL(PDO::FETCH_ASSOC);
        }

        public function init_selectByIdAndReg($conexion, $user_id, $registro_id){
            $select = $conexion->prepare(
            "SELECT DISTINCT req.id, req.saldo_anterior, 
                    req.ingresos, req.ingresos_extra, req.total_1, req.fco, req.dosis, req.devolucion, req.total_2, req.saldo_final,
                    req.fecha_expiracion, req.lote, req.requerimientos, req.observaciones,
                    pro.codigo, pro.nombre, pro.unidad, pro.descripcion, pro.proporcion, car.color, car.others
            FROM requerimientos req 
            INNER JOIN productos pro 
            ON req.producto_id = pro.id
            INNER JOIN cards car
            ON req.producto_id = car.producto_id
            INNER JOIN registros reg
            ON req.registro_id = reg.id
            WHERE reg.numeracion = :registro_id
            AND req.establecimiento_id = :establecimiento_id;   
            ");
            $select->bindParam(':establecimiento_id', $user_id);
            $select->bindParam(':registro_id', $registro_id);
            $select->execute();
            $this->requerimientos = $select->fetchALL(PDO::FETCH_ASSOC);
        }

        public function init_selectByGlobalId($conexion, $registro_id){
            $select = $conexion->prepare(
            "SELECT DISTINCT req.id, req.saldo_anterior,
                    req.ingresos, req.ingresos_extra, req.total_1, req.fco, req.dosis, req.devolucion, req.total_2, req.saldo_final,
                    req.fecha_expiracion, req.lote, req.requerimientos, req.observaciones,
                    pro.codigo, pro.nombre, pro.unidad, pro.descripcion, pro.proporcion, car.color, car.others
            FROM requerimientos req 
            INNER JOIN productos pro 
            ON req.producto_id = pro.id
            INNER JOIN cards car
            ON req.producto_id = car.producto_id
            INNER JOIN registros reg
            ON req.registro_id = reg.id
            WHERE req.registro_id = :registro_id;
            ");
            //$select->bindParam(':establecimiento_id', $user_id);
            $select->bindParam(':registro_id', $registro_id);
            $select->execute();
            $this->requerimientos = $select->fetchALL(PDO::FETCH_ASSOC);
        }

        public function findIdByCod($conexion, $codigo){
            $select = $conexion->prepare(
            "SELECT id FROM productos wHERE codigo=:codigo;
            ");
            $select->bindParam(':codigo', $codigo);
            $select->execute();
            $this->requerimientos = $select->fetchALL(PDO::FETCH_ASSOC);
            return $select->execute() ? TRUE : FALSE;
        }
        */
    }
?>