<?php 
require("../../../../configuracion/config.php");
require("../../../../configuracion/conexion.php");
require("../../../../clases/funciones.php");
require("../../../../sesion.php");
require_once("../../../../clases/utilidades.class.php");
// falta traer el id del canton: $sql="select id_provincia from cantones where id_canton = ";
//$result10=pg_query($bd_conexion,$sql);
//	if(pg_num_rows($result10)>0)
//	{
//		$id_provincia = pg_fetch_result($result10,0,"id_provincia");		
//	};
//var_dump(getcwd()); <-- esto es para ver la ruta
?>
<html>
	<head>
        <link rel="stylesheet" href="css/sweetalert.css" type="text/css">
        <script type="text/javascript" src="javascript/sweetalert.min.js"></script>
        <script type="text/javascript" src="javascript/parametrizacion/general/cantones.js"> </script>
    </head>
	
<div id="cantones">
	<table width="700" align="center" class="tbldatos1">
<tr><td colspan="2" align="center" class="fondo_fila_amarilla">Parametrización de Cantones</td>
   </tr>    
		<tr>
			<td width="152">Id del Canton</td>
			<td width="536"><input type="text" id="id_canton" name="id_canton" maxlength="4" size="20" onChange="verificar_canton('buscar');" onKeyPress="enter2tab(event,'des_canton',0);return solo_numeros(event);" /> Formato: (1234)</td>
		</tr>
        <tr>
			<td width="536">Descripci&oacute;n</td>
			<td><input type="text" id="des_canton" name="des_canton" maxlength="30" size="90" onKeyPress="enter2tab(event,'id_provincia',0);"/></td>
		</tr>
        <tr>
        <td>Pertenece a la Provincia</td>
		<td><input type="text" name="id_provincia" id="id_provincia" maxlength="4" size="6" style="text-align:left; font-size: 16; " value='<?php if (pg_num_rows($result)>0) echo utf8(pg_fetch_result($result,0,"id_provincia")); ?>' onBlur="CodigoToSelect(document.getElementById('id_provincia').value,document.getElementById('desprovincia'));" onKeyPress="enter2tab(event,'canton_guardar',0);" lang="s"/>
<?php
		$accion=		"onchange=document.getElementById('id_provincia').value=document.getElementById('desprovincia').options[document.getElementById('desprovincia').selectedIndex].value;";
		$objUtilidades=new utilidades;
      	$objUtilidades->seleccionarCombo("Select * From provincias where sta_provincia='A' order by id_provincia","desprovincia",$accion,$id_provincia,$readonly='',$retornar=0);    
?>
	</td>
    </tr>	
        <tr>
		<td width="152">Estatus</td>
		<td  align="left">
			<input type="radio" id="sta_canton" name="sta_canton" checked="checked" value="A" >Activo
		</td>
        </tr>
        <tr>
        <td>
        </td>
        <td>
			<input type="radio" id="sta_canton" name="sta_canton" value="I" );>Inactivo

		</td>
	</tr>
	</table>	
</div>
	
<br />
	
<table width="700" align="center" class="tbldatos1">	
	<tr>
		<td colspan="" align="center">
			<button type="button" id="canton_primero" name="canton_primero" onClick="verificar_canton('primero');" style="width:30px; height:25px;"><img src="css/imagenes/primero.png"></button>
			<button type="button" id="canton_anterior" name="canton_anterior" onClick="verificar_canton('anterior');" style="width:30px; height:25px;"><img src="css/imagenes/anterior.png"></button>
			<button type="button" id="canton_siguiente" name="canton_siguiente" onClick="verificar_canton('siguiente');" style="width:30px; height:25px;"><img src="css/imagenes/siguiente.png"></button>
			<button type="button" id="canton_ultimo" name="canton_ultimo" onClick="verificar_canton('ultimo');" style="width:30px; height:25px;"><img src="css/imagenes/ultimo.png"></button>
			<button type="reset" id="canton_cancelar" name="canton_cancelar" onClick="limpiar_canton();" style="width:30px; height:25px;"><img src="css/imagenes/cancelar.png"></button>
			<button type="button" id="canton_guardar" name="canton_guardar" onClick="guardar_canton();verificar_canton('cancelar');" style="width:30px; height:25px;"><img src="css/imagenes/guardar.png"></button>
		</td>
	</tr>
</table>

<div id="canton_guardar_datos"> </div>

<div id="mensaje"> </div>
</html>