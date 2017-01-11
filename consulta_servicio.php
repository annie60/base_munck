<?php
include_once '_includes/db_connect.php';

?>
<html>
    <link rel="stylesheet" href="../css/munck.css" type="text/css">
    <body>
        <div class="left">

        <h3>Servicios diarios facturados</h3>
        
        <table style="border:1px solid black;">
            
            <tr >
                <th>Fecha de facturacion</th>
                <th>Codigo de servicio</th>
                <th>Descripcion</th>
                <th>Total de piezas</th>
            </tr>
        <?php
        global $mysqli;
        $stmtLook=$mysqli->prepare("SELECT servicio_codigo,servicio_descripcion,
        SUM(FR.servicio_cantidad),DATE_FORMAT(factura_fecha,'%d/%m/%Y')
        FROM Servicios INNER JOIN Factura_por_servicio FR ON servicio_codigo=FR.servicio_fkey
        INNER JOIN Facturas ON FR.factura_fkey = factura_pkey
        GROUP BY servicio_codigo,servicio_descripcion,servicio_precio_unitario,DATE_FORMAT(factura_fecha,'%d/%m/%Y') 
        ORDER BY factura_fecha");
        echo $mysqli->error;
        $stmtLook->bind_result($codigo,$descripcion,$precio,$fecha);
        $stmtLook->execute();
        while($stmtLook->fetch()):
        ?>
            <tr>
            <td><?=$fecha?></td>
            <td>
            <?=$codigo?></td>
            <td>
            <?=$descripcion?></td>
            <td>
            <?=$precio?></td>
            </tr> 
        <?php
        endwhile;
        ?>
        </table>
        
        
    </div>

</body>
</html>