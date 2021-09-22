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
        <script type="text/javascript" src="javascript/parametrizacion/inventario/origenes.js"> </script>
    </head>
	
<div id="origenes">
	<table width="700" align="center" class="tbldatos1">
<tr><td colspan="2" align="center" class="fondo_fila_amarilla">Parametrización de Origenes</td>
   </tr>    
		<tr>
			<td width="80">Id del origen</td>
			<td><input type="text" id="id_origen" name="id_origen" maxlength="4" size="20" onChange="verificar_origen('buscar');" onKeyPress="enter2tab(event,'des_origen',0);return solo_numeros(event);" /> Formato: (1234)</td>
		</tr>
        <tr>
			<td width="80">Descripci&oacute;n</td>
			<td><input type="text" id="des_origen" name="des_origen" maxlength="30" size="100" onKeyPress="enter2tab(event,'origen_guardar',0);"/></td>
		</tr>	
        <tr>
		<td width="100">Estatus</td>
		<td  align="left">
			<input type="radio" id="sta_origen" name="sta_origen" checked="checked" value="A" >Activo
		</td>
        </tr>
        <tr>
        <td>
        </td>
        <td>
			<input type="radio" id="sta_origen" name="sta_origen" value="I" );>Inactivo

		</td>
	</tr>
	</table>	
</div>
	
<br />
	
<table width="700" align="center" class="tbldatos1">	
	<tr>
		<td colspan="" align="center">
			<button type="button" id="origen_primero" name="origen_primero" onClick="verificar_origen('primero');" style="width:30px; height:25px;"><img src="css/imagenes/primero.png"></button>
			<button type="button" id="origen_anterior" name="origen_anterior" onClick="verificar_origen('anterior');" style="width:30px; height:25px;"><img src="css/imagenes/anterior.png"></button>
			<button type="button" id="origen_siguiente" name="origen_siguiente" onClick="verificar_origen('siguiente');" style="width:30px; height:25px;"><img src="css/imagenes/siguiente.png"></button>
			<button type="button" id="origen_ultimo" name="origen_ultimo" onClick="verificar_origen('ultimo');" style="width:30px; height:25px;"><img src="css/imagenes/ultimo.png"></button>
			<button type="reset" id="origen_cancelar" name="origen_cancelar" onClick="limpiar_origen();" style="width:30px; height:25px;"><img src="css/imagenes/cancelar.png"></button>
			<button type="button" id="origen_guardar" name="origen_guardar" onClick="guardar_origen();verificar_origen('cancelar');" style="width:30px; height:25px;"><img src="css/imagenes/guardar.png"></button>
		</td>
	</tr>
</table>

<div id="origen_guardar_datos"> </div>

<div id="mensaje"> </div>
</html>