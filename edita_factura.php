<?php
$tabla="Facturas";
$nombreCampo="factura";
$relacion="Factura";
include_once 'consulta.inc.php';
include_once 'update.inc.php';

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
                <div class="left"><label>No. de factura</label>
                <input type="text" name="numero_of" value="<?=$valorNumero ?>"/></div>
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
        if($indicebasicos==0):?>
            <p class="error">No hay facturas que mostrar.</p>
        <?php else:
        for($indiceFactura=0;$indiceFactura<$indicebasicos;$indiceFactura++):
        ?>
        <form method="post" action="edita_factura.php">
        <div class="left" style="border: 1px solid black;">
            <div class="center">
                <h2>Datos de la factura</h2>
            </div>
            <div class="left">
            <h3>Datos basicos</h3>    
            <label>No. factura:</label><input type="number" value="<?=$basicos[$indiceFactura][10]?>"/>
            <label>Fecha de la factura:</label><input type="text" value="<?=$basicos[$indiceFactura][2]?>"/>
            <label>Total de la factura:</label><input type="text" value="$<?=$basicos[$indiceFactura][1]?>"/><br>
            <img src="/css/img/save.png" height="20" width="20">
                    <span style="vertical-align:top;">
                            <input type="submit" class="button-small" value="Guardar cambios" name='submit'/>
                    </span>
            </img>
            </form>
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
                    FROM Refacciones INNER JOIN ".$relacion."_por_refaccion ON refaccion_codigo=refaccion_fkey WHERE ".$nombreCampo."_fkey = ?");
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
                    endwhile;?>
            </div>
            <div class="left">
                <h4>Servicios</h4>
                <?php
                    $stmtServicio = $mysqli->prepare("SELECT servicio_codigo,servicio_descripcion,servicio_precio_unitario,servicio_cantidad
                    FROM Servicios INNER JOIN ".$relacion."_por_servicio ON servicio_codigo=servicio_fkey WHERE ".$nombreCampo."_fkey = ?");
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
                
                ?>
            </div>
            </div>
            <div class="left">
            <h3>Datos adicionales</h3>    
        
            <p><b>Notas:</b> <?=$basicos[$indiceFactura][9]?></p>
            </div>
            
                    <span style="vertical-align:top;">
                            <input type="submit" class="button-small" value="Eliminar factura" name='submit'/>
                    </span>
            
        </div>
        <?php endfor;
        endif;
        ?>

    </body>
</html>