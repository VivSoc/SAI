<html>
	<head>
        <link rel="stylesheet" href="css/sweetalert.css" type="text/css">
        <script type="text/javascript" src="javascript/sweetalert.min.js"></script>
    </head>
<?php 
require("../../../configuracion/config.php");
require("../../../configuracion/conexion.php");
require("../../../clases/funciones.php");
require("../../../sesion.php");

$sql = "SELECT 
			prinom, segnom, priape, segape, nomusu, cadpas, logemp, codcar,emausu,pas_syn
  		FROM 
  			pardefusu
  		where 
  			cedusu = '".@$_REQUEST['scu_cedusu']."'";
			
			

$result = pg_query($bd_conexion,$sql);
$cargo="";
?>

<script>mostrar_oficinas();</script>

<table width="700" class='tbldatos1'>
	<tr>
		<td width='100'>Primer Nombre</td>
		<td><input type='text' style="width:200px;" value='<?php if (pg_num_rows($result)>0) echo utf8(pg_fetch_result($result,0,"prinom")); ?>' name='scu_prinom' id='scu_prinom' maxlength='20' onKeyPress="enter2tab(event,'scu_segnom',0);"  /></td>
		<td width='130'>Segundo Nombre</td>
		<td><input type='text' style="width:200px;" value='<?php if (pg_num_rows($result)>0) echo utf8(pg_fetch_result($result,0,"segnom")); ?>' name='scu_segnom' id='scu_segnom' maxlength='20' onKeyPress="enter2tab(event,'scu_priape',0);"  /></td>
	</tr>
	<tr>
		<td width='100'>Primer Apellido</td>
		<td><input type='text'  style="width:200px;" value='<?php if (pg_num_rows($result)>0) echo utf8(pg_fetch_result($result,0,"priape")); ?>' name='scu_priape' id='scu_priape' maxlength='20' onKeyPress="enter2tab(event,'scu_segape',0);" /></td>
		<td width='130'>Segundo Apellido</td>
		<td><input type='text'  style="width:200px;" value='<?php if (pg_num_rows($result)>0) echo utf8(pg_fetch_result($result,0,"segape")); ?>' name='scu_segape' id='scu_segape' maxlength='20' onKeyPress="enter2tab(event,'scu_email',0);" /></td>
	</tr>
</table>

<table width="700" align="center" class="tbldatos1">
	<tr>
		<td width="100">E-Mail</td>
		<td><input type="text" id="scu_email" name="scu_email" style="width:565px;" value="<?php if(pg_num_rows($result)>0) echo pg_fetch_result($result,0,"emausu"); ?>" maxlength="60" onKeyPress="enter2tab(event,'scu_descar',0);"  /></td>
	</tr>
</table>

<?php if (pg_num_rows($result)>0) $cargo = pg_result($result,0,"codcar"); ?>

<table width="700" align="center" border="0" class="tbldatos1">
	<tr>
		<td width="100">Cargo</td>
		<td><select id="scu_descar" name="scu_descar" style="width:565px;" onKeyPress="enter2tab(event,'scu_usuario',0);">
			<option value="">Seleccione</option>
			<?php 
				$result2=pg_query($bd_conexion,"select id_tip_usuario, des_tip_usuario From tipos_usuarios where sta_tip_usuario='A' order by des_tip_usuario");
				while ($registro=pg_fetch_assoc($result2)){
					if ($registro["id_tip_usuario"] == $cargo)
						echo "<option value=\"".$registro["id_tip_usuario"]."\" selected=selected>".utf8(trim($registro["des_tip_usuario"]))."</option>";
					else
						echo "<option value=\"".$registro["id_tip_usuario"]."\">".utf8(trim($registro["des_tip_usuario"]))."</option>";
				}
			?>
		</select></td>
	</tr>
</table>
         
<br />

<table width="700" class='tbldatos1'>
	<tr>
		<td width='100'>Usuario</td>
		<td><input type='text' id='scu_usuario' name='scu_usuario' style="width:200px;" value='<?php if (pg_num_rows($result)>0) echo strtoupper(utf8(pg_fetch_result($result,0,"logemp"))); ?>' maxlength='20' onKeyPress="enter2tab(event,'scu_clave',0);" /></td>
		<td width='130'>Clave:</td>
		<td><input  id='scu_clave' type="password" name='scu_clave' style="width:200px;" maxlength='20' onKeyPress="enter2tab(event,'scu_guardar',0);"   value='<?php if (pg_num_rows($result)>0) echo utf8(pg_fetch_result($result,0,"pas_syn")); ?>' /></td>
	</tr>
	<tr>
		<td width="100">Estatus</td>
		<td  align="left">
			<input type="radio" id="scu_estatus" name="scu_estatus" value="N" <?php if (pg_num_rows($result)>0 && pg_fetch_result($result,0,"cadpas")=="N") echo "CHECKED"; ?>>Activo
			<input type="radio" id="scu_estatus" name="scu_estatus" value="S" <?php if (pg_num_rows($result)>0 && pg_fetch_result($result,0,"cadpas")=="S") echo "CHECKED"; ?>>Inactivo
		</td>
	</tr>
</table>

<br />

<div id="sis_creusu_oficinas"> </div>

<br />

<table width="700" align="center" class="tbldatos1">
	<tr>
        <td colspan="5" align="center">
		   	<button type="button" id="scu_cancelar" name="scu_cancelar" onClick="scu_limpiar();" style="width:30px; height:25px;"><img src="css/imagenes/cancelar.png"></button>
           	<button type="button" id="scu_guardar" name="scu_guardar" onClick="scu_guardar();" style="width:30px; height:25px;"><img src="css/imagenes/guardar.png"></button>
       	</td>
	</tr>
</table>

<div id="guardar_sis_creusu"></div>
</html>