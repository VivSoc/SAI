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
        <script type="text/javascript" src="javascript/parametrizacion/general/ivas.js"> </script>
    </head>
	
<div id="ivas">
	<table width="700" align="center" class="tbldatos1">
<tr><td colspan="2" align="center" class="fondo_fila_amarilla">Parametrización de Iva</td>
   </tr>    
		<tr>
			<td width="80">Id del Iva</td>
			<td><input type="text" id="id_iva" name="id_iva" maxlength="4" size="20" onChange="verificar_iva('buscar');" onKeyPress="enter2tab(event,'des_iva',0);return solo_numeros(event);" /> Formato: (1234)</td>
		</tr>
        <tr>
			<td width="80">Descripci&oacute;n</td>
			<td><input type="text" id="des_iva" name="des_iva" maxlength="50" size="100" onKeyPress="enter2tab(event,'mon_iva',0);"/></td>
		</tr>
        <tr>
        <div id="monto">
			<td width="80">Monto</td>
			<td><input type="text" id="mon_iva" name="mon_iva" maxlength="5" size="6" onKeyPress="enter2tab(event,'let_iva',0);MASK(event,this,this.value,'-###,###,###,##0.00',1);return solo_dinero(event);" onBlur="valida_monto_iva();"/> %</td>
		</div></tr>	
        <tr>
        <tr>
        <div id="letra">
			<td width="80">Letra</td>
			<td><input type="text" id="let_iva" name="let_iva" maxlength="1" size="6" onKeyPress="enter2tab(event,'ley_iva',0); return solo_letras(event);" onKeyUp="javascript:this.value=this.value.toUpperCase();" onBlur="valida_letra_iva();"/> Formato: (ABC)</td>
		</div></tr>	
        <tr>
        <tr>
			<td width="80">Leyenda</td>
			<td><input type="text" id="ley_iva" name="ley_iva" maxlength="50" size="100" onKeyPress="enter2tab(event,'iva_guardar',0);"/></td>
		</tr>	
        <tr>
		<td width="100">Estatus</td>
		<td  align="left">
			<input type="radio" id="sta_iva" name="sta_iva" checked="checked" value="A" >Activo
		</td>
        </tr>
        <tr>
        <td>
        </td>
        <td>
			<input type="radio" id="sta_iva" name="sta_iva" value="I" );>Inactivo

		</td>
	</tr>
	</table>	
</div>
	
<br />
	
<table width="700" align="center" class="tbldatos1">	
	<tr>
		<td colspan="" align="center">
			<button type="button" id="iva_primero" name="iva_primero" onClick="verificar_iva('primero');" style="width:30px; height:25px;"><img src="css/imagenes/primero.png"></button>
			<button type="button" id="iva_anterior" name="iva_anterior" onClick="verificar_iva('anterior');" style="width:30px; height:25px;"><img src="css/imagenes/anterior.png"></button>
			<button type="button" id="iva_siguiente" name="iva_siguiente" onClick="verificar_iva('siguiente');" style="width:30px; height:25px;"><img src="css/imagenes/siguiente.png"></button>
			<button type="button" id="iva_ultimo" name="iva_ultimo" onClick="verificar_iva('ultimo');" style="width:30px; height:25px;"><img src="css/imagenes/ultimo.png"></button>
			<button type="reset" id="iva_cancelar" name="iva_cancelar" onClick="limpiar_iva();" style="width:30px; height:25px;"><img src="css/imagenes/cancelar.png"></button>
			<button type="button" id="iva_guardar" name="iva_guardar" onClick="guardar_iva();verificar_iva('cancelar');" style="width:30px; height:25px;"><img src="css/imagenes/guardar.png"></button>
		</td>
	</tr>
</table>

<div id="iva_guardar_datos"> </div>

<div id="mensaje"> </div>
</html>