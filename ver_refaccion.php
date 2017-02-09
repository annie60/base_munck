<?php
include_once '_includes/db_connect.php';
$condicion="";
$valor3="";
$valor4="";

if( !empty($_GET['cliente'])){
            $valor3=$_GET['cliente'];
            if(empty($condicion)){
                $condicion.= " WHERE cliente_fkey= ".$valor3."";
            }else{
                $condicion.= " AND cliente_fkey = ".$valor3."";
            }
}
if( !empty($_GET['fecha'])){
            $valor4=$_GET['fecha'];
            if(empty($condicion)){
                $condicion.= " WHERE factura_fecha LIKE '".$valor4."%'";
            }else{
                $condicion.= " AND factura_fecha LIKE '".$valor4."%'";
            }
}
?>
<html>
    <link rel="stylesheet" href="../css/munck.css" type="text/css">
    <script type="text/javascript" src="funciones.js"></script>
    <body>

        <div class="left">
        <div class="left">
            <input type="button" class="button" value="Atras" onclick="goBack()"/>
        </div>
        <h3>Refacciones facturadas</h3>
        <table style="border:1px solid black;">
            
            <tr >
                <th>Fecha de facturacion</th>
                <th>No. factura</th>
                <th>Codigo de refaccion</th>
                <th>No. Material</th>
                <th>Nombre</th>
                <th>Total de piezas</th>
            </tr>
        <?php
        global $mysqli;
        $stmtLook=$mysqli->prepare("SELECT refaccion_codigo,refaccion_no_material,refaccion_nombre,
        SUM(FR.refaccion_cantidad),factura_fecha_facturacion,factura_numero
        FROM Refacciones INNER JOIN Factura_por_refaccion FR ON refaccion_codigo=FR.refaccion_fkey
        INNER JOIN Facturas ON FR.factura_fkey = factura_pkey".$condicion." 
        GROUP BY refaccion_codigo,refaccion_no_material,refaccion_nombre,refaccion_precio_unitario
        ORDER BY factura_fecha");

        $stmtLook->bind_result($codigo,$material,$descripcion,$precio,$fecha,$numero_factura);
        $stmtLook->execute();
        while($stmtLook->fetch()):
        ?>
            <tr >   
            <td><?=$fecha?></td>
            <td><?=$numero_factura?></td>
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