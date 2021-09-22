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
        <script type="text/javascript" src="javascript/parametrizacion/general/formas_pago.js"> </script>
    </head>
	
<div id="formas_pago">
	<table width="700" align="center" class="tbldatos1">
<tr><td colspan="2" align="center" class="fondo_fila_amarilla">Parametrización de formas de Pago</td>
   </tr>    
		<tr>
			<td width="80">Id de la forma de pago</td>
			<td><input type="text" id="id_formas_pago" name="id_formas_pago" maxlength="4" size="20" onChange="verificar_formas_pago('buscar');" onKeyPress="enter2tab(event,'des_formas_pago',0);return solo_numeros(event);" /> Formato: (1234)</td>
		</tr>
        <tr>
			<td width="80">Descripci&oacute;n</td>
			<td><input type="text" id="des_formas_pago" name="des_formas_pago" maxlength="30" size="100" onKeyPress="enter2tab(event,'formas_pago_guardar',0);"/></td>
		</tr>	
        <tr>
		<td width="100">Estatus</td>
		<td  align="left">
			<input type="radio" id="sta_formas_pago" name="sta_formas_pago" checked="checked" value="A" >Activo
		</td>
        </tr>
        <tr>
        <td>
        </td>
        <td>
			<input type="radio" id="sta_formas_pago" name="sta_formas_pago" value="I" );>Inactivo

		</td>
	</tr>
	</table>	
</div>
	
<br />
	
<table width="700" align="center" class="tbldatos1">	
	<tr>
		<td colspan="" align="center">
			<button type="button" id="formas_pago_primero" name="formas_pago_primero" onClick="verificar_formas_pago('primero');" style="width:30px; height:25px;"><img src="css/imagenes/primero.png"></button>
			<button type="button" id="formas_pago_anterior" name="formas_pago_anterior" onClick="verificar_formas_pago('anterior');" style="width:30px; height:25px;"><img src="css/imagenes/anterior.png"></button>
			<button type="button" id="formas_pago_siguiente" name="formas_pago_siguiente" onClick="verificar_formas_pago('siguiente');" style="width:30px; height:25px;"><img src="css/imagenes/siguiente.png"></button>
			<button type="button" id="formas_pago_ultimo" name="formas_pago_ultimo" onClick="verificar_formas_pago('ultimo');" style="width:30px; height:25px;"><img src="css/imagenes/ultimo.png"></button>
			<button type="reset" id="formas_pago_cancelar" name="formas_pago_cancelar" onClick="limpiar_formas_pago();" style="width:30px; height:25px;"><img src="css/imagenes/cancelar.png"></button>
			<button type="button" id="formas_pago_guardar" name="formas_pago_guardar" onClick="guardar_formas_pago();verificar_formas_pago('cancelar');" style="width:30px; height:25px;"><img src="css/imagenes/guardar.png"></button>
		</td>
	</tr>
</table>

<div id="formas_pago_guardar_datos"> </div>

<div id="mensaje"> </div>
</html>