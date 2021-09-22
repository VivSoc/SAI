<?php 
require("../../../../configuracion/config.php");
require("../../../../configuracion/conexion.php");
require("../../../../clases/funciones.php");
require("../../../../sesion.php");
?>

<script type="text/javascript" src="js/modulos/sistemas/parametrizar/par_tipordtra/par_tipordtra.js"> </script>

<h3>Tipos de Ordenes de Trabajo</h3>

<div id="par_tipordtra_codigos">
	<table width="700" align="center" class="tbldatos1">
		<tr>
			<td width="120">C&oacute;digo</td>
			<td>
				<input type="text"  name="sptot_codigo" maxlength="3" id="sptot_codigo" style="width:100px;" onChange="verificar_par_tipordtra('buscar');" onkeypress="enter2tab(event,'sptot_descripcion',0);"/>
			</td>
		</tr>
		<tr>
			<td width="120">Descripci&oacute;n</td>
			<td>
				<input type="text" name="sptot_descripcion" maxlength="100" id="sptot_descripcion" style="width:550px;" onkeypress="enter2tab(event,'sptot_tipord',0);"/>
			</td>
		</tr>
	</table>	


<table width="700" align="center" class="tbldatos1">
	<tr>
		<td class="tbldatos1" width="120">Refiere a</td>
		<td class="tbldatos1">
			<select id="sptot_tipord" name="sptot_tipord" style="width:200px;" onkeypress="enter2tab(event,'sptot_tiptra',0);">
				<option value="">Seleccione...</option>
				<option value="S">SOLICITUD DE SERVICIOS</option>
				<option value="Q">QUEJAS Y RECLAMOS</option>
				<option value="F">FACTIBILIDAD</option>
				<option value="I">INSTALACION DE NUEVA TOMA</option>
				<option value="C">CORTES</option>
				<option value="R">REINSTALACION</option>
			</select>
		</td>
	</tr>
</table>

<table width="700" align="center" class="tbldatos1">
	<tr>
		<td class="tbldatos1" width="120">Tipo de Trabajo</td>
		<td class="tbldatos1">
			<select id="sptot_tiptra" name="sptot_tiptra" style="width:200px;" onkeypress="enter2tab(event,'sptot_oritra',0);">
				<option value="">Seleccione...</option>
				<option value="D">DE CAMPO</option>
				<option value="I">INTERNA</option>
			</select>
		</td>
	</tr>
</table>

<table width="700" align="center" class="tbldatos1">
	<tr>
		<td class="tbldatos1" width="120">Origen de Trabajo</td>
		<td class="tbldatos1">
			<select id="sptot_oritra" name="sptot_oritra" style="width:200px;" onkeypress="enter2tab(event,'sptot_guardar',0);">
				<option value="">Seleccione...</option>
				<option value="I">INTERNA</option>
				<option value="E">EXTERNA</option>
			</select>
		</td>
	</tr>
</table>
</div>
	
<br />

<table width="700" align="center" class="tbldatos1">	
	<tr>
		<td colspan="" align="center">
			<button type="button" id="sptot_primero" name="sptot_primero" onclick="verificar_par_tipordtra('primero');" style="width:30px; height:25px;"><img src="css/imagenes/primero.png"></button>
			<button type="button" id="sptot_anterior" name="sptot_anterior" onclick="verificar_par_tipordtra('anterior');" style="width:30px; height:25px;"><img src="css/imagenes/anterior.png"></button>
			<button type="button" id="sptot_siguiente" name="sptot_siguiente" onclick="verificar_par_tipordtra('siguiente');" style="width:30px; height:25px;"><img src="css/imagenes/siguiente.png"></button>
			<button type="button" id="sptot_ultimo" name="sptot_ultimo" onclick="verificar_par_tipordtra('ultimo');" style="width:30px; height:25px;"><img src="css/imagenes/ultimo.png"></button>
			<button type="reset" id="sptot_cancelar" name="sptot_cancelar" onclick="limpiar_par_tipordtra()" style="width:30px; height:25px;"><img src="css/imagenes/cancelar.png"></button>
			<button type="button" id="sptot_guardar" name="sptot_guardar" onclick="guardar_par_tipordtra();" style="width:30px; height:25px;"><img src="css/imagenes/guardar.png"></button>
		</td>
	</tr>
</table>

<div id="par_tipordtra_guardar"> </div>

<div id="mensaje"> </div>


