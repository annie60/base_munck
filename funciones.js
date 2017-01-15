
        function escoger(funcion,identificador){
            document.getElementById("tipoConsulta").value=funcion;
            if(identificador===1){
                document.getElementById("tipoConsulta").value=funcion+" ";
            }
            
            if(identificador===3){
                document.getElementById("crearQuery").style.display="block";
            }else{
                siguiente(identificador);
            }
        }
        function agregar(valor,tipo){
            var valorActual=document.getElementById(tipo).value;
            var tipoQuery=document.getElementById("tipoConsulta").value;
            if(tipo == "campos"){//Si la opción es de campos
                switch (tipoQuery) {
                    case 'SELECT ':
                        if(valorActual.length > 0){
                            document.getElementById(tipo).value=valorActual+","+valor;
                        }else{
                            document.getElementById(tipo).value=valor;
                        }
                        break;
                    case 'INSERT ':
                        if(valorActual.length > 0){
                            document.getElementById(tipo).value=valorActual+","+valor;
                        }else{
                            document.getElementById(tipo).value=valor;
                        }
                        break;
                    case 'DELETE ':
                        if(valorActual.length > 0){
                            document.getElementById(tipo).value=valorActual+" AND "+valor+" = ____";
                        }else{
                            document.getElementById(tipo).value=" WHERE "+valor+" = ____";
                        }
                        break;
                    case 'UPDATE ':
                        if(valorActual.length > 0){
                            document.getElementById(tipo).value=valorActual+" , "+valor+" = ____";
                        }else{
                            document.getElementById(tipo).value=" SET "+valor+" = ____";
                        }
                        break;
                    default:
                        break;
                }
                document.getElementById("crearQuery").style.display="block";
                document.getElementById(valor).style.display="none";
            }else{
                 var tablasActuales=document.getElementById("arregloTablas").value;
                document.getElementById("arregloTablas").value=tablasActuales+","+valor;
                
                switch (tipoQuery) {
                    case 'SELECT ':
                        if(valorActual.length >0){//Ya contiene joins
                            document.getElementById(tipo).value=valorActual+" INNER JOIN "+valor+" ON ____ = _____";
                        }else{//Es la primera tabla
                            document.getElementById(tipo).value=" FROM "+valor;
                        }
                        document.getElementById("tip1").innerHTML="Si estas lista presiona el paso 3";
                    break;
                    case 'INSERT ':
                        document.getElementById(tipo).value=" INTO "+valor+"(";
                        filtrar();
                        siguiente(2);
                        break;
                    case 'DELETE ':
                        document.getElementById(tipo).value=" FROM "+valor;
                        filtrar();
                        siguiente(2);
                        break;
                    case 'UPDATE ':
                        document.getElementById(tipo).value=valor;
                        filtrar();
                        siguiente(2);
                    default:
                        break;
                }
                
               
            }
        }
        function formateoFinal(){
            var tipoQuery=document.getElementById("tipoConsulta").value;
            switch (tipoQuery) {
                    case 'INSERT ':
                        var campos = document.getElementById("campos").value;
                        var arregloCampos = campos.split(',');
                        var valores = ") VALUES (";
                        for(var indiceValor=0;indiceValor<arregloCampos.length;indiceValor++){
                            if(indiceValor == arregloCampos.length-1){
                                valores=valores+"______";
                            }else{
                                valores=valores+"______,";
                            }
                        }
                        valores=valores+")";
                        document.getElementById("campos").value=campos+valores;
                        break;
                    case 'UPDATE ':
                        var campos = document.getElementById("campos").value;
                        var arregloCampos = campos.split(',');
                        var valores = " WHERE ____ = ____";
                        
                        document.getElementById("campos").value=campos+valores;
                        break;
            }
        }
        function crearQuery(){
            formateoFinal();
            //Concatena todo lo seleccionado y lo muestra
            var consulta=document.getElementById("tipoConsulta").value;
            var valores=document.getElementById("campos").value;
            var tablas=document.getElementById("tablas").value;
            var tipoQuery=document.getElementById("tipoConsulta").value;
            var orden="";
            switch (tipoQuery) {
                case 'INSERT ':
                case 'DELETE ':
                case 'UPDATE ':
                    orden=consulta+tablas+valores;
                    break;
                case 'SELECT ':
                    orden=consulta+valores+tablas;
                    document.getElementById("tip2").innerHTML="Se puede agregar condicionamiento con WHERE";
                    break;
            }
            document.getElementById("query").innerHTML = orden;
        }
        function siguiente(pasoActual){
            var pasoAOcultar = document.getElementById("Paso"+pasoActual);
            
            pasoAOcultar.style.display="none";
            var pasoSiguiente=pasoActual+1;
            var pasoAMostrar = document.getElementById("Paso"+pasoSiguiente);
            pasoAMostrar.style.display="block";
        }
        function reiniciar(){
            document.getElementById("tipoConsulta").value="";
            document.getElementById("campos").value="";
            document.getElementById("tablas").value="";
            document.getElementById("arregloTablas").value="";
            document.getElementById("query").innerHTML="";
            document.getElementById("crearQuery").style.display="none";
            var campos = document.getElementsByClassName("campos");
            for(var indiceCampos=0;indiceCampos<campos.length;indiceCampos++){
                campos[indiceCampos].style.display="none";
            }
        }
        function filtrar(){
            var valorTablas =document.getElementById("arregloTablas").value;
            var tablasEscogidas= valorTablas.split(',');
            for(var indiceTablas=0;indiceTablas<tablasEscogidas.length;indiceTablas++){
                var tablaEscogida=tablasEscogidas[indiceTablas];
                if(tablaEscogida!=""){
                document.getElementById(tablaEscogida+"valores").style.display="block";
                }
            }
        }
        function abrir(pasoAMostrar){
            if(pasoAMostrar==1){
                reiniciar();//Si es paso uno borra todo
            }else if(pasoAMostrar==3){
                filtrar();
            }
            var pasos = document.getElementsByClassName("pasos");
            for(var i=0;i<pasos.length;i++){
                pasos[i].style.display="none";
            }
            var mostrar= document.getElementById("Paso"+pasoAMostrar);
            if(mostrar.style.display == "block"){
                mostrar.style.display="none";
            }else{
                mostrar.style.display="block";
            }
            
        }
        
        function agregarAFactura(numero,id){
            var modal;
            var span;
            if(id != -1){
                document.getElementById('id_agregar').value=id;
            }
            if(numero == 1){
                span = document.getElementsByClassName('close')[0];
                modal = document.getElementById('nuevaRefaccion');
                
            }else{
                var span = document.getElementsByClassName('close')[1];
                modal = document.getElementById('nuevoServicio');
            }
            modal.style.display = 'block';
            span.onclick = function(event){
               
                    modal.style.display = "none";
                
            }
            window.onclick = function(event){
                if(event.target == modal){
                    modal.style.display = "none";
                }
            }
        }
        
        function calculaTotal(){
            var totales= document.getElementsByClassName('totales');
            var sumaTotal=0;
            
            for(var i=0;i<totales.length;i++){
                var valorActual=totales[i].value;
                sumaTotal= (parseFloat(sumaTotal)+parseFloat(valorActual)).toFixed(2);
            }


            document.getElementById('granTotal').value=sumaTotal;
        }
        function agregarRefaccion(identificador,nombre,precio){
            var elemento= document.getElementById('id_agregar');
            var identificadorLocal=identificador;
            if(elemento != null){
                if(elemento.value != ""){
                identificador=elemento.value;
                elemento.value="";
                }
            }else{
                identificador='';
            }
            var refacciones=document.getElementById('refaccion'+identificador);
            refacciones.innerHTML = refacciones.innerHTML +
            "<div id='"+identificadorLocal+"' >"+
            "<table><tr>"+
            "<td rowspan='2'><input type='button' onclick='quitar(\""+identificadorLocal+"\")' value='Quitar'/>"+
            "<td>No. Refaccion</td>"+
            "<td>Nombre</td>"+
            "<td>Cantidad</td>"+
            "<td>Total</td>"+
            "</tr><tr> "+
            "<td><input type='text' value='"+identificadorLocal+"' /></td>"+
            "<td><input type='text' value='"+nombre+"' /></td>"+
            "<td><input type='text' value='1' name='cantidades[]' onchange='recalcula(this.value,"+precio+",\""+identificadorLocal+"\")' /></td>"+
            "<td><input type='text' class='totales' id='total"+identificadorLocal+"' value='"+precio+"' onchange='calculaTotal()' /></td>"+
            "</tr></table>"+
            "<input type='hidden' name='refacciones[]' value='"+identificadorLocal+"'/>";
             var modal = document.getElementById('nuevaRefaccion');
             modal.style.display="none";
            calculaTotal();
        }
        function agregarServicio(identificador,nombre,precio){
            var elemento= document.getElementById('id_agregar');
            var identificadorLocal=identificador;
            if(elemento != null){
                if(elemento.value != ""){
                identificador=elemento.value;
                elemento.value="";
                }
            }else{
                identificador='';
            }
            var servicios=document.getElementById('servicio'+identificador);
            
            servicios.innerHTML = servicios.innerHTML +
            "<div id='"+identificadorLocal+"' >"+
            "<table><tr>"+
            "<td rowspan='2'><input type='button' onclick='quitar(\""+identificadorLocal+"\")' value='Quitar'/>"+
            "<td>No. Servicio</td>"+
            "<td>Descripcion</td>"+
            "<td>Cantidad</td>"+
            "<td>Total</td>"+
            "</tr><tr> "+
            "<td><input type='text' value='"+identificadorLocal+"' /></td>"+
            "<td><input type='text' value='"+nombre+"' /></td>"+
            "<td><input type='text' value='1' name='cantidades2[]' onchange='recalcula(this.value,"+precio+",\""+identificadorLocal+"\")' /></td>"+
            "<td><input type='text' name='totales2[]' class='totales' id='total"+identificadorLocal+"' value='"+precio+"' onchange='calculaTotal()'/></td>"+
            "</tr></table>"+
            "<input type='hidden' name='servicios[]' value='"+identificadorLocal+"'/>";
            var modal = document.getElementById('nuevoServicio');
             modal.style.display="none";
            calculaTotal();
        }
        function recalcula(cantidad,valor,identificador){
            var total = document.getElementById('total'+identificador);
            var nuevoValor = valor;
            var nuevo = (cantidad*nuevoValor).toFixed(2);
            total.value=nuevo;
            calculaTotal();
            
        }
        
        function quitar(identificador){
            var total = document.getElementById('total'+identificador);
            var nuevoValor = document.getElementById('granTotal').value - total.value;
            document.getElementById('granTotal').value=nuevoValor;
            var elemento = document.getElementById(identificador);
            elemento.remove();
            calculaTotal();
        }
        function mostrar(id){
            var elemento=document.getElementById(id);
            if(id == "busqueda"){
             var filtro=document.getElementById('filtro');
                if (elemento.style.display=="block"){
                    filtro.innerHTML=" Filtrar v";
                
                }else{
                    filtro.innerHTML=" Filtrar ^";
                }
            }
            if (elemento.style.display=="block"){
                elemento.style.display="none";
                
            }else{
                elemento.style.display="block";
            }
            

        }
        function datosCliente(id){
            var elemento =document.getElementById("anterior");
            if(elemento.value !=""){
                var elementoBorrar = document.getElementById(elemento.value);
                elementoBorrar.style.display="none";
            }
            elemento.value=id;
            mostrar(id);
        }