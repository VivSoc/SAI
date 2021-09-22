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
        <script type="text/javascript" src="javascript/parametrizacion/general/provincias.js"> </script>
    </head>
	
<div id="provincias">
	<table width="700" align="center" class="tbldatos1">
<tr><td colspan="2" align="center" class="fondo_fila_amarilla">Parametrización de Provincias</td>
   </tr>    
		<tr>
			<td width="80">Id de la Provincia</td>
			<td><input type="text" id="id_provincia" name="id_provincia" maxlength="4" size="20" onChange="verificar_provincia('buscar');" onKeyPress="enter2tab(event,'des_provincia',0);return solo_numeros(event);" /> Formato: (1234)</td>
		</tr>
        <tr>
			<td width="80">Descripci&oacute;n</td>
			<td><input type="text" id="des_provincia" name="des_provincia" maxlength="30" size="100" onKeyPress="enter2tab(event,'provincia_guardar',0);"/></td>
		</tr>	
        <tr>
		<td width="100">Estatus</td>
		<td  align="left">
			<input type="radio" id="sta_provincia" name="sta_provincia" checked="checked" value="A" >Activo
		</td>
        </tr>
        <tr>
        <td>
        </td>
        <td>
			<input type="radio" id="sta_provincia" name="sta_provincia" value="I" );>Inactivo

		</td>
	</tr>
	</table>	
</div>
	
<br />
	
<table width="700" align="center" class="tbldatos1">	
	<tr>
		<td colspan="" align="center">
			<button type="button" id="provincia_primero" name="provincia_primero" onClick="verificar_provincia('primero');" style="width:30px; height:25px;"><img src="css/imagenes/primero.png"></button>
			<button type="button" id="provincia_anterior" name="provincia_anterior" onClick="verificar_provincia('anterior');" style="width:30px; height:25px;"><img src="css/imagenes/anterior.png"></button>
			<button type="button" id="provincia_siguiente" name="provincia_siguiente" onClick="verificar_provincia('siguiente');" style="width:30px; height:25px;"><img src="css/imagenes/siguiente.png"></button>
			<button type="button" id="provincia_ultimo" name="provincia_ultimo" onClick="verificar_provincia('ultimo');" style="width:30px; height:25px;"><img src="css/imagenes/ultimo.png"></button>
			<button type="reset" id="provincia_cancelar" name="provincia_cancelar" onClick="limpiar_provincia();" style="width:30px; height:25px;"><img src="css/imagenes/cancelar.png"></button>
			<button type="button" id="provincia_guardar" name="provincia_guardar" onClick="guardar_provincia();verificar_provincia('cancelar');" style="width:30px; height:25px;"><img src="css/imagenes/guardar.png"></button>
		</td>
	</tr>
</table>

<div id="provincia_guardar_datos"> </div>

<div id="mensaje"> </div>
</html>