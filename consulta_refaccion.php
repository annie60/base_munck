<?php
include_once '_includes/db_connect.php';

?>
<html>
    <link rel="stylesheet" href="../css/munck.css" type="text/css">
    <body>
        <div class="center">

        <h3>Refacciones facturadas</h3>
        <table style="border:1px solid black;">
            
            <tr >
                <th>Fecha de facturacion</th>
                <th>Codigo de refaccion</th>
                <th>No. Material</th>
                <th>Nombre</th>
                <th>Total de piezas</th>
            </tr>
        <?php
        global $mysqli;
        $stmtLook=$mysqli->prepare("SELECT refaccion_codigo,refaccion_no_material,refaccion_nombre,
        SUM(FR.refaccion_cantidad),DATE_FORMAT(factura_fecha,'%d/%m/%Y')
        FROM Refacciones INNER JOIN Factura_por_refaccion FR ON refaccion_codigo=FR.refaccion_fkey
        INNER JOIN Facturas ON FR.factura_fkey = factura_pkey
        GROUP BY refaccion_codigo,refaccion_no_material,refaccion_nombre,refaccion_precio_unitario,DATE_FORMAT(factura_fecha,'%d/%m/%Y')
        ORDER BY factura_fecha");
        echo $mysqli->error;
        $stmtLook->bind_result($codigo,$material,$descripcion,$precio,$fecha);
        $stmtLook->execute();
        while($stmtLook->fetch()):
        ?>
            <tr >   
            <td><?=$fecha?></td>
            <td>
            <?=$codigo?></td>
            <td><?=$material?></td>
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