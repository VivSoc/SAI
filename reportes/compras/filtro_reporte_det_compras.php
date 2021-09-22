<?php 
require("../../configuracion/config.php");
require("../../configuracion/conexion.php");
require("../../clases/funciones.php");
require("../../clases/utilidades.class.php");
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
		<script type="text/javascript" src="javascript/sweetalert.min.js"></script>
		<script type="text/javascript" src="javascript/compras/reportes_compras.js"> </script>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Reportes de Compras></title>
    </head>


<table class="tbldatos1" width="100%" align="center">
<tr>
	<td colspan="6" align="center" class="fondo_fila_amarilla">Rango de Fechas</td>
</tr>
	
    <tr>
		<td width="10%" align="right">Desde:</td>
        <td width="10%">
		<input type="text" id="rep_comp_fecdes" name="rep_comp_fecdes" size="10" maxlength="10" value="<?php echo date("d/m/Y"); ?>" onKeyPress="enter2tab(event,'rep_comp_fechas',0);" style="font-size:14px; height:25"> </td>

		<td width="10%" align="right">Hasta:</td>
		<td width="20%"><input type="text" id="rep_comp_fechas" name="rep_comp_fechas" size="10" maxlength="10" value="<?php echo date("d/m/Y"); ?>" onKeyPress="enter2tab(event,'rep_comp_id_proveedor',0);" style="font-size:14px; height:25"></td>
        <td width="12%">Documento Proveedor:</td>
		<td width="38%" align="left"><div class="input_container">
        <input type="text" id="rep_comp_id_proveedor" name="rep_comp_id_proveedor" maxlength="30" size="30" onKeyup="document.getElementById('rep_comp_id_proveedor').value=document.getElementById('rep_comp_id_proveedor').value.toUpperCase(); auto_rep_det_comp();"  onKeypress="enter2tab(event,'gen_rep_compras',0);"/>
        <ul id="lista_id"></ul>
            </div>
		</td>
	</tr>	
	
</table>

<br />
<table width="100%" align="center" class="tbldatos1">	
	<tr>
		<td align="center">
    <button type="button" id="gen_rep_compras" name="gen_rep_compras" title="Generar reporte" onClick="imprimir_rep_det_compras();" style="width:60px; height:55px;border-radius: 12px;"><img src="css/imagenes/iconos/imprimir.png"></button>
		</td>
	</tr>
</table>


</html>