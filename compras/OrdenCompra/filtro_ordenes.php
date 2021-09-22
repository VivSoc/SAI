<?php 
	require_once("../../../configuracion/config.php");
	require_once("../../../configuracion/conexion.php");
	require_once("../../../clases/funciones.php");
	require_once("../../../clases/utilidades.class.php");
	$sis_estilo="../../../".$sis_estilo;
?>
<html>
    <head> 
		<link rel="stylesheet" href="<?php echo $sis_estilo; ?>" type="text/css">

		<script type="text/javascript" src="js/jquery.js"></script>
		<script type="text/javascript" src="js/jquery-1.4.2.min.js"></script>
		<script type="text/javascript" src="js/jquery-ui-1.8.1.custom.min.js"></script>
		<script type="text/javascript" src="js/javascript.js"></script>
        <script type="text/javascript" src="javascript/compras/ordenescompras.js"></script>
		<script type="text/javascript" src="javascript/sweetalert.min.js"></script>
        <script type="text/javascript">document.getElementById('id_proveedor_odc').focus() </script>
        
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Ordenes de Compra></title>
    </head>
<table width="100%" align="center" class='tbldatos1'>
	<tr>
		<td colspan="4" align="center" class="fondo_fila_amarilla";>Registro Orden de Compras</td>
	</tr>  
    
    <tr>	
    	<td width="27%" align="right">Documento del Proveedor </td>
		<td width="23%" >
        <input type="text" id="id_proveedor_odc" name="id_proveedor_odc" maxlength="15" size="15" onKeyup="document.getElementById('id_proveedor_odc').value=document.getElementById('id_proveedor_odc').value.toUpperCase();"  onKeypress="enter2tab(event,'busca_proveedor_odc',0);"   />
				<i>( Formato: </i><font color="#CC0000"> <i> A12345678</i></font> ) 
        </td>
			
		<td colspan="2" width="50%" align="left">
				<button type="button" id="busca_proveedor_odc" name="busca_proveedor_odc" title="Buscar proveedor" onClick="buscar_proveedor_odc();" style="width:25px; height:25px;"><img src="css/imagenes/buscar.png"></button>
		</td>
    </tr>

</table>
<div id="datos_proveedor_odc" ></div>
<div id="precio_producto_odc"></div>
<div id="elimina_item_odc"></div>
<div id="guardar_ordencompra"></div>
<div id="cuerpo_der"></div>
</body>
</html>