<?php
include_once 'consulta.inc.php';
?>

<!DOCTYPE html>
<html>
    <link rel="stylesheet" href="css/munck.css" type="text/css" />
    <script type="text/javascript" src="funciones.js"></script>
    <body style="width=100%;">
        <span class="close" id='filtro' onclick="mostrar('busqueda')">Filtrar v</span>
        <div id="busqueda" class="center" style="display:none;">
            <h3>Buscar por</h3>
            <form action="consulta_factura.php" method="post">
                <div class="left"><label>No. de refacci&oacute;n</label>
                <input type="text" name="refaccion" value="<?=$valorRefaccion ?>"/></div>
                <div class="left"><label>Codigo de servicio</label>
                <input type="text" name="servicio" value="<?=$valorServicio ?>"/></div>
                <div class="left"><label>Nombre de cliente</label><input type="text" name="cliente" value="<?=$valorCliente ?>"/></div>
                <div class="left"><label>Fecha:</label><input type="text" maxlength="11" placeholder="dd/mm/aaaa" name="fecha" value="<?=$valorFecha ?>"/></div>
                <input type="submit" value="Buscar" class="button-small"/>
            </form>
        </div>
        <?php
        for($indiceFactura=0;$indiceFactura<$indicebasicos;$indiceFactura++):
        ?>
        <div class="left" style="border: 1px solid black;">
            <div class="center">
                <h2>Datos de la factura</h2>
            </div>
            <div class="left">
            <h3>Datos basicos</h3>    
        
            <p><b>Fecha de la factura:</b> <?=$basicos[$indiceFactura][2]?></p>
            <p><b>Total de la factura:</b> $<?=$basicos[$indiceFactura][1]?></p>
            </div>
            <div class="left">
                <h3>Datos del cliente</h3>

                        <p><b>Nombre de cliente:</b> <?=$basicos[$indiceFactura][3]?><br>
                        <b>Razon social de cliente:</b> <?=$basicos[$indiceFactura][4]?><br>
                        <b>Domicilio:</b><a href="http://maps.google.com/?q=<?=$basicos[$indiceFactura][5]?>" target="_blank"><?=$basicos[$indiceFactura][5]?></a><br>
                        <b>Contacto:</b><a href="mailto:'<?=$basicos[$indiceFactura][8]?>'" target="_blank"> <?=$basicos[$indiceFactura][6]?></a><br>
                        <b>Telefono:</b> <?=$basicos[$indiceFactura][7]?></p>
            </div>
            <div class="left">
            <h3>Datos de la venta</h3>
           <div class="left">
                
                <h4>Refacciones</h4>
                <?php
                    $stmtRefaccion = $mysqli->prepare("SELECT refaccion_codigo,refaccion_no_material,refaccion_nombre,refaccion_precio_unitario,refaccion_cantidad
                    FROM Refacciones INNER JOIN Factura_por_refaccion ON refaccion_codigo=refaccion_fkey WHERE factura_fkey = ?");
                    $stmtRefaccion->bind_param('i',$basicos[$indiceFactura][0]);
                    $stmtRefaccion->execute();
                    $stmtRefaccion->bind_result($codigo,$no_material,$nombreRefaccion,$precio,$cantidad);
                    while($stmtRefaccion->fetch()):?>
                    <div class="left">
                        <p><b>Codigo:</b> <?=$codigo?><br>
                        <b>No. material:</b> <?=$no_material?><br>
                        <b>Nombre:</b> <?=$nombreRefaccion?><br>
                        <b>Precio unitario:</b> $<?=$precio?><br>
                        <b>Cantidad:</b> <?=$cantidad?></p><br>
                    </div>
                <?php
                    endwhile;
                    $stmtRefaccion->close;?>
            </div>
            <div class="left">
                <h4>Servicios</h4>
                <?php
                    $stmtServicio = $mysqli->prepare("SELECT servicio_codigo,servicio_descripcion,servicio_precio_unitario,servicio_cantidad
                    FROM Servicios INNER JOIN Factura_por_servicio ON servicio_codigo=servicio_fkey WHERE factura_fkey = ?");
                    echo $mysqli->error;
                    $stmtServicio->bind_param('i',$basicos[$indiceFactura][0]);
                    $stmtServicio->execute();
                    $stmtServicio->bind_result($codigo,$nombreServicio,$precio,$cantidad);
                    while($stmtServicio->fetch()):?>
                    <div class="left">
                        <p><b>Codigo:</b> <?=$codigo?><br>
                        <b>Nombre:</b> <?=$nombreServicio?><br>
                        <b>Precio unitario:</b> <?=$precio?><br>
                        <b>Cantidad:</b> <?=$cantidad?></p>
                        </div>
                <?php
                endwhile;
                $stmtServicio->close;
                ?>
                </div>
                </div>
        </div>
        <?php endfor;?>

    </body>
</html>