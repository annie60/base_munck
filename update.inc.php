<?php
include_once '_includes/db_connect.php';

$error_msg="";
$correct_msg="";

if(isset($_POST['codigo_servicio'])){
    global $mysqli;
    $codigo_antiguo=$_POST['codigo_servicio'];
    if($_POST['accion'] ==0){
        $codigo=$_POST['codigo'];
        $descripcion=$_POST['descripcion'];
        $precio=floatval( $_POST['precio']);
        $stmt=$mysqli->prepare("UPDATE Servicios SET servicio_codigo=?,servicio_descripcion=?,servicio_precio_unitario=? WHERE servicio_codigo=?");
        $stmt->bind_param('ssis',$codigo,$descripcion,$precio,$codigo_antiguo);
    }else{
        $stmt=$mysqli->prepare("DELETE FROM Servicios WHERE servicio_codigo=?");
        $stmt->bind_param('s',$codigo_antiguo);
    }
    if(!$stmt->execute()){
        $error=$stmt->error;
        $error_msg.="<p class='error'>Error al actualizar".$error."</p>";
    }else{
        $correct_msg.="<p class='correct'>Los cambios se guardaron ".$query."</p>";
    }
}else if(isset($_POST['codigo_refaccion'])){
    global $mysqli;
    $codigo_antiguo=$_POST['codigo_refaccion'];
    if($_POST['accion'] ==0){
        $codigo=$_POST['codigo'];
        $descripcion=$_POST['descripcion'];
        $precio=floatval( $_POST['precio']);
    
        $stmt=$mysqli->prepare("UPDATE Refacciones SET refaccion_codigo=?,refaccion_nombre=?,refaccion_precio_unitario=? WHERE refaccion_codigo=?");
        $stmt->bind_param('ssis',$codigo,$descripcion,$precio,$codigo_antiguo);
    }else{
        $stmt=$mysqli->prepare("DELETE FROM Refacciones WHERE refaccion_codigo=?");
        $stmt->bind_param('s',$codigo_antiguo);
    }
    if(!$stmt->execute()){
        $error=$stmt->error;
        $error_msg.="<p class='error'>Error al actualizar".$error."</p>";
    }else{
        $correct_msg.="<p class='correct'>Los cambios se guardaron ".$query."</p>";
    }
}else if(isset($_POST['codigo_ref'])){
    global $mysqli;
    $codigo=$_POST['codigo_ref'];
    $cantidad=$_POST['cantidad'];
    $id_factura=$_POST['id_factura_ref'];
    $query="UPDATE ".$relacion."_por_refaccion SET refaccion_cantidad=? WHERE ".$nombreCampo."_fkey=? AND refaccion_fkey=?";
    $stmt=$mysqli->prepare($query);
    $stmt->bind_param('iis',$cantidad,$id_factura,$codigo);
    if(!$stmt->execute()){
        $error=$stmt->error;
        $error_msg.="<p class='error'>Error al actualizar ".$error."</p>";
    }else{
        $correct_msg.="<p class='correct'>Los cambios se guardaron </p>";
    }
}else if(isset($_POST['codigo_serv'])){
    global $mysqli;
    $codigo=$_POST['codigo_serv'];
    $cantidad=$_POST['cantidad'];
    $id_factura=$_POST['id_factura_serv'];
    $query="UPDATE ".$relacion."_por_servicio SET servicio_cantidad=? WHERE ".$nombreCampo."_fkey=? AND servicio_fkey=?";
    $stmt=$mysqli->prepare($query);
    $stmt->bind_param('iis',$cantidad,$id_factura,$codigo);
    if(!$stmt->execute()){
        $error=$stmt->error;
        $error_msg.="<p class='error'>Error al actualizar ".$error."</p>";
    }else{
        $correct_msg.="<p class='correct'>Los cambios se guardaron </p>";
    }
}else if(isset($_POST['id_factura'])){
    global $mysqli;
    $id_fac=$_POST['id_factura'];
  $total =$_POST['granTotal'];
  $no_factura=$_POST['no_factura'];
  $notas = isset($_POST['notas'])? $_POST['notas']:"";
  $fecha = isset($_POST['fecha'])? $_POST['fecha']:"";
  if ($update_stmt = $mysqli->prepare("UPDATE ".$tabla." SET ".$nombreCampo."_total=?,".$nombreCampo."_notas=?,
  ".$nombreCampo."_numero=?,".$nombreCampo."_fecha_facturacion=? WHERE ".$nombreCampo."_pkey=?")) {
      $update_stmt->bind_param('isisi',$total,$notas,$no_factura,$fecha,$id_fac);
                // Execute the prepared query.
                if (!$update_stmt->execute()) {
                   
                   $error_msg.="<p class='error'>Error al actualizar</p>";
                }

                $correct_msg.="<p class='correct'>Exito! Se actualizo correctamente</p>";
     }else{
                $error_msg.="<p class='error'>Error en la base de datos</p>";
  }
  //Si no hubo error al capturar la factura proceder con el identificador de dicha factura
  if(empty($error_msg)){
    if(isset($_POST['refacciones'])){
      $refacciones = $_POST['refacciones'];
      $cantidadesRefacciones = $_POST['cantidades'];
      //por cada refaccion captura inserta una relacion en la factura
      foreach( $refacciones as $key => $n){
        if ($insert_stmt = $mysqli->prepare("INSERT INTO ".$relacion."_por_refaccion(".$nombreCampo."_fkey,refaccion_fkey,refaccion_cantidad) VALUES (?,?, ?)")) {
          $insert_stmt->bind_param('isi',$id_fac,$refacciones[$key],$cantidadesRefacciones[$key]);
                // Execute the prepared query.
                if (!$insert_stmt->execute()) {
                   
                   $error_msg.="<p class='error'>Error al dar de alta la refacci&oacute;n/p>";
                
                  break;
                }

        }else{
                $error_msg.="<p class='error'>Error al dar de alta la refacci&oacute;n</p>";
        
            break;
        }
      }
    }
    if(isset($_POST['servicios'])){
      $servicios = $_POST['servicios'];
      $cantidadesServicios = $_POST['cantidades2'];
      //por cada servicio captura inserta una relacion hacia la factura
      foreach( $servicios as $key => $n){
        if ($insert_stmt = $mysqli->prepare("INSERT INTO ".$relacion."_por_servicio(".$nombreCampo."_fkey,servicio_fkey,servicio_cantidad) VALUES (?,?, ?)")) {
          $insert_stmt->bind_param('isi',$id_fac,$servicios[$key],$cantidadesServicios[$key]);
                // Execute the prepared query.
                if (!$insert_stmt->execute()) {
                   $error_msg.="<p class='error'>".$insert_stmt->error." ".$servicios[$key]."</p>";
                   $error_msg.="<p class='error'>Error al dar de alta el servicio</p>";
                
                  break;
                }
         }else{
                $error_msg.="<p class='error'>Error en la base de datos</p>";
        
            break;
        }
      }
    }

  }
}