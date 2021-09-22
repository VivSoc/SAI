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
        <script type="text/javascript" src="javascript/parametrizacion/general/bancos.js"> </script>
    </head>
	
<div id="bancos">
	<table width="700" align="center" class="tbldatos1">
<tr><td colspan="2" align="center" class="fondo_fila_amarilla">Parametrización de Bancos</td>
   </tr>    
		<tr>
			<td width="80">Id del banco</td>
			<td><input type="text" id="id_banco" name="id_banco" maxlength="4" size="20" onChange="verificar_banco('buscar');" onKeyPress="enter2tab(event,'des_banco',0);return solo_numeros(event);" /> Formato: (1234)</td>
		</tr>
        <tr>
			<td width="80">Descripci&oacute;n</td>
			<td><input type="text" id="des_banco" name="des_banco" maxlength="200" size="100" onKeyPress="enter2tab(event,'banco_guardar',0);"/></td>
		</tr>	
        <tr>
		<td width="100">Estatus</td>
		<td  align="left">
			<input type="radio" id="sta_banco" name="sta_banco" checked="checked" value="A" >Activo
		</td>
        </tr>
        <tr>
        <td>
        </td>
        <td>
			<input type="radio" id="sta_banco" name="sta_banco" value="I" );>Inactivo

		</td>
	</tr>
	</table>	
</div>
	
<br />
	
<table width="700" align="center" class="tbldatos1">	
	<tr>
		<td colspan="" align="center">
			<button type="button" id="banco_primero" name="banco_primero" onClick="verificar_banco('primero');" style="width:30px; height:25px;"><img src="css/imagenes/primero.png"></button>
			<button type="button" id="banco_anterior" name="banco_anterior" onClick="verificar_banco('anterior');" style="width:30px; height:25px;"><img src="css/imagenes/anterior.png"></button>
			<button type="button" id="banco_siguiente" name="banco_siguiente" onClick="verificar_banco('siguiente');" style="width:30px; height:25px;"><img src="css/imagenes/siguiente.png"></button>
			<button type="button" id="banco_ultimo" name="banco_ultimo" onClick="verificar_banco('ultimo');" style="width:30px; height:25px;"><img src="css/imagenes/ultimo.png"></button>
			<button type="reset" id="banco_cancelar" name="banco_cancelar" onClick="limpiar_banco();" style="width:30px; height:25px;"><img src="css/imagenes/cancelar.png"></button>
			<button type="button" id="banco_guardar" name="banco_guardar" onClick="guardar_banco();verificar_banco('cancelar');" style="width:30px; height:25px;"><img src="css/imagenes/guardar.png"></button>
		</td>
	</tr>
</table>

<div id="banco_guardar_datos"> </div>

<div id="mensaje"> </div>
</html>