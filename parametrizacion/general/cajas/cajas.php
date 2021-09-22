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
        <script type="text/javascript" src="javascript/parametrizacion/general/cajas.js"> </script>
    </head>
	
<div id="cajas">
	<table width="700" align="center" class="tbldatos1">
<tr><td colspan="2" align="center" class="fondo_fila_amarilla">Parametrización de Cajas</td>
   </tr>    
		<tr>
			<td width="80">Id de la caja</td>
			<td><input type="text" id="id_caja" name="id_caja" maxlength="4" size="20" onChange="verificar_caja('buscar');" onKeyPress="enter2tab(event,'des_caja',0);return solo_numeros(event);" /> Formato: (1234)</td>
		</tr>
        <tr>
			<td width="80">Descripci&oacute;n</td>
			<td><input type="text" id="des_caja" name="des_caja" maxlength="30" size="100" onKeyPress="enter2tab(event,'caja_guardar',0);"/></td>
		</tr>	
        <tr>
		<td width="100">Estatus</td>
		<td  align="left">
			<input type="radio" id="sta_caja" name="sta_caja" checked="checked" value="A" >Activo
		</td>
        </tr>
        <tr>
        <td>
        </td>
        <td>
			<input type="radio" id="sta_caja" name="sta_caja" value="I" );>Inactivo

		</td>
	</tr>
	</table>	
</div>
	
<br />
	
<table width="700" align="center" class="tbldatos1">	
	<tr>
		<td colspan="" align="center">
			<button type="button" id="caja_primero" name="caja_primero" onClick="verificar_caja('primero');" style="width:30px; height:25px;"><img src="css/imagenes/primero.png"></button>
			<button type="button" id="caja_anterior" name="caja_anterior" onClick="verificar_caja('anterior');" style="width:30px; height:25px;"><img src="css/imagenes/anterior.png"></button>
			<button type="button" id="caja_siguiente" name="caja_siguiente" onClick="verificar_caja('siguiente');" style="width:30px; height:25px;"><img src="css/imagenes/siguiente.png"></button>
			<button type="button" id="caja_ultimo" name="caja_ultimo" onClick="verificar_caja('ultimo');" style="width:30px; height:25px;"><img src="css/imagenes/ultimo.png"></button>
			<button type="reset" id="caja_cancelar" name="caja_cancelar" onClick="limpiar_caja();" style="width:30px; height:25px;"><img src="css/imagenes/cancelar.png"></button>
			<button type="button" id="caja_guardar" name="caja_guardar" onClick="guardar_caja();verificar_caja('cancelar');" style="width:30px; height:25px;"><img src="css/imagenes/guardar.png"></button>
		</td>
	</tr>
</table>

<div id="caja_guardar_datos"> </div>

<div id="mensaje"> </div>
</html>