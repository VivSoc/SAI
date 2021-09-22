<script type="text/javascript" src="js/modulos/sistemas/parametrizar/grupos/grupos.js"> </script>
<?php 
require("../../../../configuracion/config.php");
require("../../../../configuracion/conexion.php");
require("../../../../clases/funciones.php");
require("../../../../sesion.php");

$cuenta=@$_POST["cuenta_grupo"];

	$sql="select nomper,codinttom from maeregper a,maeregtom b where b.numcta='$cuenta' and a.codintper=b.codintper";
	
	$result10=pg_query($bd_conexion,$sql);
	if(pg_num_rows($result10)>0)
	{   $descripcion = pg_fetch_result($result10,0,"nomper");
	    $codinttom = pg_fetch_result($result10,0,"codinttom");
    	echo "<input type='hidden' value='$codinttom' name='toma' id='toma'>";
		
		$sql2="select descrip from grupos g,tomgru t where g.grupo=t.grupo and t.codinttom='$codinttom'";
		$result11=pg_query($bd_conexion,$sql2);
		$desc_grupo = @pg_fetch_result($result11,0,"descrip");
		if($desc_grupo=="")
		{
		  $desc_grupo="La cuenta no se encuenta asociada a ning&uacute;n grupo";
		  echo "<input type='hidden' value='N' name='grupo_actual_aux' id='grupo_actual_aux'>";
		}else
		{
		  echo "<input type='hidden' value='S' name='grupo_actual_aux' id='grupo_actual_aux'>";	
		}
		
		echo "<table width='700' align='center' class='tbldatos1'>	
		<tr>
		<td  width='18%'>Datos del Suscriptor:</td>
		<td><input type='text' value='$descripcion' readonly='true' size='100'></td>
		</tr>
		<tr>
		<td>Grupo Actual:</td>
		<td><input type='text' value='$desc_grupo' readonly='true' size='100' name='grupo_actual' id='grupo_actual'></td>
		</tr>
		</table>";
		
		echo '<table width="700" align="center" class="tbldatos1">	
	 <tr>
		<td colspan="" align="center">
<button type="reset" id="id_cancelar_bc" name="id_cancelar_bc" onclick="limpiar_pantalla();" style="width:30px; height:25px;"><img src="css/imagenes/cancelar.png"></button>
<button type="button" id="id_guardar_bc" name="id_guardar_bc" onclick="guardar_asignar_grupo();" style="width:30px; height:25px;"><img src="css/imagenes/guardar.png"></button>
		</td>
	</tr>
</table>
<div id="respuesta_grupos"></div>';
	
	}
	else
	{
		cuadro_mensaje2("La cuenta ".@$_REQUEST["cuenta_grupo"]." no existe");
	}

?>
