<?php
$tabla="Ordenes_compra";
$nombreCampo="orden";
$relacion="Orden";
include_once 'update.inc.php';
if (!empty($error_msg)) {
            echo $error_msg;
}elseif (!empty($correct_msg)) {
            echo $correct_msg;
}
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
            <form action="edita_orden.php" method="post">
                <div class="left"><label>No. de orden</label>
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
        <input type="hidden" id="id_agregar" value=""/>
        <?php
        if (!empty($error_msg)) {
            echo $error_msg;
        }elseif (!empty($correct_msg)) {
            echo $correct_msg;
        }
        if($indicebasicos==0):?>
            <p class="error">No hay ordenes que mostrar.</p>
        <?php else:
        for($indiceFactura=0;$indiceFactura<$indicebasicos;$indiceFactura++):
        ?>
        
        <div class="left" style="border: 1px solid black;">
            <div class="center">
                <h2>Datos de la orden</h2>
                
                
                <div class="right">
                    <form method="post" action="edita_orden.php">
                    <input type="hidden" name="id_elimina" value="<?=$basicos[$indiceFactura][0]?>"/>
                    <span style="vertical-align:top;">
                            <input type="submit" class="button-small-warn" value="Eliminar orden" name='submit'/>
                    </span>
                    </form>
                </div>
                
                
            </div>
            <form method="post" action="edita_orden.php">
            <div class="left">
            <h3>Datos basicos</h3>    
            <label>No. orden:</label><input type="number" value="<?=$basicos[$indiceFactura][10]?>" name="no_orden"/>
            <p><b>Fecha de la orden:</b><?=$basicos[$indiceFactura][2]?></p>
            <label>Total de la orden:</label><input type="text" name="granTotal"  value="<?=$basicos[$indiceFactura][1]?>"/><br>
            
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
                        <form method="post" action="edita_orden.php">
                        <label>Cantidad:</label><input type="number" value="<?=$cantidad?>" name="cantidad"/><br>
                        <input type="hidden" name="id_factura_ref" value="<?=$basicos[$indiceFactura][0]?>"/>
                        <input type="hidden" name="codigo_ref" value="<?=$codigo?>" />
                        <input type="submit" class="button-small" value="Guardar" name='submit'/>
                        </form>
                    </div>
                <?php
                    endwhile;?>
            <div id='refaccion<?=$indiceFactura?>'>
            </div>
            <input type='button' value='Agregar Refacci&oacute;n' onclick='agregarAFactura(1,<?=$indiceFactura?>)'/>
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
                        <form method="post" action="edita_orden.php">
                        <label>Cantidad:</label><input type="number" value="<?=$cantidad?>" name="cantidad"/><br>
                        <input type="hidden" name="id_factura_serv" value="<?=$basicos[$indiceFactura][0]?>"/>
                        <input type="hidden" name="codigo_serv" value="<?=$codigo?>" />
                        <input type="submit" class="button-small" value="Guardar" name='submit'/>
                        </form>
                        </div>
                <?php
                endwhile;
                
                ?>
                <div id='servicio<?=$indiceFactura?>'></div>
                <input type='button' value='Agregar Servicio' onclick='agregarAFactura(2,<?=$indiceFactura?>)'/>
            </div>
            
            
            </div>
            
            <div class="left">
            <h3>Datos adicionales</h3>    
        
            <label>Notas:</label> <textarea name="notas"><?=$basicos[$indiceFactura][9]?></textarea>
            </div>
            <div class="left">
                <input type="hidden" name="id_factura" value="<?=$basicos[$indiceFactura][0]?>"/>
                <img src="/css/img/save.png" height="20" width="20">
                    <span style="vertical-align:top;">
                            <input type="submit" class="button-small" value="Guardar cambios" name='submit'/>
                    </span>
                </img>    
            </div>
        </div>
        </form>
        <?php endfor;
        endif;
        ?>
        <div id="nuevaRefaccion" class="modal">
            <div class='modal-content'>
            <span class="close">&times;</span>
            <div class="center">
                <h3>Refacciones</h3>
                <table>
                    <thead>
                        <tr>
                            <th>No. refaccion</th>
                            <th>Nombre</th>
                            <th>Precio unitario</th>
                        </tr>
                    </thead>
                    
            <?php
            $refacciones= array(array());
        $index=0;
        $stmt = $mysqli->prepare("SELECT refaccion_codigo,refaccion_nombre,refaccion_precio_unitario FROM Refacciones ORDER BY refaccion_codigo");
        $stmt->execute();    // Execute the prepared query.
        $stmt->store_result();
        $stmt->bind_result($id,$nombre,$precio);
        while($stmt->fetch()){
                
            $refacciones[$index][0]= $id;
            $refacciones[$index][1]= $nombre;
            $refacciones[$index][2]=$precio;
            
            $index++;
        }
        $index--;
       
        $stmt->close();
            for($i=0;$i<=$index;$i++){
                    echo "<tr onclick='agregarRefaccion(\"".$refacciones[$i][0]."\", \"".$refacciones[$i][1]."\",".$refacciones[$i][2].",".$indiceFactura.")'>";
                    echo '<td>'.$refacciones[$i][0].'</td>';
                    echo '<td>'.$refacciones[$i][1].'</td>';
                    echo '<td>'.$refacciones[$i][2].'</td';
                    echo '</tr>';
            }
            ?>
                </table>
                
            </div>
            </div>
        </div>
        <div id="nuevoServicio" class="modal">
            <div class='modal-content'>
            <span class="close">&times;</span>
            <div class="center">
                <h3>Servicios</h3>
                <table>
                    <thead>
                        <tr>
                            <th>No. servicio</th>
                            <th>Descripci&oacute;n</th>
                            <th>Precio unitario</th>
                        </tr>
                    </thead>
                    
            <?php
            $refacciones= array(array());
        $index=0;
        $stmt = $mysqli->prepare("SELECT servicio_codigo,servicio_descripcion,servicio_precio_unitario FROM Servicios ORDER BY servicio_codigo");
        $stmt->execute();    // Execute the prepared query.
        $stmt->store_result();
        $stmt->bind_result($id,$nombre,$precio);
        while($stmt->fetch()){
                
            $refacciones[$index][0]= $id;
            $refacciones[$index][1]= $nombre;
            $refacciones[$index][2]=$precio;
            
            $index++;
        }
        $index--;
       
        $stmt->close();
            for($i=0;$i<=$index;$i++){
                    echo "<tr onclick='agregarServicio(\"".$refacciones[$i][0]."\", \"".$refacciones[$i][1]."\",".$refacciones[$i][2].")'>";
                    echo '<td>'.$refacciones[$i][0].'</td>';
                    echo '<td>'.$refacciones[$i][1].'</td>';
                    echo '<td>'.$refacciones[$i][2].'</td';
                    echo '</tr>';
            }
            ?>
                </table>
                
            </div>
            </div>
        </div>
    </body>
</html>