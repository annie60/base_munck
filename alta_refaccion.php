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
        <div class="left">
            <div class="left">
            
            </div>

        </div><br><br>
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
        </div>
    </div>

</body>
</html>