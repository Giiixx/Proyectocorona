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
        

        
        

        /*public function updateRequerimiento($conn,
                                        $saldo_anterior, 
                                        $ingresos,
                                        $ingresos_extra, 
                                        $total_1, 
                                        $fco, 
                                        $dosis, 
                                        $devolucion, 
                                        $total_2, 
                                        $saldo_final, 
                                        $fecha_expiracion, 
                                        $lote, 
                                        $requerimientos, 
                                        $observaciones,
                                        $requerimiento_id){
            $sql = "UPDATE requerimientos SET 
                        saldo_anterior = :saldo_anterior, 
                        ingresos = :ingresos,
                        ingresos_extra = :ingresos_extra, 
                        total_1 = :total_1, 
                        fco = :fco, 
                        dosis = :dosis, 
                        devolucion = :devolucion, 
                        total_2 = :total_2, 
                        saldo_final = :saldo_final, 
                        fecha_expiracion = :fecha_expiracion, 
                        lote = :lote, 
                        requerimientos = :requerimientos, 
                        observaciones = :observaciones
                        WHERE requerimientos.id = :requerimientos_id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':saldo_anterior', $saldo_anterior);
            $stmt->bindParam(':ingresos', $ingresos);
            $stmt->bindParam(':ingresos_extra', $ingresos_extra);
            $stmt->bindParam(':total_1', $total_1);
            $stmt->bindParam(':fco', $fco);
            $stmt->bindParam(':dosis', $dosis);
            $stmt->bindParam(':devolucion', $devolucion);
            $stmt->bindParam(':total_2', $total_2);
            $stmt->bindParam(':saldo_final', $saldo_final);
            $stmt->bindParam(':fecha_expiracion', $fecha_expiracion);
            $stmt->bindParam(':lote', $lote);
            $stmt->bindParam(':requerimientos', $requerimientos);
            $stmt->bindParam(':observaciones', $observaciones);
            $stmt->bindParam(':requerimientos_id', $requerimiento_id);

            return $stmt->execute() ? TRUE : FALSE;
        }
        
        public function deleteRequerimiento($conn,$requerimiento_id){
            $sql="DELETE FROM requerimientos WHERE requerimientos.id=:requerimientos_id";

            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':requerimientos_id', $requerimiento_id);
            return $stmt->execute() ? TRUE : FALSE;
        }
        */
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