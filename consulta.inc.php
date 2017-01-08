<?php
include_once '_includes/db_connect.php';

 global $mysqli;
        $condicion="";
        $condicion_refaccion="";
        $valorCliente="";
        $valorFecha="";
        $valorRefaccion="";
        $valorServicio="";
        $valorNumero="";
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
                $condicion=" WHERE ".$nombreCampo."_fecha BETWEEN '".$newformat."' AND '".$tomorrow."'";
            }else{
                $condicion.= " AND ".$nombreCampo."_fecha BETWEEN '".$newformat."' AND '".$tomorrow."'";
            }
        }
        if(!empty($_POST['numero_of'])){
            $valorNumero=$_POST['numero_of'];

            if(empty($condicion)){
                $condicion=" WHERE ".$nombreCampo."_numero =".$valorNumero."";
            }else{
                $condicion.= " AND ".$nombreCampo."_numero =".$valorNumero."";
            }
        }
        if( !empty($_POST['refaccion'])){
            if(empty($condicion)){
                $condicion.=" WHERE";
            }else{
                $condicion.=" AND";
            }
            $valorRefaccion=$_POST['refaccion'];
                $stmtFiltrado =  $mysqli->prepare("SELECT ".$nombreCampo."_fkey FROM ".$relacion."_por_refaccion INNER JOIN Refacciones ON refaccion_fkey
                = refaccion_codigo WHERE refaccion_codigo LIKE '%".$_POST['refaccion']."%'");
                
                $stmtFiltrado->execute();
                $stmtFiltrado->bind_result($idFactura);
                $condicion.=" ".$nombreCampo."_pkey IN (";
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
                $stmtFiltrado =  $mysqli->prepare("SELECT ".$nombreCampo."_fkey FROM ".$relacion."_por_servicio INNER JOIN Servicios ON servicio_fkey
                = servicio_codigo WHERE servicio_codigo LIKE '%".$_POST['servicio']."%'");
                
                $stmtFiltrado->execute();
                $stmtFiltrado->bind_result($idFactura);
                $condicion.=" ".$nombreCampo."_pkey IN (";
                while($stmtFiltrado->fetch()){
                    $condicion.=$idFactura.",";
                }
                $condicion=rtrim($condicion,",");
                $condicion.=")";
                $stmtFiltrado->close();
        }
        //Busca los datos basicos de todas las facturas
        $stmt=$mysqli->prepare("SELECT ".$nombreCampo."_pkey,".$nombreCampo."_total,DATE_FORMAT(".$nombreCampo."_fecha,'%d/%m/%Y'),cliente_nombre,
        cliente_razon,cliente_domicilio,cliente_contacto,cliente_telefono,cliente_correo,".$nombreCampo."_notas,".$nombreCampo."_numero, cliente_pkey 
        FROM ".$tabla." INNER JOIN Clientes ON cliente_fkey = cliente_pkey".$condicion." ORDER BY ".$nombreCampo."_fecha");
        $basicos=array(array());
        $indicebasicos=0;
        $stmt->execute();  

        $stmt->bind_result($id,$total,$fecha,$cliente_nombre,$cliente_razon,$cliente_domicilio,$cliente_contacto,$cliente_telefono,
        $cliente_correo,$factura_notas,$numero,$cliente_id);
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
            $basicos[$indicebasicos][10]=$numero;
            $basico[$indicebasicos][11]=$cliente_id;
            $indicebasicos++;
            
        }

?>