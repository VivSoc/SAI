<?php 
	session_start();
	require("../../../configuracion/config.php");
	require("../../../configuracion/conexion.php");
	require("../../../clases/funciones.php");
	require("../../../clases/utilidades.class.php");
	echo"<script>document.getElementById('id_cliente').focus()</script>";
?>
<html>
    <head> 
		<link rel="stylesheet" href="<?php echo $sis_estilo; ?>" type="text/css">
        <link rel="stylesheet" href="css/sweetalert.css" type="text/css">
        <link rel="stylesheet" href="css/autocompletar.css" type="text/css">
		<script type="text/javascript" src="js/jquery.js"></script>
		<script type="text/javascript" src="js/jquery-1.4.2.min.js"></script>
		<script type="text/javascript" src="js/jquery-ui-1.8.1.custom.min.js"></script>
		<script type="text/javascript" src="js/javascript.js"></script>
        <script type="text/javascript" src="javascript/ventas/clientes.js"></script>
		<script type="text/javascript" src="js/sweetalert.min.js"></script>
        
      
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    </head>
    <table width="100%" align="center" class="tbldatos1">
	<tr>
		<td colspan="3" align="center" class="fondo_fila_amarilla";>Registro de Clientes</td>
	</tr>  
    <tr>	
    	<td width="27%" align="right">Documento del Cliente</td>
		<td width="23%" >
        <input type="text" id="id_cliente" name="id_cliente" maxlength="15" size="15" onKeyup="document.getElementById('id_cliente').value=document.getElementById('id_cliente').value.toUpperCase();"  onKeypress="enter2tab(event,'busca_cliente',0);"   />
				<i>( Formato: </i><font color="#CC0000"> <i> A12345678</font> )</i> 
        </td>
			
		<td colspan="2" width="50%" align="left">
				<button type="button" id="busca_cliente" name="busca_cliente" title="Buscar cliente" onClick="buscar_cliente();" style="width:25px; height:25px;"><img src="css/imagenes/buscar.png"></button>
		</td>
    </tr>
</table>
    
<div id="cuerpo_datos_clientes"></div>
</body>
</html>