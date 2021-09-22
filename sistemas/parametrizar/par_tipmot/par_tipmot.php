<?php 
require("../../../../configuracion/config.php");
require("../../../../configuracion/conexion.php");
require("../../../../clases/funciones.php");
require("../../../../sesion.php");
?>

<script type="text/javascript" src="js/modulos/sistemas/parametrizar/par_tipmot/par_tipmot.js"> </script>

<h3>Tipos de Motivos</h3>
	
<div id="par_tipmot_codigos">
	<table width="700" align="center" class="tbldatos1">
		<tr>
			<td width="80">C&oacute;digo</td>
			<td>
				<input type="text" id="sptm_codigo" name="sptm_codigo"  maxlength="3" style="width:100px;" onchange="verificar_par_tipmot('buscar');" onkeypress="enter2tab(event,'sptm_descripcion',0);"/>
			</td>
		</tr>
		<tr>
			<td width="80">Descripci&oacute;n</td>
			<td>
				<input type="text" id="sptm_descripcion" name="sptm_descripcion" maxlength="100" style="width:550px;" onkeypress="enter2tab(event,'sptm_guardar',0);"/>
			</td>
		</tr>
	</table>	
</div>
	
<br />

<table width="700" align="center" class="tbldatos1">	
	<tr>
		<td colspan="" align="center">
			<button type="button" id="sptm_primero" name="sptm_primero" onclick="verificar_par_tipmot('primero');" style="width:30px; height:25px;"><img src="css/imagenes/primero.png"></button>
			<button type="button" id="sptm_anterior" name="sptm_anterior" onclick="verificar_par_tipmot('anterior');" style="width:30px; height:25px;"><img src="css/imagenes/anterior.png"></button>
			<button type="button" id="sptm_siguiente" name="sptm_siguiente" onclick="verificar_par_tipmot('siguiente');" style="width:30px; height:25px;"><img src="css/imagenes/siguiente.png"></button>
			<button type="button" id="sptm_ultimo" name="sptm_ultimo" onclick="verificar_par_tipmot('ultimo');" style="width:30px; height:25px;"><img src="css/imagenes/ultimo.png"></button>
			<button type="reset" id="sptm_cancelar" name="sptm_cancelar" onclick="limpiar_par_tipmot();" style="width:30px; height:25px;"><img src="css/imagenes/cancelar.png"></button>
			<button type="button" id="sptm_guardar" name="sptm_guardar" onclick="guardar_par_tipmot();verificar_par_tipmot('cancelar');" style="width:30px; height:25px;"><img src="css/imagenes/guardar.png"></button>
		</td>
	</tr>
</table>

<div id="par_tipmot_guardar"> </div>

<div id="mensaje"> </div>
