<?php 
require("../../../../configuracion/config.php");
require("../../../../configuracion/conexion.php");
require("../../../../clases/funciones.php");
require("../../../../sesion.php");
//var_dump(getcwd()); <-- esto es para ver la ruta
?>
<html>
	<head>
        <link rel="stylesheet" href="css/sweetalert.css" type="text/css">
        <script type="text/javascript" src="javascript/sweetalert.min.js"></script>
        <script type="text/javascript" src="javascript/parametrizacion/general/parroquias.js"> </script>
    </head>
    
<table width="700" align="center" class="tbldatos1">
<tr><td colspan="2" align="center" class="fondo_fila_amarilla">Parametrización de Parroquias</td>
   </tr>
	<tr>
		<td  width="120">Provincia</td>
		<td >
			<input type="text" id="id_provincia_p" name="id_provincia_p" size="10" maxlength="4" onKeyUp="CodigoToSelect(document.getElementById('id_provincia_p').value,document.getElementById('des_provincia_p'))" onKeyPress="enter2tab(event,'des_provincia_p',0); return solo_numeros(event);" />
			<select id="des_provincia_p" name="des_provincia_p" onChange="document.getElementById('id_provincia_p').value=document.getElementById('des_provincia_p').options[document.getElementById('des_provincia_p').selectedIndex].value; busca_cantones();" onkeypress="enter2tab(event,'id_canton',0);">
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
		
<div id="cantones">
	<table width="700" align="center" class="tbldatos1">
		<tr>
			<td  width="120">Cantón</td>
			<td >
				<input type="text" id="id_canton_p" name="id_canton_p" size="10" maxlength="4" onKeyUp="CodigoToSelect(document.getElementById('id_canton_p').value,document.getElementById('des_canton_p'));" onKeyPress="enter2tab(event,'des_canton_p',0); return solo_numeros(event);" />
				<select id="des_canton_p" name="des_canton_p" onChange="document.getElementById('id_canton_p').value=document.getElementById('des_canton_p').options[document.getElementById('des_canton_p').selectedIndex].value;" onkeypress="enter2tab(event,'sta_canton_p',0);">
					<option value="">Seleccione</option>
					<?php 
					var_dump("select * from cantones where id_provincia = '".$id_provincia_p."' order by id_canton");
					$result=pg_query($bd_conexion,"select * from cantones where id_provincia = '".$id_provincia_p."' order by id_canton");
					while ($registro=pg_fetch_assoc($result))
					{
						echo "<option value=\"".$registro["id_canton"]."\">".$registro["id_canton"]." - ".utf8($registro["des_canton"])."</option>";
					}
					?>
				</select>
			</td>
		</tr>
	</table>
</div>
	
<br />
	
<div id="parroquias">
	<table width="700" align="center" class="tbldatos1">  
		<tr>
			<td width="80">Id de la Parroquia</td>
			<td><input type="text" id="id_parroquia_p" name="id_parroquia_p" maxlength="4" size="20" onChange="verificar_parroquia('buscar');" onKeyPress="enter2tab(event,'des_parroquia_p',0);return solo_numeros(event);" /> Formato: (1234)</td>
		</tr>
        <tr>
			<td width="80">Descripci&oacute;n</td>
			<td><input type="text" id="des_parroquia_p" name="des_parroquia_p" maxlength="30" size="100" onKeyPress="enter2tab(event,'parroquia_guardar',0);"/></td>
		</tr>	
        <tr>
		<td width="100">Estatus</td>
		<td  align="left">
			<input type="radio" id="sta_parroquia_p" name="sta_parroquia_p" checked="checked" value="A" >Activo
		</td>
        </tr>
        <tr>
        <td>
        </td>
        <td>
			<input type="radio" id="sta_parroquia_p" name="sta_parroquia_p" value="I" );>Inactivo

		</td>
	</tr>
	</table>	
</div>
	
<br />
	
<table width="700" align="center" class="tbldatos1">	
	<tr>
		<td colspan="" align="center">
			<button type="button" id="parroquia_primero" name="parroquia_primero" onClick="verificar_parroquia('primero');" style="width:30px; height:25px;"><img src="css/imagenes/primero.png"></button>
			<button type="button" id="parroquia_anterior" name="parroquia_anterior" onClick="verificar_parroquia('anterior');" style="width:30px; height:25px;"><img src="css/imagenes/anterior.png"></button>
			<button type="button" id="parroquia_siguiente" name="parroquia_siguiente" onClick="verificar_parroquia('siguiente');" style="width:30px; height:25px;"><img src="css/imagenes/siguiente.png"></button>
			<button type="button" id="parroquia_ultimo" name="parroquia_ultimo" onClick="verificar_parroquia('ultimo');" style="width:30px; height:25px;"><img src="css/imagenes/ultimo.png"></button>
			<button type="reset" id="parroquia_cancelar" name="parroquia_cancelar" onClick="limpiar_parroquia();" style="width:30px; height:25px;"><img src="css/imagenes/cancelar.png"></button>
			<button type="button" id="parroquia_guardar" name="parroquia_guardar" onClick="guardar_parroquia();verificar_parroquia('cancelar');" style="width:30px; height:25px;"><img src="css/imagenes/guardar.png"></button>
		</td>
	</tr>
</table>

<div id="parroquia_guardar_datos"> </div>

<div id="mensaje"> </div>
</html>