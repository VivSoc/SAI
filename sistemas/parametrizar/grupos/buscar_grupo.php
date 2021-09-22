<?php 
require("../../../../configuracion/config.php");
require("../../../../configuracion/conexion.php");
require("../../../../clases/funciones.php");
require("../../../../sesion.php");

	$sql="select grupo,descrip from grupos where grupo = '".@$_REQUEST["id_asignar_grupo"]."'";
	$result10=pg_query($bd_conexion,$sql);
	if(pg_num_rows($result10)>0)
	{
		
		$descripcion = pg_fetch_result($result10,0,"descrip");
		echo "<table width='700' align='center' class='tbldatos1'>	
		<tr>
		<td  width='18%'>Descripci&oacute;n:</td>
		<td><input type='text' value='$descripcion' readonly='true' size='100' name='descrip_grupo' id='descrip_grupo'></td>
		</tr>
		<tr>
		<td  width='18%'>N&uacute;mero de Cuenta:</td>
		<td><input type='text'  name='cuenta_grupo' id='cuenta_grupo' size='20' maxlength='20'><input type='button' onclick='buscar_cuenta();'  value='Buscar Cuenta' ></td>
		</tr>
		</table>
		<div id='id_cuenta_asignar'> </div>";
	
	}
	else
	{
		cuadro_mensaje2("El Grupo ".@$_REQUEST["id_asignar_grupo"]." no existe");
	}

?>
