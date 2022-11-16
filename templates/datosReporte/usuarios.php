<?php
    require '../../conections/basededatos.php';
    require '../../entity/ListaCategoria.php';

    $categoria = new ListaCategoria($conn);

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/styles.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
    <title>Document</title>
</head>
<body>
<table >
        <thead>
            <tr class="fil_1">
                <th scope="rowgroup" rowspan="3" >CODIGO</th>
                <th class ="inmovil" scope="rowgroup" rowspan="3">DESCRIPCION</th>
                <th scope="rowgroup" rowspan="3" >UNIDAD DE MEDIDA</th>
                <th scope="colgroup" colspan="4" >INGRESO</th>

                <th scope="colgroup" colspan="4" >SALIDAS</th>

                <th scope="colgroup" colspan="3" >DISPONIBLE</th>

                <th scope="rowgroup" rowspan="3" >Requerimiento mes</th>
                <th scope="rowgroup" rowspan="3" >Observaciones</th>
            </tr>
            <tr class="fil_2">
                <th scope="rowgroup" rowspan="2" >Saldo del mes anterior (frascos)</th>
                <th scope="rowgroup" rowspan="2" >Ingresos (frascos)</th>
                <th scope="rowgroup" rowspan="2" >Ingresos adicionales (frascos)</th>
                <th scope="rowgroup" rowspan="2" >Total (Saldo + Ingreso) (frascos)</th>

                <th scope="colgroup" colspan="2" >INTERVENCION SANITARIA</th>
                
                <th style="width:8%" class="col_2">OTRAS SALIDAS</th>
                
                <th scope="rowgroup" rowspan="2" >Total salidas (frascos) (f) d + er</th>

                <th scope="rowgroup" rowspan="2" >Saldo final disponible (frascos) (g)  c - f</th>
                <th scope="rowgroup" rowspan="2" >Fecha de expiracion mas proxima</th>
                <th scope="rowgroup" rowspan="2" >Lote</th>
            </tr>
            <tr class="fil_3">
                <th >FCO (d)</th>
                <th >Dosis</th>
                <th >TRANSFE./DEVOLUCION frascos (e)</th>
            </tr>
        </thead>
        <tbody>

        <?php for($i=0;$i<4;$i++){?>
            <tr>
                <td class="a1">
                    <?php echo $categoria->getId($i) ?>
                </td>
                <td class="a1">
                    <?php echo $categoria->getRis($i) ?>
                </td>
             
              
                
            </tr>
            <?php } ?>

            
        </tbody>
</table>
    
</body>
</html>