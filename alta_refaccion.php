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
        
        ?>

            <form action="alta_refaccion.php" 
                method="post"
                name="new_form">
            
            <div class="left">
                <h3>Nueva refaccion</h3>
            <label>Codigo de refaccion</label>
            <input type="text" class="capitalize" required name="codigo"  /><br><br>
            <label>No. Material</label>
            <input type="text" class="capitalize" required name="material"  /><br><br>
            <label>Nombre de pieza</label>
            <input type="text" class="capitalize" required name="nombre"  /><br><br>
            <label>Precio unitario</label>
            <input type="text" required name="precio" /><br><br>
            
            
            <br>
                <img src="/css/img/save.png" height="20" width="20">
                    <span style="vertical-align:top;">

                            <input type="submit" class="button-small" value="Guardar" name='submit'/>

                    </span>
                </img>
            </div>
            
        </form>
        <input type="button" class="button" value="Ver refacciones" onclick='agregarAFactura(1,-1)'/>
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
                    echo "<tr>";
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