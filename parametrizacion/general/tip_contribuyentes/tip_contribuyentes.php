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
        <script type="text/javascript" src="javascript/parametrizacion/general/tip_contribuyentes.js"> </script>
    </head>
	
<div id="tip_contribuyentes">
	<table width="700" align="center" class="tbldatos1">
<tr><td colspan="2" align="center" class="fondo_fila_amarilla">Parametrización de Tipos de Contribuyentes</td>
   </tr>    
		<tr>
			<td width="80">Id del tipo de contribuyente</td>
			<td><input type="text" id="id_tip_contribuyente" name="id_tip_contribuyente" maxlength="4" size="20" onChange="verificar_tip_contribuyente('buscar');" onKeyPress="enter2tab(event,'des_tip_contribuyente',0);return solo_numeros(event);" /> Formato: (1234)</td>
		</tr>
        <tr>
			<td width="80">Descripci&oacute;n</td>
			<td><input type="text" id="des_tip_contribuyente" name="des_tip_contribuyente" maxlength="30" size="100" onKeyPress="enter2tab(event,'tip_contribuyente_guardar',0);"/></td>
		</tr>	
        <tr>
		<td width="100">Estatus</td>
		<td  align="left">
			<input type="radio" id="sta_tip_contribuyente" name="sta_tip_contribuyente" checked="checked" value="A" >Activo
		</td>
        </tr>
        <tr>
        <td>
        </td>
        <td>
			<input type="radio" id="sta_tip_contribuyente" name="sta_tip_contribuyente" value="I" );>Inactivo

		</td>
	</tr>
	</table>	
</div>
	
<br />
	
<table width="700" align="center" class="tbldatos1">	
	<tr>
		<td colspan="" align="center">
			<button type="button" id="tip_contribuyente_primero" name="tip_contribuyente_primero" onClick="verificar_tip_contribuyente('primero');" style="width:30px; height:25px;"><img src="css/imagenes/primero.png"></button>
			<button type="button" id="tip_contribuyente_anterior" name="tip_contribuyente_anterior" onClick="verificar_tip_contribuyente('anterior');" style="width:30px; height:25px;"><img src="css/imagenes/anterior.png"></button>
			<button type="button" id="tip_contribuyente_siguiente" name="tip_contribuyente_siguiente" onClick="verificar_tip_contribuyente('siguiente');" style="width:30px; height:25px;"><img src="css/imagenes/siguiente.png"></button>
			<button type="button" id="tip_contribuyente_ultimo" name="tip_contribuyente_ultimo" onClick="verificar_tip_contribuyente('ultimo');" style="width:30px; height:25px;"><img src="css/imagenes/ultimo.png"></button>
			<button type="reset" id="tip_contribuyente_cancelar" name="tip_contribuyente_cancelar" onClick="limpiar_tip_contribuyente();" style="width:30px; height:25px;"><img src="css/imagenes/cancelar.png"></button>
			<button type="button" id="tip_contribuyente_guardar" name="tip_contribuyente_guardar" onClick="guardar_tip_contribuyente();verificar_tip_contribuyente('cancelar');" style="width:30px; height:25px;"><img src="css/imagenes/guardar.png"></button>
		</td>
	</tr>
</table>

<div id="tip_contribuyente_guardar_datos"> </div>

<div id="mensaje"> </div>
</html>