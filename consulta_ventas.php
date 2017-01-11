<?php
include_once '_includes/db_connect.php';

?>
<html>
    <link rel="stylesheet" href="../css/munck.css" type="text/css">
    <body>
        <div class="center">

        <h3>Ventas por dia</h3>
        <table style="border:1px solid black;">
            
            <tr >
                <th>Fecha de facturacion</th>
                <th>Total de servicios</th>
                <th>Total de refacciones</th>
                <th>Total ingreso</th>
            </tr>
        <?php
        global $mysqli;
        $stmtLook=$mysqli->prepare("SELECT F.factura_pkey, IFNULL(SUM(FS.servicio_cantidad),0),SUM(F.factura_total),
        ifNULL(SUM(FR.refaccion_cantidad),0),DATE_FORMAT(F.factura_fecha,'%d/%m/%Y')
        FROM Factura_por_refaccion FR
        RIGHT JOIN Facturas F ON FR.factura_fkey = F.factura_pkey
       	LEFT JOIN Factura_por_servicio FS ON F.factura_pkey=FS.factura_fkey
        GROUP BY F.factura_pkey
        ORDER BY F.factura_fecha");
        echo $mysqli->error;
        $stmtLook->bind_result($id,$servicio_cantidad,$total,$refaccion_cantidad,$fecha);
        $stmtLook->execute();
        while($stmtLook->fetch()):
        ?>
            <tr >   
            <td><?=$fecha?></td>
            <td><?=$servicio_cantidad?></td>
            <td>
            <?=$refaccion_cantidad?></td>
            <td>
            <?=$total?></td>
            </tr> 
        <?php
        endwhile;
        ?>
        </table>
        
        
    </div>

</body>
</html>