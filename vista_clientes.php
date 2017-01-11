<?php
include_once 'update.inc.php';

?>
<html>
    <link rel="stylesheet" href="../css/munck.css" type="text/css">
    <body>
        <div class="center">
        <?php
        if (!empty($error_msg)) {
            echo $error_msg;
        }elseif (!empty($correct_msg)) {
            echo $correct_msg;
        }?>
        <h3>Clientes</h3>
        <table style="border:1px solid black;">
            <form action="vista_clientes.php" 
                method="post"
                name="new_form">
            
            <tr >
                <th>Nombre</th>
                <th>Razon social</th>
                <th>Direccion</th>
                <th>Municipio</th>
                <th>Estado</th>
                <th>Codigo Postal</th>
                <th>Telefono</th>
                <th>Contacto</th>
                <th>Puesto</th>
                <th>Correo</th>
                <th>Telefono 1</th>
                <th>Telefono 2</th>
                <th></th>
            </tr>
        <?php
        global $mysqli;
        $stmtLook=$mysqli->prepare("SELECT cliente_codigo,cliente_descripcion,cliente_precio_unitario
        FROM Servicios ORDER BY servicio_codigo");
        echo $mysqli->error;
        $stmtLook->bind_result($codigo,$descripcion,$precio);
        $stmtLook->execute();
        while($stmtLook->fetch()):
        ?>
            <tr >   
            <td>
            <input type="hidden" name="codigo_servicio"  value="<?=$codigo?>"/>
            <input type="text" class="edition" name="codigo"  value="<?=$codigo?>"/></td>
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