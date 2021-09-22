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
		<link rel="stylesheet" href="css/autocompletar.css" type="text/css">

		<script type="text/javascript" src="js/jquery.js"></script>
		<script type="text/javascript" src="js/jquery-1.4.2.min.js"></script>
		<script type="text/javascript" src="js/jquery-ui-1.8.1.custom.min.js"></script>
		<script type="text/javascript" src="js/javascript.js"></script>
        <script type="text/javascript" src="javascript/compras/cuentaspagar.js"></script>
		<script type="text/javascript" src="javascript/sweetalert.min.js"></script>
        <script type="text/javascript">document.getElementById('id_proveedor_cxp').focus() </script>
        
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Registro de Compras></title>
    </head>
<table width="100%" align="center" class='tbldatos1'>
	<tr>
		<td colspan="4" align="center" class="fondo_fila_amarilla";>Cuentas por Pagar</td>
	</tr>  
    
    <tr>	
    	<td width="27%" align="right">Documento del Proveedor </td>
		<td width="23%" ><div class="input_container">
        <input type="text" id="id_proveedor_cxp" name="id_proveedor_cxp" maxlength="15" size="15" onKeyup="document.getElementById('id_proveedor_cxp').value=document.getElementById('id_proveedor_cxp').value.toUpperCase();autocompletar_cxp();"  onKeypress="enter2tab(event,'busca_proveedor_cxp',0);" value="" />
				<i>( Formato: </i><font color="#CC0000"> <i> A12345678</i></font> )
          <ul id="lista_id"></ul>
		    </div> 
        </td>
			
		<td colspan="2" width="50%" align="left">
				<button type="button" id="busca_proveedor_cxp" name="busca_proveedor_cxp" title="Buscar proveedor" onClick="buscar_proveedor_cxp();" style="width:25px; height:25px;"><img src="css/imagenes/buscar.png"></button>
		</td>
    </tr>

</table>
<div id="cuerpo_datos_proveedor_cxp" ></div>
<div id="cuerpo_detalle_cuentasxpagar"></div>
<div id="guardar_cuentasxpagar"></div>
</body>
</html>