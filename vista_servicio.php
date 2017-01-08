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
        <h3>Servicios</h3>
        <table style="border:1px solid black;">
            <form action="vista_servicio.php" 
                method="post"
                name="new_form">
            
            <tr >
                <th>Codigo de servicio</th>
                <th>Descripci&oacute;n</th>
                <th>Precio unitario</th>
            </tr>
        <?php
        global $mysqli;
        $stmtLook=$mysqli->prepare("SELECT servicio_codigo,servicio_descripcion,servicio_precio_unitario
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