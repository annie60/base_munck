<?php
include_once '_includes/db_connect.php';
include_once 'exec.inc.php';
?>
<!DOCTYPE html>
<html>
    <link rel="stylesheet" href="css/munck.css" type="text/css" />
    <script type="text/javascript" src="funciones.js"></script>

    
    <body style="width=100%;">
        
        <h2 onclick="abrir(1)" style="cursor:pointer;">Paso 1.</h2>
        <div id="Paso1" class="pasos">
        <h3>Que quieres hacer?</h3>
        <input type="button" class="button" value="Consultar" onclick="escoger('SELECT',1)"/>
        <input type="button" class="button" value="Insertar" onclick="escoger('INSERT',1)"/>
        <input type="button" class="button" value="Borrar" onclick="escoger('DELETE',1)"/>
        <input type="button" class="button" value="Actualizar" onclick='escoger("UPDATE",1)'/>
        </div>
        <h2 onclick="abrir(2)" style="cursor:pointer;">Paso 2.</h2>
        <div id="Paso2" style="display:none;" class="pasos">
        <h3>De que tabla?</h3>    
        <?php
        $stmt=$mysqli->prepare("SHOW TABLES FROM munck");
        $tablas=array();
        $indiceTablas=0;
        $stmt->execute();   // Execute the prepared query.
        $result = $stmt->get_result();
        while($data=$result->fetch_row()):?>
            <input type="button" class="button" value="<?=$data[0]?>" onclick="agregar(this.value,'tablas')"/>
        <?php 
        $tablas[$indiceTablas]=$data[0];
        $indiceTablas++;
        endwhile;?>
        <br>
        <div id='tip1' class='correct'></div><br>
        </div>
        <h2 onclick="abrir(3)" style="cursor:pointer;">Paso 3.</h2>
        <div id="Paso3" style="display:none;" class="pasos">
        <h3>Cuales campos?</h3>
        <?php
        for($indiceTabla=0;$indiceTabla<$indiceTablas;$indiceTabla++):?>
            
            <?php 
            $tablaActual=$tablas[$indiceTabla];
            $query_preparado = "SELECT * FROM ".$tablaActual;
            $stmt = $mysqli->prepare($query_preparado);
            $stmt->execute();
            $result = $stmt->get_result();
            $valoresColumnas = $result->fetch_fields();
            ?>
            <div id="<?=$tablaActual?>valores" class="campos">
            <?php foreach ($valoresColumnas as $val) :
                $valorActual=$val->name;
            ?>
                <input type="button" value="<?=$valorActual?>" id="<?=$valorActual?>" onclick='agregar(this.value,"campos")'/>
                
            <?php endforeach;?>
            </div>
        <?php endfor;?>
        </div><br>
        <div id='tip2' class='correct'></div>
        <input type="button" class="button" id="crearQuery" style="display:none;" value="Crear consulta" onclick="crearQuery()"/>
        <input type="hidden" id="tipoConsulta" value=""/>
        <input type="hidden" id="campos" value=""/>
        <input type="hidden" id="tablas" value=""/>
        <input type="hidden" id="arregloTablas" value=""/>
        <br>
        <?php
        if(!empty($error_msg)){
            echo $error_msg;
        }
        ?>
        <form action="consulta.php" method="post">
            <textarea id="query" name="query" cols="50" wrap="hard"><?=$query?></textarea><br><br>
            <input type="submit" value="Ejecutar" class="button"/><br><br>
        </form>
        <?php
            if($total>0):
        ?>
        <table style="border: 1px solid black;">
            <thead>
            <tr style="border: 1px solid black;">
                <?php
                for($titulo=0;$titulo<$total;$titulo++):
                ?>
                <th style="border: 1px solid black;">
                    <?=$columnas[$titulo]?>
                </th>
                <?php endfor;?>
            </tr>
            </thead>
            <?php
            for($filaActual=0;$filaActual<=$index;$filaActual++):
            ?>
            <tr style="border: 1px solid black;">
                <?php
                for($campoActual=0;$campoActual<$total;$campoActual++):
                ?>
                <td style="border: 1px solid black;">
                    <?=$resultados[$filaActual][$campoActual]?>
                </td>
                <?php endfor;?>
            </tr>
            <?php endfor;?>
        </table>
        <?php endif;?>
    </body>
</html>