<?php
include_once '_includes/db_connect.php';

?>
<html>
    <link rel="stylesheet" href="../css/munck.css" type="text/css">
    <body>
        <div class="left">

        <h3>Ventas por cliente</h3>
        <table style="border:1px solid black;">
            
            <tr >
                <th>Cliente</th>
                <th>Total de servicios</th>
                <th>Total de refacciones</th>
                <th>Total ingreso</th>
            </tr>
        <?php
        global $mysqli;
        $stmtLook=$mysqli->prepare("SELECT cliente_nombre,IFNULL(SUM(FS.servicio_cantidad),0),FORMAT(SUM(F.factura_total),2),
        ifNULL(SUM(FR.refaccion_cantidad),0),DATE_FORMAT(F.factura_fecha,'%Y-%m'),cliente_fkey
        FROM Factura_por_refaccion FR
        RIGHT JOIN Facturas F ON FR.factura_fkey = F.factura_pkey
       	LEFT JOIN Factura_por_servicio FS ON F.factura_pkey=FS.factura_fkey
        INNER JOIN Clientes ON cliente_pkey = F.cliente_fkey
        GROUP BY F.cliente_fkey
        ORDER BY F.factura_fecha");

        $stmtLook->bind_result($cliente,$servicio_cantidad,$total,$refaccion_cantidad,$fecha,$numero);
        $stmtLook->execute();
        while($stmtLook->fetch()):
        ?>
            <tr >   
            <td><?=$cliente?></td>
            <td><?=$servicio_cantidad?></td>
            <td>
            <a href="ver_refaccion.php?fecha=<?=$fecha?>&cliente=<?=$numero?>"><?=$refaccion_cantidad?></a></td>
            <td>$
            <?=$total?></td>
            </tr> 
        <?php
        endwhile;
        ?>
        </table>
        
        
    </div>

</body>
</html>