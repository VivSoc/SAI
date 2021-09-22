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
        <script type="text/javascript" src="javascript/parametrizacion/inventario/colores.js"> </script>
    </head>
	
<div id="colores">
	<table width="700" align="center" class="tbldatos1">
<tr><td colspan="2" align="center" class="fondo_fila_amarilla">Parametrización de Colores</td>
   </tr>    
		<tr>
			<td width="80">Id del Color</td>
			<td><input type="text" id="id_color" name="id_color" maxlength="4" size="20" onChange="verificar_color('buscar');" onKeyPress="enter2tab(event,'des_color',0);return solo_numeros(event);" /> Formato: (1234)</td>
		</tr>
        <tr>
			<td width="80">Descripci&oacute;n</td>
			<td><input type="text" id="des_color" name="des_color" maxlength="30" size="100" onKeyPress="enter2tab(event,'color_guardar',0);"/></td>
		</tr>	
        <tr>
		<td width="100">Estatus</td>
		<td  align="left">
			<input type="radio" id="sta_color" name="sta_color" checked="checked" value="A" >Activo
		</td>
        </tr>
        <tr>
        <td>
        </td>
        <td>
			<input type="radio" id="sta_color" name="sta_color" value="I" );>Inactivo

		</td>
	</tr>
	</table>	
</div>
	
<br />
	
<table width="700" align="center" class="tbldatos1">	
	<tr>
		<td colspan="" align="center">
			<button type="button" id="color_primero" name="color_primero" onClick="verificar_color('primero');" style="width:30px; height:25px;"><img src="css/imagenes/primero.png"></button>
			<button type="button" id="color_anterior" name="color_anterior" onClick="verificar_color('anterior');" style="width:30px; height:25px;"><img src="css/imagenes/anterior.png"></button>
			<button type="button" id="color_siguiente" name="color_siguiente" onClick="verificar_color('siguiente');" style="width:30px; height:25px;"><img src="css/imagenes/siguiente.png"></button>
			<button type="button" id="color_ultimo" name="color_ultimo" onClick="verificar_color('ultimo');" style="width:30px; height:25px;"><img src="css/imagenes/ultimo.png"></button>
			<button type="reset" id="color_cancelar" name="color_cancelar" onClick="limpiar_color();" style="width:30px; height:25px;"><img src="css/imagenes/cancelar.png"></button>
			<button type="button" id="color_guardar" name="color_guardar" onClick="guardar_color();verificar_color('cancelar');" style="width:30px; height:25px;"><img src="css/imagenes/guardar.png"></button>
		</td>
	</tr>
</table>

<div id="color_guardar_datos"> </div>

<div id="mensaje"> </div>
</html>