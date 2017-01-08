<?php
include_once 'new.inc.php';
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
        }
        
        ?>

            <form action="alta_servicio.php" 
                method="post"
                name="new_form">
            
            <div class="left">
                <h3>Nuevo servicio</h3>
            <label>Codigo de servicio</label>
            <input type="text" class="capitalize" required name="codigo"  /><br><br>
            <label>Descripci&oacute;n</label>
            <input type="text" class="capitalize" required name="descripcion"  /><br><br>
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
        </div>
    </div>

</body>
</html>