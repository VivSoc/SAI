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
        <script type="text/javascript" src="javascript/parametrizacion/inventario/formas.js"> </script>
    </head>
	
<div id="formas">
	<table width="700" align="center" class="tbldatos1">
<tr><td colspan="2" align="center" class="fondo_fila_amarilla">Parametrización de Formas</td>
   </tr>    
		<tr>
			<td width="80">Id de la forma</td>
			<td><input type="text" id="id_forma" name="id_forma" maxlength="4" size="20" onChange="verificar_forma('buscar');" onKeyPress="enter2tab(event,'des_forma',0);return solo_numeros(event);" /> Formato: (1234)</td>
		</tr>
        <tr>
			<td width="80">Descripci&oacute;n</td>
			<td><input type="text" id="des_forma" name="des_forma" maxlength="30" size="100" onKeyPress="enter2tab(event,'forma_guardar',0);"/></td>
		</tr>	
        <tr>
		<td width="100">Estatus</td>
		<td  align="left">
			<input type="radio" id="sta_forma" name="sta_forma" checked="checked" value="A" >Activo
		</td>
        </tr>
        <tr>
        <td>
        </td>
        <td>
			<input type="radio" id="sta_forma" name="sta_forma" value="I" );>Inactivo

		</td>
	</tr>
	</table>	
</div>
	
<br />
	
<table width="700" align="center" class="tbldatos1">	
	<tr>
		<td colspan="" align="center">
			<button type="button" id="forma_primero" name="forma_primero" onClick="verificar_forma('primero');" style="width:30px; height:25px;"><img src="css/imagenes/primero.png"></button>
			<button type="button" id="forma_anterior" name="forma_anterior" onClick="verificar_forma('anterior');" style="width:30px; height:25px;"><img src="css/imagenes/anterior.png"></button>
			<button type="button" id="forma_siguiente" name="forma_siguiente" onClick="verificar_forma('siguiente');" style="width:30px; height:25px;"><img src="css/imagenes/siguiente.png"></button>
			<button type="button" id="forma_ultimo" name="forma_ultimo" onClick="verificar_forma('ultimo');" style="width:30px; height:25px;"><img src="css/imagenes/ultimo.png"></button>
			<button type="reset" id="forma_cancelar" name="forma_cancelar" onClick="limpiar_forma();" style="width:30px; height:25px;"><img src="css/imagenes/cancelar.png"></button>
			<button type="button" id="forma_guardar" name="forma_guardar" onClick="guardar_forma();verificar_forma('cancelar');" style="width:30px; height:25px;"><img src="css/imagenes/guardar.png"></button>
		</td>
	</tr>
</table>

<div id="forma_guardar_datos"> </div>

<div id="mensaje"> </div>
</html>