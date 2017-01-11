<?php
include_once 'update.inc.php';

?>
<html>
    <link rel="stylesheet" href="../css/munck.css" type="text/css">
    <script type="text/javascript" src="funciones.js"></script>
    <body>
        <div class="left">
        <?php
        if (!empty($error_msg)) {
            echo $error_msg;
        }elseif (!empty($correct_msg)) {
            echo $correct_msg;
        }
        $valor1='';
        $valor2='';
        $valor3='';
        $query='';
        if(!empty($_POST['numero_refaccion'])){
            $valor1=$_POST['numero_refaccion'];
            $query=" WHERE refaccion_codigo LIKE '%".$valor1."%'";
        }
        if(!empty($_POST['no_material'])){
            $valor2=$_POST['no_material'];
            if(empty($query)){
                $query=" WHERE refaccion_no_material LIKE '%".$valor2."%'";
            }else{
                $query.= " AND refaccion_no_material LIKE '%".$valor2."%'";
            }
        }
         if(!empty($_POST['nombre_refaccion'])){
            $valor3=$_POST['nombre_refaccion'];
            if(empty($query)){
                $query=" WHERE refaccion_nombre LIKE '%".$valor3."%'";
            }else{
                $query.= " AND refaccion_nombre LIKE '%".$valor3."%'";
            }
        }
        ?>
        <span class="close" id='filtro' onclick="mostrar('busqueda')">Filtrar v</span>
        <div id="busqueda" class="center" style="display:none;">
            <h3>Buscar por</h3>
            <form action="vista_refaccion.php" method="post">
                <div class="left"><label>No. de refaccion</label>
                <input type="text" name="numero_refaccion" value="<?=$valor1 ?>"/></div>
                <div class="left"><label>No. de material</label>
                <input type="text" name="no_material" value="<?=$valor2 ?>"/></div>
                <div class="left"><label>Nombre de refaccion</label>
                <input type="text" name="nombre_refaccion" value="<?=$valor3 ?>"/></div>
                <input type="submit" value="Buscar" class="button-small"/>
            </form>
        </div>
        <h3>Refacciones</h3>
        <table style="border:1px solid black;">
            <form action="vista_refaccion.php" 
                method="post"
                name="new_form">
            
            <tr >
                <th>Codigo de refaccion</th>
                <th>No. Material</th>
                <th>Nombre</th>
                <th>Precio unitario</th>
            </tr>
        <?php
        global $mysqli;
        $stmtLook=$mysqli->prepare("SELECT refaccion_codigo,refaccion_no_material,refaccion_nombre,refaccion_precio_unitario
        FROM Refacciones".$query." ORDER BY refaccion_codigo");
        echo $mysqli->error;
        $stmtLook->bind_result($codigo,$material,$descripcion,$precio);
        $stmtLook->execute();
        while($stmtLook->fetch()):
        ?>
            <tr >   
            <td>
            <input type="hidden" name="codigo_refaccion"  value="<?=$codigo?>"/>
            <input type="text" class="edition" name="codigo"  value="<?=$codigo?>"/></td>
            <td><input type="text" class="edition" name="no_material"  value="<?=$material?>"/></td>
            <td>
            <input type="text" class="edition" name="descripcion" value="<?=$descripcion?>" /></td>
            <td>
            <input type="text" class="edition" name="precio" value="<?=$precio?>"/></td>
            <td>
                <img src="/css/img/save.png" height="20" width="20">
                    <span style="vertical-align:top;">
                            <input type="submit" class="button-small" value="Guardar" name='submit'/>
                    </span>
                </img>
            </td>
            </tr> 
        <?php
        endwhile;
        ?>
            </form>
        </table>
        
        
    </div>

</body>
</html>