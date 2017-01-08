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

            <form action="alta_cliente.php" 
                method="post"
                name="new_form">
            
            <div class="left">
                <h3>Nuevo cliente</h3>
            <label>Razon social</label>
            <input type="text" class="capitalize" required name="razon"  /><br><br>
            <label>Nombre</label></label>
            <input type="text" class="capitalize" required name="nombreCliente"  /><br><br>
            <label>Domicilio</label>
            <textarea name="domicilio"></textarea><br><br>
            <label>Estado</label>
            <input type="text" name="estado" /><br><br>
            <label>Ciudad</label>
            <input type="text" name="ciudad" /><br><br>
            <label>Codigo postal</label>
            <input type="text" name="codigo" /><br><br>
            <label>Telefono</label>
            <input type="text" name="telefono" /><br><br>
            <label>Contacto</label>
            <input type="text" name="contacto" /><br><br>
            <label>Correo electronico</label>
            <input type="text"  name="correo" /><br><br>
            <label>Telefono principal</label>
            <input type="text" name="telefono1" /><br><br>
            <label>Telefono movil</label>
            <input type="text" name="telefono2" /><br><br>
            <label>Puesto</label>
            <input type="text" name="puesto" /><br><br>
            
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