<?php
include_once '_includes/db_connect.php';

$error_msg = "";
$correct_msg = "";
if(isset($_POST['descripcion'])){
    global $mysqli;
    $descripcion = $_POST['descripcion'];
    $codigo = $_POST['codigo'];
    $precio = $_POST['precio'];
    $precio = floatval($precio);
    // Insert the new user into the database 
    if ($insert_stmt = $mysqli->prepare("INSERT INTO Servicios(servicio_codigo,servicio_descripcion,servicio_precio_unitario) 
    VALUES (?,?, ?)")) {
      $insert_stmt->bind_param('ssi',$codigo, $descripcion,$precio);
                // Execute the prepared query.
                if (!$insert_stmt->execute()) {
                   
                   $error_msg.="<p class='error'>Error al dar de alta el servicio</p>";
                }
                $correct_msg.="<p class='correct'>Exito! Se creo con exito</p>";
    }else{
                $error_msg.="<p class='error'>Error al dar de alta el servicio</p>";
    }
    
}else if(isset($_POST['nombre'])){
    global $mysqli;
    $nombre = $_POST['nombre'];
    $codigo = $_POST['codigo'];
    $precio = $_POST['precio'];
    $material=$_POST['material'];
    $precio = floatval($precio);
    // Inserta nueva refaccion
    if ($insert_stmt = $mysqli->prepare("INSERT INTO Refacciones(refaccion_codigo,refaccion_no_material,refaccion_nombre,refaccion_precio_unitario) 
    VALUES (?,?, ?)")) {
      $insert_stmt->bind_param('ssi',$codigo, $nombre,$precio);
                // Execute the prepared query.
                if (!$insert_stmt->execute()) {
                   
                   $error_msg.="<p class='error'>Error al dar de alta la refacci&oacute;n/p>";
                }
                $correct_msg.="<p class='correct'>Exito! Se creo con exito</p>";
    }else{
                $error_msg.="<p class='error'>Error en la base de datos</p>";
    }
}else if(isset($_POST['cliente'])){
  global $mysqli;
  $cliente= $_POST['cliente'];
  $total =$_POST['granTotal'];
  $no_factura=$_POST['no_factura'];
  $notas = isset($_POST['notas'])? $_POST['notas']:"";
  if ($insert_stmt = $mysqli->prepare("INSERT INTO Facturas(cliente_fkey,factura_total,factura_notas,factura_numero) 
    VALUES (?,?,?,?)")) {
      $insert_stmt->bind_param('iisi',$cliente,$total,$notas,$no_factura);
                // Execute the prepared query.
                if (!$insert_stmt->execute()) {
                   
                   $error_msg.="<p class='error'>Error al crear factura;n/p>";
                }
                $last_id= $insert_stmt->insert_id;
                $correct_msg.="<p class='correct'>Exito! Se creo con exito</p>";
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
          $insert_stmt->bind_param('isi',$last_id,$refacciones[$key],$cantidadesRefacciones[$key]);
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
          $insert_stmt->bind_param('isi',$last_id,$servicios[$key],$cantidadesServicios[$key]);
                // Execute the prepared query.
                if (!$insert_stmt->execute()) {
                   
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
}else if(isset($_POST['razon'])){
    global $mysqli;
    $nombre = $_POST['nombreCliente'];
    $razon = $_POST['razon'];
    $telefono = isset($_POST['telefono'])? $_POST['telefono']:"";
    $domicilio = isset($_POST['domicilio'])? $_POST['domicilio']:"";
    $contacto = isset($_POST['contacto'])? $_POST['contacto']:"";
    $puesto = isset($_POST['puesto'])? $_POST['puesto']:"";
    $correo = isset($_POST['correo'])? $_POST['correo']:"";
    $telefono1 = isset($_POST['telefono1'])? $_POST['telefono1']:"";
    $telefono2 = isset($_POST['telefono2'])? $_POST['telefono2']:"";
    $estado = isset($_POST['estado'])? $_POST['estado']:"";
    $ciudad = isset($_POST['ciudad'])? $_POST['ciudad']:"";
    $codigo = isset($_POST['codigo'])? $_POST['codigo']:"";
    // Inserta nuevo cliente 
    if ($insert_stmt = $mysqli->prepare("INSERT INTO Clientes(cliente_nombre,cliente_razon,cliente_telefono,cliente_domicilio,cliente_contacto,
  cliente_puesto_contacto,cliente_correo,cliente_telefono1,cliente_telefono2,cliente_estado,cliente_ciudad,cliente_codigo) 
    VALUES (?,?,?,?,?,?,?,?,?,?,?,?)")) {
      $insert_stmt->bind_param('ssssssssssss',$nombre,$razon,$telefono,$domicilio,$contacto,$puesto,$correo,$telefono1,$telefono2,$estado,
      $ciudad,$codigo);
                // Execute the prepared query.
                if (!$insert_stmt->execute()) {
                   
                   $error_msg.="<p class='error'>Error al dar de alta el cliente/p>";
                }
                $correct_msg.="<p class='correct'>Exito! Se creo con exito</p>";
    }else{
                $error_msg.="<p class='error'>Error en la base de datos</p>";
    }
}else if(isset($_POST['cliente1'])){
  global $mysqli;
  $cliente= $_POST['cliente1'];
  $total =$_POST['granTotal'];
  $no_orden=$_POST['no_orden'];
   $notas = isset($_POST['notas'])? $_POST['notas']:"";
  if ($insert_stmt = $mysqli->prepare("INSERT INTO Ordenes_compra(cliente_fkey,orden_total,orden_notas,orden_numero) 
    VALUES (?,?,?,?)")) {
      $insert_stmt->bind_param('iisi',$cliente,$total,$notas,$no_orden);
                // Execute the prepared query.
                if (!$insert_stmt->execute()) {
                   
                   $error_msg.="<p class='error'>Error al crear nota/p>";
                }
                $last_id= $insert_stmt->insert_id;
                $correct_msg.="<p class='correct'>Exito! Se creo con exito</p>";
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
          $insert_stmt->bind_param('isi',$last_id,$refacciones[$key],$cantidadesRefacciones[$key]);
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
      //por cada servicio captura inserta una relacion hacia la orden
      foreach( $servicios as $key => $n){
        if ($insert_stmt = $mysqli->prepare("INSERT INTO Orden_por_servicio(orden_fkey,servicio_fkey,servicio_cantidad) VALUES (?,?, ?)")) {
          $insert_stmt->bind_param('isi',$last_id,$servicios[$key],$cantidadesServicios[$key]);
                // Execute the prepared query.
                if (!$insert_stmt->execute()) {
                   
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
?>