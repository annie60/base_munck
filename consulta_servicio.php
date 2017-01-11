<?php
include_once '_includes/db_connect.php';

?>
<html>
    <link rel="stylesheet" href="../css/munck.css" type="text/css">
    <body>
        <div class="center">

        <h3>Servicios facturadas</h3>
        <table style="border:1px solid black;">
            
            <tr >
                <th>Codigo de servicio</th>
                <th>Descripcion</th>
                <th>Total de piezas</th>
            </tr>
        <?php
        global $mysqli;
        $stmtLook=$mysqli->prepare("SELECT servicio_codigo,servicio_descripcion,
        SUM(FR.servicio_cantidad)
        FROM Servicios INNER JOIN Factura_por_servicio FR ON servicio_codigo=FR.servicio_fkey
        GROUP BY servicio_codigo,servicio_descripcion,servicio_precio_unitario ORDER BY servicio_codigo");
        echo $mysqli->error;
        $stmtLook->bind_result($codigo,$descripcion,$precio);
        $stmtLook->execute();
        while($stmtLook->fetch()):
        ?>
            <tr >   
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