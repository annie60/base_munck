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
                <th>Codigo de refaccion</th>
                <th>No. Material</th>
                <th>Nombre</th>
                <th>Total de piezas</th>
            </tr>
        <?php
        global $mysqli;
        $stmtLook=$mysqli->prepare("SELECT refaccion_codigo,refaccion_no_material,refaccion_nombre,
        SUM(FR.refaccion_cantidad)
        FROM Refacciones INNER JOIN Factura_por_refaccion FR ON refaccion_codigo=FR.refaccion_fkey
        GROUP BY refaccion_codigo,refaccion_no_material,refaccion_nombre,refaccion_precio_unitario ORDER BY refaccion_codigo");
        echo $mysqli->error;
        $stmtLook->bind_result($codigo,$material,$descripcion,$precio);
        $stmtLook->execute();
        while($stmtLook->fetch()):
        ?>
            <tr >   
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