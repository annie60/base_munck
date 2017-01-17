<?php
include_once '_includes/db_connect.php';
$condicion="";
$valor1="";
$valor2="";
$valor3="";
$valor4="";
if( !empty($_POST['numero_refaccion'])){
            $valor1=$_POST['numero_refaccion'];
            if(empty($condicion)){
                $condicion.=" WHERE refaccion_codigo='".$valor1."'";
            }else{
                $condicion.= " AND refaccion_codigo = '".$valor1."'";
            }
}
if( !empty($_POST['no_material'])){
            $valor2=$_POST['no_material'];
            if(empty($condicion)){
                $condicion.=" WHERE refaccion_no_material = '".$valor2."'";
            }else{
                $condicion.= " AND refaccion_no_material = '".$valor2."'";
            }
}
if( !empty($_POST['nombre_refaccion'])){
            $valor3=$_POST['nombre_refaccion'];
            if(empty($condicion)){
                $condicion.= " WHERE refaccion_nombre = '".$valor3."'";
            }else{
                $condicion.= " AND refaccion_nombre = '".$valor3."'";
            }
}
if( !empty($_POST['fecha'])){
            $valor4=$_POST['fecha'];
            if(empty($condicion)){
                $condicion.= " WHERE factura_fecha_facturacion LIKE '%".$valor4."%'";
            }else{
                $condicion.= " AND factura_fecha_facturacion LIKE '%".$valor4."%'";
            }
}
?>
<html>
    <link rel="stylesheet" href="../css/munck.css" type="text/css">
    <script type="text/javascript" src="funciones.js"></script>
    <body>
        <span class="close" id='filtro' onclick="mostrar('busqueda')">Filtrar v</span>
        <div id="busqueda" class="center" style="display:none;">
            <h3>Buscar por</h3>
            <form action="consulta_refaccion.php" method="post">
                <div class="left"><label>No. de refaccion</label>
                <input type="text" name="numero_refaccion" value="<?=$valor1 ?>"/></div>
                <div class="left"><label>No. de material</label>
                <input type="text" name="no_material" value="<?=$valor2 ?>"/></div>
                <div class="left"><label>Nombre de refaccion</label>
                <input type="text" name="nombre_refaccion" value="<?=$valor3 ?>"/></div>
                <div class="left"><label>Fecha:</label>
                <input type="text" maxlength="11" placeholder="dd/mm/aaaa" name="fecha" value="<?=$valor4 ?>"/></div>
                <input type="submit" value="Buscar" class="button-small"/>
            </form>
        </div>
        <div class="left">

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
        SUM(FR.refaccion_cantidad),DATE_FORMAT(factura_fecha_facturacion,'%d/%m/%Y'),factura_numero
        FROM Refacciones INNER JOIN Factura_por_refaccion FR ON refaccion_codigo=FR.refaccion_fkey
        INNER JOIN Facturas ON FR.factura_fkey = factura_pkey".$condicion." GROUP BY refaccion_codigo,refaccion_no_material,refaccion_nombre,refaccion_precio_unitario,DATE_FORMAT(factura_fecha_facturacion,'%d/%m/%Y')
        ORDER BY factura_fecha");
        echo $mysqli->error;
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