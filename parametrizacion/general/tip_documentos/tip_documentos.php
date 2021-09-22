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
        <script type="text/javascript" src="javascript/parametrizacion/general/tip_documentos.js"> </script>
    </head>
	
<div id="tip_documentos">
	<table width="700" align="center" class="tbldatos1">
<tr><td colspan="2" align="center" class="fondo_fila_amarilla">Parametrización de Tipos de Documentos</td>
   </tr>    
		<tr>
			<td width="80">Id del tipo de Documento</td>
			<td><input type="text" id="id_tip_documento" name="id_tip_documento" maxlength="4" size="20" onChange="verificar_tip_documento('buscar');" onKeyPress="enter2tab(event,'des_tip_documento',0);return solo_numeros(event);" /> Formato: (1234)</td>
		</tr>
        <tr>
			<td width="80">Descripci&oacute;n</td>
			<td><input type="text" id="des_tip_documento" name="des_tip_documento" maxlength="30" size="100" onKeyPress="enter2tab(event,'tip_documento_guardar',0);"/></td>
		</tr>	
        <tr>
		<td width="100">Estatus</td>
		<td  align="left">
			<input type="radio" id="sta_tip_documento" name="sta_tip_documento" checked="checked" value="A" >Activo
		</td>
        </tr>
        <tr>
        <td>
        </td>
        <td>
			<input type="radio" id="sta_tip_documento" name="sta_tip_documento" value="I" );>Inactivo

		</td>
	</tr>
	</table>	
</div>
	
<br />
	
<table width="700" align="center" class="tbldatos1">	
	<tr>
		<td colspan="" align="center">
			<button type="button" id="tip_documento_primero" name="tip_documento_primero" onClick="verificar_tip_documento('primero');" style="width:30px; height:25px;"><img src="css/imagenes/primero.png"></button>
			<button type="button" id="tip_documento_anterior" name="tip_documento_anterior" onClick="verificar_tip_documento('anterior');" style="width:30px; height:25px;"><img src="css/imagenes/anterior.png"></button>
			<button type="button" id="tip_documento_siguiente" name="tip_documento_siguiente" onClick="verificar_tip_documento('siguiente');" style="width:30px; height:25px;"><img src="css/imagenes/siguiente.png"></button>
			<button type="button" id="tip_documento_ultimo" name="tip_documento_ultimo" onClick="verificar_tip_documento('ultimo');" style="width:30px; height:25px;"><img src="css/imagenes/ultimo.png"></button>
			<button type="reset" id="tip_documento_cancelar" name="tip_documento_cancelar" onClick="limpiar_tip_documento();" style="width:30px; height:25px;"><img src="css/imagenes/cancelar.png"></button>
			<button type="button" id="tip_documento_guardar" name="tip_documento_guardar" onClick="guardar_tip_documento();verificar_tip_documento('cancelar');" style="width:30px; height:25px;"><img src="css/imagenes/guardar.png"></button>
		</td>
	</tr>
</table>

<div id="tip_documento_guardar_datos"> </div>

<div id="mensaje"> </div>
</html>