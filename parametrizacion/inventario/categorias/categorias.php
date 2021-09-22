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
        <script type="text/javascript" src="javascript/parametrizacion/inventario/categorias.js"> </script>
    </head>
	
<div id="categorias">
	<table width="700" align="center" class="tbldatos1">
<tr><td colspan="2" align="center" class="fondo_fila_amarilla">Parametrización de Categorías</td>
   </tr>    
		<tr>
			<td width="80">Id de Categoría</td>
			<td><input type="text" id="id_categoria" name="id_categoria" maxlength="4" size="20" onChange="verificar_categoria('buscar');" onKeyPress="enter2tab(event,'pre_categoria',0);return solo_numeros(event);" /> Formato: (1234)</td>
		</tr>
        <tr>
        <div id="prefijo">
			<td width="80">Prefijo</td>
			<td><input type="text" id="pre_categoria" name="des_categoria" maxlength="4" size="20" onKeyPress="enter2tab(event,'des_categoria',0);return solo_letras(event);" onKeyUp="javascript:this.value=this.value.toUpperCase();" onBlur="valida_prefijo_categoria();"/> Formato: (ABCD)</td>
		</div></tr>
        <tr>
			<td width="80">Descripci&oacute;n</td>
			<td><input type="text" id="des_categoria" name="des_categoria" maxlength="30" size="100" onKeyPress="enter2tab(event,'categoria_guardar',0);"/></td>
		</tr>	
        <tr>
		<td width="100">Estatus</td>
		<td  align="left">
			<input type="radio" id="sta_categoria" name="sta_categoria" checked="checked" value="A" >Activo
		</td>
        </tr>
        <tr>
        <td>
        </td>
        <td>
			<input type="radio" id="sta_categoria" name="sta_categoria" value="I" );>Inactivo

		</td>
	</tr>
	</table>	
</div>
	
<br />
	
<table width="700" align="center" class="tbldatos1">	
	<tr>
		<td colspan="" align="center">
			<button type="button" id="categoria_primero" name="categoria_primero" onClick="verificar_categoria('primero');" style="width:30px; height:25px;"><img src="css/imagenes/primero.png"></button>
			<button type="button" id="categoria_anterior" name="categoria_anterior" onClick="verificar_categoria('anterior');" style="width:30px; height:25px;"><img src="css/imagenes/anterior.png"></button>
			<button type="button" id="categoria_siguiente" name="categoria_siguiente" onClick="verificar_categoria('siguiente');" style="width:30px; height:25px;"><img src="css/imagenes/siguiente.png"></button>
			<button type="button" id="categoria_ultimo" name="categoria_ultimo" onClick="verificar_categoria('ultimo');" style="width:30px; height:25px;"><img src="css/imagenes/ultimo.png"></button>
			<button type="reset" id="categoria_cancelar" name="categoria_cancelar" onClick="limpiar_categoria();" style="width:30px; height:25px;"><img src="css/imagenes/cancelar.png"></button>
			<button type="button" id="categoria_guardar" name="categoria_guardar" onClick="guardar_categoria();verificar_categoria('cancelar');" style="width:30px; height:25px;"><img src="css/imagenes/guardar.png"></button>
		</td>
	</tr>
</table>

<div id="categoria_guardar_datos"> </div>

<div id="mensaje"> </div>
</html>