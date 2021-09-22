<?php 
require("../../../../configuracion/config.php");
require("../../../../configuracion/conexion.php");
require("../../../../clases/funciones.php");
require("../../../../sesion.php");
?>

<script type="text/javascript" src="js/modulos/sistemas/parametrizar/grupos/grupos.js"> </script>

<h3>Crear Grupo</h3>
	

	<table width="700" align="center" class="tbldatos1">
		<tr>
			<td width="80">C&oacute;digo</td>
			<td>
				<input type="text" id="id_grupo" name="id_grupo"  maxlength="4" style="width:100px;" enter2tab(event,'buscar',0); onkeyUp="enter2tab(event,'buscar',0);"/>
                <input   type="button" name="buscar" id='buscar' onclick="editar_grupo()" value="Buscar Grupo" />
			</td>
		</tr>
        <tr>
        <td colspan="2">
		<div id="datos_grupo"> 
        
        </div>
        </td>
        </tr>
	</table>	

	
<br />

<table width="700" align="center" class="tbldatos1">	
	<tr>
		<td colspan="" align="center">
<button type="reset" id="id_cancelar" name="id_cancelar" onclick="limpiar_grupo();" style="width:30px; height:25px;"><img src="css/imagenes/cancelar.png"></button>
<button type="button" id="id_guardar" name="id_guardar" onclick="guardar_grupo();" style="width:30px; height:25px;"><img src="css/imagenes/guardar.png"></button>
		</td>
	</tr>
</table>

<div id="id_grupos_guardar"></div>

