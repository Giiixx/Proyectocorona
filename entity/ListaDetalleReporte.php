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

        public function VistaDetalleReporte($conn,$idusuario){
            $select = $conn->prepare("SELECT 
            bio.BiologicosCod,
            bio.BiologicosNom,
            bio.BiologicosUnidad,
            det.idReportes,
            usu.UsuarioBiologicoStock,
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
                WHERE usu.Usuarios_idUsuarios=:idusuario ");
            $select->bindParam(':idusuario',$idusuario);
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
                                        $ReportesRequerimientoMes,
                                        $ReporteObservaciones, 
                                        $ReportesArchivo,
                                        $ReportesFechaAdd,
                                        $idUsuarioBiologico){
            $sql = "INSERT INTO detallereportes 
                        (ReportesIngresos, 
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
                        (:ReportesIngresos,     
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