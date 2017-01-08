<?php
include_once '_includes/db_connect.php';

$error_msg="";
$correct_msg="";

if(isset($_POST['codigo_servicio'])){
    global $mysqli;
    $codigo_antiguo=$_POST['codigo_servicio'];
    $codigo=$_POST['codigo'];
    $descripcion=$_POST['descripcion'];
    $precio=floatval( $_POST['precio']);
    $query="UPDATE Servicios SET servicio_codigo=".$codigo.",servicio_descripcion=".$descripcion.",servicio_precio_unitario=".$precio." 
    WHERE servicio_codigo=".$codigo_antiguo."";
    $stmt=$mysqli->prepare("UPDATE Servicios SET servicio_codigo=?,servicio_descripcion=?,servicio_precio_unitario=? WHERE servicio_codigo=?");
    $stmt->bind_param('ssis',$codigo,$descripcion,$precio,$codigo_antiguo);
    if(!$stmt->execute()){
        $error=$stmt->error;
        $error_msg.="<p class='error'>Error al actualizar".$error."</p>";
    }else{
        $correct_msg.="<p class='correct'>Los cambios se guardaron ".$query."</p>";
    }
}