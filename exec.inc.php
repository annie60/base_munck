    <?php
    $query="";
    $total=0;
    $error_msg="";
    if(isset($_POST['query'])){
        global $mysqli;
        $query=$_POST['query'];
        $resultados= array(array());
        $columnas=array();
        $index=0;
        if($stmt = $mysqli->prepare($query)){
        
        if($stmt->execute()){   // Execute the prepared query.
  
        $total = $stmt->field_count;

        $result = $stmt->get_result();
        $valoresColumnas = $result->fetch_fields();
        foreach ($valoresColumnas as $val) {
            $columnas[$index] = $val->name;
            $index++;
        }
        $index=0;
        while($data=$result->fetch_array(MYSQLI_NUM)){
            for($i=0;$i<$total;$i++){
                
                $resultados[$index][$i]=$data[$i];
                
            }
            
            $index++;
        }


        $index--;
       
        $stmt->close();
            
        }else{
            $error_msg.="<p class='error'>".$stmt->error."</p>";
        }
            
        }else{
             $error_msg.="<p class='error'>".$mysqli->error."</p>";
        }
    }
    ?>