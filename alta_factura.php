<?php
include_once 'new.inc.php';
?>
<html>
    <link rel="stylesheet" href="../css/munck.css" type="text/css">
    <script type="text/javascript" src="funciones.js"></script>
    <body>
        <div class="center">
        <?php
        if (!empty($error_msg)) {
            echo $error_msg;
        }elseif (!empty($correct_msg)) {
            echo $correct_msg;
        }
        global $mysqli;
        $clientes= array(array());
        $index=0;
        $stmt = $mysqli->prepare("SELECT cliente_pkey,cliente_nombre FROM Clientes ORDER BY cliente_nombre");
        $stmt->execute();    // Execute the prepared query.
        $stmt->store_result();
        $stmt->bind_result($cliente_id,$cliente_nombre);
        while($stmt->fetch()){
                
            $clientes[$index][0]= $cliente_id;
            $clientes[$index][1]= $cliente_nombre;
            
            $index++;
        }
        $index--;
       
        $stmt->close();
        
        ?>
        <div class="left">
            <div class="left">
            
            </div>

        </div><br><br>
            <form action="alta_factura.php" 
                method="post"
                name="new_form">
            
            <div class="left">
                <h3>Nueva factura</h3>
            <label>Cliente</label>
            <select name="cliente">
            <?php
            
            for($i=0;$i<=$index;$i++){
                    
                    echo '<option value="'.$clientes[$i][0].'">'.$clientes[$i][1].'</option>';
            }
            ?>
            </select><br><br>
            <h4>Refacciones</h4>
            <div id='refaccion'>
                
            </div>
            <input type='button' value='Agregar Refacci&oacute;n' onclick='agregarAFactura(1)'/><br>
            <h4>Servicios</h4>
            <div id='servicio'></div>
            <input type='button' value='Agregar Servicio' onclick='agregarAFactura(2)'/>
            <br><br>
            <label>Gran total</label>
            <input type="text" class="disabled" value="0.00" name="granTotal" id='granTotal' />
            <br><br>
                <img src="/css/img/save.png" height="20" width="20">
                    <span style="vertical-align:top;">

                            <input type="submit" class="button-small" value="Guardar" name='submit'/>

                    </span>
                </img>
            </div>
            
        </form>
        </div>
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
                    echo "<tr onclick='agregarRefaccion(\"".$refacciones[$i][0]."\", \"".$refacciones[$i][1]."\",".$refacciones[$i][2].")'>";
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
    </div>

</body>
</html>