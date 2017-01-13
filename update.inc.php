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
}else if(isset($_POST['codigo_ref'])){
    global $mysqli;
    $codigo=$_POST['codigo_ref'];
    $cantidad=$_POST['cantidad'];
    $id_factura=$_POST['id_factura_ref'];
    $query="UPDATE Factura_por_refaccion SET refaccion_cantidad=? WHERE factura_fkey=? AND refaccion_fkey=?";
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
  if ($update_stmt = $mysqli->prepare("UPDATE Facturas SET factura_total=?,factura_notas=?,factura_numero=? WHERE factura_pkey=?")) {
      $update_stmt->bind_param('isii',$total,$notas,$no_factura,$id_fac);
                // Execute the prepared query.
                if (!$update_stmt->execute()) {
                   
                   $error_msg.="<p class='error'>Error al actualizarn/p>";
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
        if ($insert_stmt = $mysqli->prepare("INSERT INTO Factura_por_refaccion(factura_fkey,refaccion_fkey,refaccion_cantidad) VALUES (?,?, ?)")) {
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
        if ($insert_stmt = $mysqli->prepare("INSERT INTO Factura_por_servicio(factura_fkey,servicio_fkey,servicio_cantidad) VALUES (?,?, ?)")) {
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
}else if(isset($_POST['id_orden'])){
    global $mysqli;
    $id_fac=$_POST['id_orden'];
  $total =$_POST['granTotal'];
  $no_orden=$_POST['no_orden'];
  $notas = isset($_POST['notas'])? $_POST['notas']:"";
  if ($update_stmt = $mysqli->prepare("UPDATE Ordenes_compra SET orden_total=?,orden_notas=?,orden_numero=? WHERE orden_pkey=?")) {
      $update_stmt->bind_param('isii',$total,$notas,$no_orden,$id_fac);
                // Execute the prepared query.
                if (!$update_stmt->execute()) {
                   
                   $error_msg.="<p class='error'>Error al actualizarn/p>";
                }

                $correct_msg.="<p class='correct'>Exito! Se actualizo correctamente</p>";
     }else{
                $error_msg.="<p class='error'>Error en la base de datos</p>";
  }
  //Si no hubo error al capturar la orden proceder con el identificador de dicha orden
  if(empty($error_msg)){
    if(isset($_POST['refacciones'])){
      $refacciones = $_POST['refacciones'];
      $cantidadesRefacciones = $_POST['cantidades'];
      //por cada refaccion captura inserta una relacion en la orden
      foreach( $refacciones as $key => $n){
        if ($insert_stmt = $mysqli->prepare("INSERT INTO Orden_por_refaccion(orden_fkey,refaccion_fkey,refaccion_cantidad) VALUES (?,?, ?)")) {
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
      //por cada servicio captura inserta una relacion hacia la Orden
      foreach( $servicios as $key => $n){
        if ($insert_stmt = $mysqli->prepare("INSERT INTO Orden_por_servicio(orden_fkey,servicio_fkey,servicio_cantidad) VALUES (?,?, ?)")) {
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