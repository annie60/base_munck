<html>
    <title>Reporte de facturas</title>
    <link rel="stylesheet" href="css/munck.css" type="text/css" />
    <body>
<div class="bar">

  
    <div class="dropdown">
         <button class="dropbtn">Altas</button>
     <div id="altas" class="dropdown-content">
        <a href="alta_servicio.php" target="pages" >Alta de servicio</a>
        <a href="alta_refaccion.php" target="pages" >Alta de refaccion</a>
        <a href="alta_cliente.php" target="pages">Alta de cliente</a>
     </div>
     </div>
    <div class="dropdown">
        <a href="alta_factura.php" target="pages" class="dropbtn">Nueva factura</a>
     </div>
    <div class="dropdown">
        <a href="alta_orden.php" target="pages" class="dropbtn">Nueva orden de compra</a>
     </div>
     <div class="dropdown">
         <button class="dropbtn">Consultas</button>
     <div id="consultas" class="dropdown-content">
        <a href="consulta.php" target="pages">Consulta manual</a>
        <a href="consulta_factura.php" target="pages">Consulta facturas</a>
        <a href="consulta_ordenes.php" target="pages">Consulta ordenes de compra</a>
     </div>
     </div>

</div>
<iframe name="pages" src="consulta_factura.php" frameborder="0" width="100%" height="80%"></iframe>
</body>
</html>