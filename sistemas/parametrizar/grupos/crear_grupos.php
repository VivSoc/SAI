<?php 
require("../../../../configuracion/config.php");
require("../../../../configuracion/conexion.php");
require("../../../../clases/funciones.php");
require("../../../../sesion.php");
?>

<script type="text/javascript" src="js/modulos/sistemas/parametrizar/grupos/grupos.js"> </script>

<h3>Crear Grupo</h3>
	
<div id="par_grupos_codigos">
	<table width="700" align="center" class="tbldatos1">
		<tr>
			<td width="80">C&oacute;digo</td>
			<td>
				<input type="text" id="id_grupo" name="id_grupo"  maxlength="4" style="width:100px;" onkeypress="enter2tab(event,'id_descripcion',0);"/>
			</td>
		</tr>
		<tr>
			<td width="80">Descripci&oacute;n</td>
			<td>
				<input type="text" id="id_descripcion" name="id_descripcion" maxlength="100" style="width:550px;" onkeypress="enter2tab(event,'encargado',0);"/>
			</td>
		</tr>
        
        <tr>
			<td width="80">Encargado:</td>
			<td>
				<input type="text" id="encargado" name="encargado" maxlength="100" style="width:550px;" onkeypress="enter2tab(event,'cargo',0);"/>
			</td>
		</tr>
        
        <tr>
			<td width="80">Cargo:</td>
			<td>
				<input type="text" id="cargo" name="cargo" maxlength="100" style="width:550px;" onkeypress="enter2tab(event,'id_guardar',0);"/>
			</td>
		</tr>
	</table>	
</div>
	
<br />

<table width="700" align="center" class="tbldatos1">	
	<tr>
		<td colspan="" align="center">
<button type="reset" id="id_cancelar" name="id_cancelar" onclick="limpiar_grupo();" style="width:30px; height:25px;"><img src="css/imagenes/cancelar.png"></button>
<button type="button" id="id_guardar" name="id_guardar" onclick="guardar_grupo();" style="width:30px; height:25px;"><img src="css/imagenes/guardar.png"></button>
		</td>
	</tr>
</table>

<div id="id_grupos_guardar"> </div>

