<?php 
require("../../../../configuracion/config.php");
require("../../../../configuracion/conexion.php");
require("../../../../clases/funciones.php");
require("../../../../sesion.php");
?>

<html>
	<head>
        <link rel="stylesheet" href="css/sweetalert.css" type="text/css">
        <script type="text/javascript" src="javascript/sweetalert.min.js"></script>
        <script type="text/javascript" src="javascript/parametrizacion/general/cantones.js"> </script>
    </head>
	
<div id="cantones">
	<table width="700" align="center" class="tbldatos1">
<tr><td colspan="2" align="center" class="fondo_fila_amarilla">Parametización de Cantones</td>
   </tr>    
		<tr>
			<td  width="120">Provincia</td>
			<td >
				<input type="text" id="id_provincia_c" name="id_provincia_c" value="<?php echo @$_REQUEST["id_provincia_c"]; ?>" size="10" maxlength="4" onKeyUp="CodigoToSelect(document.getElementById('id_provincia_c').value,document.getElementById('des_provincia_c'))" onKeyPress="enter2tab(event,'id_canton_c',0); return solo_numeros(event);" />
				<select id="des_provincia_c"  name="des_provincia_c" onChange="document.getElementById('id_provincia_c').value=document.getElementById('des_provincia_c').options[document.getElementById('des_provincia_c').selectedIndex].value; " onkeypress="enter2tab(event,'id_canton_c',0);">
					<option value="">Seleccione</option>
					<?php 
					$result=pg_query($bd_conexion,"select * from provincias where sta_provincia='A' order by id_provincia");
					while ($registro=pg_fetch_assoc($result))
					{
						echo "<option value=\"".$registro["id_provincia"]."\">".$registro["id_provincia"]." - ".$registro["des_provincia"]."</option>";
					}
					?>
				</select>
			</td>
		</tr>
	</table>
	
	<br />
	
	<table width="700" align="center" class="tbldatos1">
		<tr>
			<td width="120">C&oacute;digo del Cantón</td>
			<td><input type="text" id="id_canton_c" name="id_canton_c"  maxlength="4" size="10" onChange="verificar_canton('buscar');" onKeyPress="enter2tab(event,'des_canton_c',0);"/></td>
		</tr>
		<tr>
			<td width="120">Nombre del Cantón</td>
			<td><input type="text" id="des_canton_c" name="des_canton_c" maxlength="50" size="100" onKeyPress="enter2tab(event,'sta_canton_c',0);"/></td>
		</tr>
		<tr>
		<td width="152">Estatus</td>
		<td  align="left">
			<input type="radio" id="sta_canton_c" name="sta_canton_c" checked="checked" value="A" >Activo

			<input type="radio" id="sta_canton_c" name="sta_canton_c" value="I" );>Inactivo
		</tr>
	</table>	
</div>
	
<br />
	
<table width="700" align="center" class="tbldatos1">	
	<tr>
		<td colspan="" align="center">
			<button type="button" id="canton_primero" name="canton_primero" onClick="verificar_canton('primero');" style="width:30px; height:25px;"><img src="css/imagenes/primero.png"></button>
			<button type="button" id="canton_anterior" name="canton_anterior" onClick="verificar_canton('anterior');" style="width:30px; height:25px;"><img src="css/imagenes/anterior.png"></button>
			<button type="button" id="canton_siguiente" name="canton_siguiente" onClick="verificar_canton('siguiente');" style="width:30px; height:25px;"><img src="css/imagenes/siguiente.png"></button>
			<button type="button" id="canton_ultimo" name="canton_ultimo" onClick="verificar_canton('ultimo');" style="width:30px; height:25px;"><img src="css/imagenes/ultimo.png"></button>
			<button type="reset" id="canton_cancelar" name="canton_cancelar" onClick="limpiar_canton();" style="width:30px; height:25px;"><img src="css/imagenes/cancelar.png"></button>
			<?php //if ($_SESSION["codacc"]["catasoges"]=="si"){ ?>
			<button type="button" id="canton_guardar" name="canton_guardar" onClick="guardar_canton();limpiar_canton();" style="width:30px; height:25px;"><img src="css/imagenes/guardar.png"></button>
			<?php //} ?>
		</td>
	</tr>
</table>

<div id="canton_guardar_datos"> </div>

<div id="mensaje"> </div>