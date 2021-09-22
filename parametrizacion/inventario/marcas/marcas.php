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
        <script type="text/javascript" src="javascript/parametrizacion/inventario/marcas.js"> </script>
    </head>
	
<div id="marcas">
	<table width="700" align="center" class="tbldatos1">
<tr><td colspan="2" align="center" class="fondo_fila_amarilla">Parametrización de Marcas</td>
   </tr>    
		<tr>
			<td width="80">Id de la Marca</td>
			<td><input type="text" id="id_marca" name="id_marca" maxlength="4" size="20" onChange="verificar_marca('buscar');" onKeyPress="enter2tab(event,'des_marca',0);return solo_numeros(event);" /> Formato: (1234)</td>
		</tr>
        <tr>
			<td width="80">Descripci&oacute;n</td>
			<td><input type="text" id="des_marca" name="des_marca" maxlength="30" size="100" onKeyPress="enter2tab(event,'marca_guardar',0);"/></td>
		</tr>	
        <tr>
		<td width="100">Estatus</td>
		<td  align="left">
			<input type="radio" id="sta_marca" name="sta_marca" checked="checked" value="A" >Activo
		</td>
        </tr>
        <tr>
        <td>
        </td>
        <td>
			<input type="radio" id="sta_marca" name="sta_marca" value="I" );>Inactivo

		</td>
	</tr>
	</table>	
</div>
	
<br />
	
<table width="700" align="center" class="tbldatos1">	
	<tr>
		<td colspan="" align="center">
			<button type="button" id="marca_primero" name="marca_primero" onClick="verificar_marca('primero');" style="width:30px; height:25px;"><img src="css/imagenes/primero.png"></button>
			<button type="button" id="marca_anterior" name="marca_anterior" onClick="verificar_marca('anterior');" style="width:30px; height:25px;"><img src="css/imagenes/anterior.png"></button>
			<button type="button" id="marca_siguiente" name="marca_siguiente" onClick="verificar_marca('siguiente');" style="width:30px; height:25px;"><img src="css/imagenes/siguiente.png"></button>
			<button type="button" id="marca_ultimo" name="marca_ultimo" onClick="verificar_marca('ultimo');" style="width:30px; height:25px;"><img src="css/imagenes/ultimo.png"></button>
			<button type="reset" id="marca_cancelar" name="marca_cancelar" onClick="limpiar_marca();" style="width:30px; height:25px;"><img src="css/imagenes/cancelar.png"></button>
			<button type="button" id="marca_guardar" name="marca_guardar" onClick="guardar_marca();verificar_marca('cancelar');" style="width:30px; height:25px;"><img src="css/imagenes/guardar.png"></button>
		</td>
	</tr>
</table>

<div id="marca_guardar_datos"> </div>

<div id="mensaje"> </div>
</html>