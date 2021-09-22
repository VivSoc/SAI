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
        <script type="text/javascript" src="javascript/parametrizacion/inventario/modelos.js"> </script>
    </head>
	
<div id="modelos">
	<table width="700" align="center" class="tbldatos1">
<tr><td colspan="2" align="center" class="fondo_fila_amarilla">Parametrización de Modelos</td>
   </tr>    
		<tr>
			<td width="80">Id del Modelo</td>
			<td><input type="text" id="id_modelo" name="id_modelo" maxlength="4" size="20" onChange="verificar_modelo('buscar');" onKeyPress="enter2tab(event,'des_modelo',0);return solo_numeros(event);" /> Formato: (1234)</td>
		</tr>
        <tr>
			<td width="80">Descripci&oacute;n</td>
			<td><input type="text" id="des_modelo" name="des_modelo" maxlength="30" size="100" onKeyPress="enter2tab(event,'modelo_guardar',0);"/></td>
		</tr>	
        <tr>
		<td width="100">Estatus</td>
		<td  align="left">
			<input type="radio" id="sta_modelo" name="sta_modelo" checked="checked" value="A" >Activo
		</td>
        </tr>
        <tr>
        <td>
        </td>
        <td>
			<input type="radio" id="sta_modelo" name="sta_modelo" value="I" );>Inactivo

		</td>
	</tr>
	</table>	
</div>
	
<br />
	
<table width="700" align="center" class="tbldatos1">	
	<tr>
		<td colspan="" align="center">
			<button type="button" id="modelo_primero" name="modelo_primero" onClick="verificar_modelo('primero');" style="width:30px; height:25px;"><img src="css/imagenes/primero.png"></button>
			<button type="button" id="modelo_anterior" name="modelo_anterior" onClick="verificar_modelo('anterior');" style="width:30px; height:25px;"><img src="css/imagenes/anterior.png"></button>
			<button type="button" id="modelo_siguiente" name="modelo_siguiente" onClick="verificar_modelo('siguiente');" style="width:30px; height:25px;"><img src="css/imagenes/siguiente.png"></button>
			<button type="button" id="modelo_ultimo" name="modelo_ultimo" onClick="verificar_modelo('ultimo');" style="width:30px; height:25px;"><img src="css/imagenes/ultimo.png"></button>
			<button type="reset" id="modelo_cancelar" name="modelo_cancelar" onClick="limpiar_modelo();" style="width:30px; height:25px;"><img src="css/imagenes/cancelar.png"></button>
			<button type="button" id="modelo_guardar" name="modelo_guardar" onClick="guardar_modelo();verificar_modelo('cancelar');" style="width:30px; height:25px;"><img src="css/imagenes/guardar.png"></button>
		</td>
	</tr>
</table>

<div id="modelo_guardar_datos"> </div>

<div id="mensaje"> </div>
</html>