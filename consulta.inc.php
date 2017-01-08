<?php
include_once '_includes/db_connect.php';

 global $mysqli;
        $condicion="";
        $condicion_refaccion="";
        $valorCliente="";
        $valorFecha="";
        $valorRefaccion="";
        $valorServicio="";
        if( !empty($_POST['cliente'])){
            $valorCliente=$_POST['cliente'];
            $condicion.= " AND cliente_nombre LIKE '%".$valorCliente."%'";
            
        }
        if(!empty($_POST['fecha'])){
            $valorFecha=$_POST['fecha'];
            $time = strtotime($_POST['fecha']);
            $newformat = date('Y-d-m',$time);
            $tomorrow = date('Y-d-m',strtotime($_POST['fecha']. "+1 days"));
            if(empty($condicion)){
                $condicion=" WHERE factura_fecha BETWEEN '".$newformat."' AND '".$tomorrow."'";
            }else{
                $condicion.= " AND factura_fecha BETWEEN '".$newformat."' AND '".$tomorrow."'";
            }
        }
        if( !empty($_POST['refaccion'])){
            if(empty($condicion)){
                $condicion.=" WHERE";
            }else{
                $condicion.=" AND";
            }
            $valorRefaccion=$_POST['refaccion'];
                $stmtFiltrado =  $mysqli->prepare("SELECT factura_fkey FROM Factura_por_refaccion INNER JOIN Refacciones ON refaccion_fkey
                = refaccion_codigo WHERE refaccion_codigo LIKE '%".$_POST['refaccion']."%'");
                
                $stmtFiltrado->execute();
                $stmtFiltrado->bind_result($idFactura);
                $condicion.=" factura_pkey IN (";
                while($stmtFiltrado->fetch()){
                    $condicion.=$idFactura.",";
                }
                $condicion=rtrim($condicion,",");
                $condicion.=")";
                $stmtFiltrado->close();
        }
        if( !empty($_POST['servicio'])){
            if(empty($condicion)){
                $condicion.=" WHERE";
            }else{
                $condicion.=" AND";
            }
            $valorServicio=$_POST['servicio'];
                $stmtFiltrado =  $mysqli->prepare("SELECT factura_fkey FROM Factura_por_servicio INNER JOIN Servicios ON servicio_fkey
                = servicio_codigo WHERE servicio_codigo LIKE '%".$_POST['servicio']."%'");
                
                $stmtFiltrado->execute();
                $stmtFiltrado->bind_result($idFactura);
                $condicion.=" factura_pkey IN (";
                while($stmtFiltrado->fetch()){
                    $condicion.=$idFactura.",";
                }
                $condicion=rtrim($condicion,",");
                $condicion.=")";
                $stmtFiltrado->close();
        }
        //Busca los datos basicos de todas las facturas
        $stmt=$mysqli->prepare("SELECT factura_pkey,factura_total,DATE_FORMAT(factura_fecha,'%d/%m/%Y'),cliente_nombre,
        cliente_razon,cliente_domicilio,cliente_contacto,cliente_telefono,cliente_correo,factura_notas
        FROM Facturas INNER JOIN Clientes ON cliente_fkey = cliente_pkey".$condicion." ORDER BY factura_fecha");
        $basicos=array(array());
        $indicebasicos=0;
        $stmt->execute();  

        $stmt->bind_result($id,$total,$fecha,$cliente_nombre,$cliente_razon,$cliente_domicilio,$cliente_contacto,$cliente_telefono,
        $cliente_correo,$factura_notas);
        while($stmt->fetch()){ 
            $basicos[$indicebasicos][0]=$id;
            $basicos[$indicebasicos][1]=$total;
            $basicos[$indicebasicos][2]=$fecha;
            $basicos[$indicebasicos][3]=$cliente_nombre;
            $basicos[$indicebasicos][4]=$cliente_razon;
            $basicos[$indicebasicos][5]=$cliente_domicilio;
            $basicos[$indicebasicos][6]=$cliente_contacto;
            $basicos[$indicebasicos][7]=$cliente_telefono;
            $basicos[$indicebasicos][8]=$cliente_correo;
            $basicos[$indicebasicos][9]=$factura_notas;
            $indicebasicos++;
        }

?>