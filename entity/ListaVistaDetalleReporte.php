<?php
    class ListaDetalleReporte{
        public $detalleReporte;
        public $vistadetallReporte;
        
        public function __construct($conn) {
            $select = $conn->prepare("SELECT bio.BiologicosCod , bio.BiologicosNom ,bio.BiologicosUnidad  ,det.ReportesIngresos ,det.ReportesIngresosExtra ,det.ReportesFrascosAbiertos ,det.ReportesDosis,det.ReportesDevolucion ,det.ReportesExpiracionFecha ,det.ReportesLote ,det.ReportesRequerimientoMes ,det.ReporteObservaciones,det.ReportesArchivo  from detallereportes det inner join biologicos bio on det.Biologicos_idBiologicos=bio.idBiologicos inner join categoria cat on bio.Categoria_idCategoria=cat.idCategoria");
            
            $select->execute();
            $this->vistadetallReporte = $select->fetchALL(PDO::FETCH_ASSOC);
        }

        public function init($conn){
            $select = $conn->prepare("SELECT bio.BiologicosCod , bio.BiologicosNom ,bio.BiologicosUnidad  ,det.idReportes,det.ReportesIngresos ,det.ReportesIngresosExtra ,det.ReportesFrascosAbiertos ,det.ReportesDosis,det.ReportesDevolucion ,det.ReportesExpiracionFecha ,det.ReportesLote ,det.ReportesRequerimientoMes ,det.ReporteObservaciones,det.ReportesArchivo  from detallereportes det inner join biologicos bio on det.Biologicos_idBiologicos=bio.idBiologicos inner join categoria cat on bio.Categoria_idCategoria=cat.idCategoria");
            
            $select->execute();
            $this->vistadetallReporte = $select->fetchALL(PDO::FETCH_ASSOC);
        }

        /*public function getCantidad(){
            $points = 0;
            foreach ($this->requerimientos as $valor=>$value){
                $points++;
            }
            return $points;
        }*/

        public function getCod($position){
            return $this->detalleReporte[$position]['BiologicosNom'];
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

        
      

      
    }
?>