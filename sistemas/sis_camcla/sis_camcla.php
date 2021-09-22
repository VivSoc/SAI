<?php 
require("../../../configuracion/config.php");
require("../../../configuracion/conexion.php");
require("../../../clases/funciones.php");
require("../../../sesion.php");
?>

<script type="text/javascript" src="js/modulos/sistemas/sis_camcla/sis_camcla.js"></script>

<h3>Cambio de Clave</h3>

<table width="700" class='tbldatos1'>
	<tr>
		<td width='130'>Inserte Clave</td>
		<td><input type='text' id='scc_clave1' name='scc_clave1' style="width:200px;" maxlength='20' onkeypress="enter2tab(event,'scc_guardar',0);" /></td>
		<td width='130'>Repita Clave</td>
		<td><input type='text' id='scc_clave2' name='scc_clave2' style="width:200px;" maxlength='20' onkeypress="enter2tab(event,'scc_guardar',0);" /></td>
	</tr>
</table>

<br />

<table width="700" align="center" class="tbldatos1">
	<tr>
        <td colspan="5" align="center">
		   	<button type="button" id="scc_cancelar" name="scc_cancelar" onclick="scc_limpiar();" style="width:30px; height:25px;"><img src="css/imagenes/cancelar.png"></button>
           	<button type="button" id="scc_guardar" name="scc_guardar" onclick="scc_guardar();" style="width:30px; height:25px;"><img src="css/imagenes/guardar.png"></button>
       	</td>
	</tr>
</table>

<div id="guardar_sis_camcla"></div>

<div id="mensaje"></div>