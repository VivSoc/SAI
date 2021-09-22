<?php 
require("../../../../configuracion/config.php");
require("../../../../configuracion/conexion.php");
require("../../../../clases/funciones.php");
require("../../../../sesion.php");
?>

<script type="text/javascript" src="js/modulos/sistemas/parametrizar/grupos/grupos.js"> </script>

<h3>Asignar Cuenta a Grupo</h3>
	
	<table width="700" align="center" class="tbldatos1">
		<tr>
			<td width="120">C&oacute;digo del Grupo:</td>
			<td>
				<input type="text" id="id_asignar_grupo" name="id_asignar_grupo"  maxlength="4" style="width:100px;" onkeypress="enter2tab(event,'boton_grupo',0);" onblur="buscar_grupo();"/>
   <input type="button" onclick="buscar_grupo();"  value="Buscar Grupo" name="boton_grupo" id="boton_grupo">
            </td>
		</tr>
	</table>	
<div id="id_grupos_asignar_guardar"> </div>	
<br />





