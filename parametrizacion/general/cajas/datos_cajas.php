<?php 
require("../../../../configuracion/config.php");
require("../../../../configuracion/conexion.php");
require("../../../../clases/funciones.php");
require("../../../../sesion.php");
?>
<html>
	<head>
        <link rel="stylesheet" href="css/sweetalert.css" type="text/css">
        <script type="text/javascript" src="javascript/sweetalert.min.js"></script>
        <script type="text/javascript" src="javascript/parametrizacion/general/cajas.js"> </script>
    </head>
<?php
if (@$_REQUEST["id_caja"] != "")
{
	$sql="select * from cajas where id_caja = '".@$_REQUEST["id_caja"]."'";
}

if (@$_REQUEST["caja_op"] == "buscar")
{
	$sql="select * from cajas where id_caja = '".@$_REQUEST["id_caja"]."'";
	
}
else if (@$_REQUEST["caja_op"]=="cancelar")
{
	?> <script>//document.location='cajas.php';</script><?php
}
else if (@$_REQUEST["caja_op"]=="primero")
{		
	$sql="select * from cajas where id_caja = (select min(id_caja) from cajas)";

}
else if (@$_REQUEST["caja_op"]=="ultimo")
{
	$sql="select * from cajas where id_caja = (select max(id_caja) from cajas)";
	
}
else if (@$_REQUEST["caja_op"]=="anterior")
{
	$sql=registro_anterior("cajas","id_caja",@$_REQUEST["id_caja"],"id_caja,des_caja,sta_caja");
	
}
else if (@$_REQUEST["caja_op"]=="siguiente")
{
	$sql=registro_siguiente("cajas","id_caja",@$_REQUEST["id_caja"],"id_caja,des_caja,sta_caja");
	
}

	
if ((@$_REQUEST["id_caja"] != "" || @$_REQUEST["caja_op"] == "primero" || 
	@$_REQUEST["caja_op"] == "ultimo" || @$_REQUEST["caja_op"] == "anterior" || 
	@$_REQUEST["caja_op"] == "siguiente") && @$_REQUEST["caja_op"] != "cancelar")
{
	$result10=pg_query($bd_conexion,$sql);
	if(pg_num_rows($result10)>0)
	{
		$id_caja = pg_fetch_result($result10,0,"id_caja");
		$des_caja = pg_fetch_result($result10,0,"des_caja");
		$sta_caja = pg_fetch_result($result10,0,"sta_caja");
		
	}
	else if (@$_REQUEST["caja_op"] == "buscar")
	{				
		$id_caja = @$_REQUEST["id_caja"];
		$des_caja = "";
		$sta_caja = "";
	}
}
else if (@$_REQUEST["caja_op"] == "cancelar" || @$_REQUEST["caja_op"] == "guardar")
{				
	$id_caja = "";
	$des_caja = "";
	$sta_caja = "";
}

	
if (@$_REQUEST["caja_op"]=="guardar" && @$_REQUEST["id_caja"]!= "" && @$_REQUEST["des_caja"] != "" && @$_REQUEST["sta_caja"] != "")
{
		$sql="select * from cajas where id_caja = '".@$_REQUEST["id_caja"]."'";
		$result10=pg_query($bd_conexion,$sql);
		if(pg_num_rows($result10)==0)
		{
			$sql = "Insert into cajas(id_caja, des_caja, sta_caja) values ('".@$_REQUEST["id_caja"]."', UPPER('".@$_REQUEST["des_caja"]."'), '".@$_REQUEST["sta_caja"]."')";
			$result10 = pg_query($bd_conexion,$sql);
			echo "<SCRIPT LANGUAGE='javascript'>swal('La caja se registró','correctamente', 'success');</script>";
		}
		else
		{
			$sql = "update cajas set des_caja = UPPER('".@$_REQUEST["des_caja"]."'), sta_caja = '".@$_REQUEST["sta_caja"]."' where id_caja='".@$_REQUEST["id_caja"]."'";
			$result10 = pg_query($bd_conexion,$sql);
			echo "<SCRIPT LANGUAGE='javascript'>swal('La caja se actualizó','correctamente', 'success');</script>";
		}
}
else
{
?>
	<div id="cajas">
	<table width="700" align="center" class="tbldatos1">
<tr><td colspan="2" align="center" class="fondo_fila_amarilla">Parametrización de Cajas</td>
   </tr>    
		<tr>
        
			<td width="80">Id de la caja</td>
			<td><input type="text" id="id_caja" name="id_caja" maxlength="4" value="<?php echo $id_caja; ?>" size="20" onChange="verificar_caja('buscar');" onKeyPress="enter2tab(event,'des_caja',0);return solo_numeros(event);"" /> Formato: (1234)</td>
		</tr>
			<td width="80">Descripci&oacute;n</td>
			<td><input type="text" id="des_caja" name="des_caja" maxlength="30" value="<?php echo $des_caja; ?>" size="100" onKeyPress="enter2tab(event,'caja_guardar',0);"/></td>
		</tr>
		<tr>
		<td width="100">Estatus</td>
		<td  align="left">
			<input type="radio" id="sta_caja" name="sta_caja" checked="checked" value="A" <?php if (pg_num_rows($result10)>0 && pg_fetch_result($result10,0,"sta_caja")=="A") echo "CHECKED";?>>Activo
		</td>
		</tr>
		<tr>
		<td>
		</td>
		<td>
			<input type="radio" id="sta_caja" name="sta_caja" value="I" <?php if (pg_num_rows($result10)>0 && pg_fetch_result($result10,0,"sta_caja")=="I") echo "CHECKED";?>>Inactivo

		</td>
	</tr>
	</table>	
</div>
<?php 
}	
?>
</html>