<?php 
	session_start();
	require("../../../configuracion/config.php");
	require("../../../configuracion/conexion.php");
	require("../../../clases/funciones.php");
	require("../../../clases/utilidades.class.php");
	echo"<script>document.getElementById('par_id_proveedor').focus()</script>";
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
        <script type="text/javascript" src="javascript/compras/proveedores.js"></script>
		<script type="text/javascript" src="js/sweetalert.min.js"></script>
        
      
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    </head>
    <table width="100%" align="center" class="tbldatos1">
	<tr>
		<td colspan="3" align="center" class="fondo_fila_amarilla";>Registro de Proveedores</td>
	</tr>  
    <tr>	
    	<td width="27%" align="right">Documento del Proveedor</td>
		<td width="23%" >
        <input type="text" id="par_id_proveedor" name="par_id_proveedor" maxlength="15" size="15" onKeyup="document.getElementById('par_id_proveedor').value=document.getElementById('par_id_proveedor').value.toUpperCase();"  onKeypress="enter2tab(event,'par_busca_proveedor',0);"   />
				<i>( Formato: </i><font color="#CC0000"> <i> A12345678</i></font> ) 
        </td>
			
		<td colspan="2" width="50%" align="left">
				<button type="button" id="par_busca_proveedor" name="par_busca_proveedor" title="Buscar proveedor" onClick="par_buscar_proveedor();" style="width:25px; height:25px;"><img src="css/imagenes/buscar.png"></button>
		</td>
    </tr>
</table>
    
<div id="par_cuerpo_datos_proveedores"></div>
</body>
</html>