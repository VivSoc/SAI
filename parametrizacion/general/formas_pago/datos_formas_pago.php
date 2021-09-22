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
        <script type="text/javascript" src="javascript/parametrizacion/general/formas_pago.js"> </script>
    </head>
<?php
if (@$_REQUEST["id_formas_pago"] != "")
{
	$sql="select * from formas_pago where id_for_pago = '".@$_REQUEST["id_formas_pago"]."'";
}

if (@$_REQUEST["formas_pago_op"] == "buscar")
{
	$sql="select * from formas_pago where id_for_pago = '".@$_REQUEST["id_formas_pago"]."'";
	
}
else if (@$_REQUEST["formas_pago_op"]=="cancelar")
{
	?> <script>//document.location='formas_pago.php';</script><?php
}
else if (@$_REQUEST["formas_pago_op"]=="primero")
{		
	$sql="select * from formas_pago where id_for_pago = (select min(id_for_pago) from formas_pago)";

}
else if (@$_REQUEST["formas_pago_op"]=="ultimo")
{
	$sql="select * from formas_pago where id_for_pago = (select max(id_for_pago) from formas_pago)";
	
}
else if (@$_REQUEST["formas_pago_op"]=="anterior")
{
	$sql=registro_anterior("formas_pago","id_for_pago",@$_REQUEST["id_formas_pago"],"id_for_pago,des_for_pago,sta_for_pago");
	
}
else if (@$_REQUEST["formas_pago_op"]=="siguiente")
{
	$sql=registro_siguiente("formas_pago","id_for_pago",@$_REQUEST["id_formas_pago"],"id_for_pago,des_for_pago,sta_for_pago");
	
}

	
if ((@$_REQUEST["id_formas_pago"] != "" || @$_REQUEST["formas_pago_op"] == "primero" || 
	@$_REQUEST["formas_pago_op"] == "ultimo" || @$_REQUEST["formas_pago_op"] == "anterior" || 
	@$_REQUEST["formas_pago_op"] == "siguiente") && @$_REQUEST["formas_pago_op"] != "cancelar")
{
	$result10=pg_query($bd_conexion,$sql);
	if(pg_num_rows($result10)>0)
	{
		$id_formas_pago = pg_fetch_result($result10,0,"id_for_pago");
		$des_formas_pago = pg_fetch_result($result10,0,"des_for_pago");
		$sta_formas_pago = pg_fetch_result($result10,0,"sta_for_pago");
		
	}
	else if (@$_REQUEST["formas_pago_op"] == "buscar")
	{				
		$id_formas_pago = @$_REQUEST["id_formas_pago"];
		$des_formas_pago = "";
		$sta_formas_pago = "";
	}
}
else if (@$_REQUEST["formas_pago_op"] == "cancelar" || @$_REQUEST["formas_pago_op"] == "guardar")
{				
	$id_formas_pago = "";
	$des_formas_pago = "";
	$sta_formas_pago = "";
}

	
if (@$_REQUEST["formas_pago_op"]=="guardar" && @$_REQUEST["id_formas_pago"]!= "" && @$_REQUEST["des_formas_pago"] != "" && @$_REQUEST["sta_formas_pago"] != "")
{
		$sql="select * from formas_pago where id_for_pago = '".@$_REQUEST["id_formas_pago"]."'";
		$result10=pg_query($bd_conexion,$sql);
		if(pg_num_rows($result10)==0)
		{
			$sql = "Insert into formas_pago(id_for_pago, des_for_pago, sta_for_pago) values ('".@$_REQUEST["id_formas_pago"]."', UPPER('".@$_REQUEST["des_formas_pago"]."'), '".@$_REQUEST["sta_formas_pago"]."')";
			$result10 = pg_query($bd_conexion,$sql);
			echo "<SCRIPT LANGUAGE='javascript'>swal('La forma de pago se registró','correctamente', 'success');</script>";
		}
		else
		{
			$sql = "update formas_pago set des_for_pago = UPPER('".@$_REQUEST["des_formas_pago"]."'), sta_formas_pago = '".@$_REQUEST["sta_formas_pago"]."' where id_for_pago='".@$_REQUEST["id_formas_pago"]."'";
			$result10 = pg_query($bd_conexion,$sql);
			echo "<SCRIPT LANGUAGE='javascript'>swal('La forma de pago se actualizó','correctamente', 'success');</script>";
		}
}
else
{
?>
	<div id="formas_pago">
	<table width="700" align="center" class="tbldatos1">
<tr><td colspan="2" align="center" class="fondo_fila_amarilla">Parametrización de Formas de Pago</td>
   </tr>    
		<tr>
        
			<td width="80">Id de la forma de pago</td>
			<td><input type="text" id="id_formas_pago" name="id_formas_pago" maxlength="4" value="<?php echo $id_formas_pago; ?>" size="20" onChange="verificar_formas_pago('buscar');" onKeyPress="enter2tab(event,'des_formas_pago',0);return solo_numeros(event);" /> Formato: (1234)</td>
		</tr>
			<td width="80">Descripci&oacute;n</td>
			<td><input type="text" id="des_formas_pago" name="des_formas_pago" maxlength="30" value="<?php echo $des_formas_pago; ?>" size="100" onKeyPress="enter2tab(event,'formas_pago_guardar',0);"/></td>
		</tr>
		<tr>
		<td width="100">Estatus</td>
		<td  align="left">
			<input type="radio" id="sta_formas_pago" name="sta_formas_pago" checked="checked" value="A" <?php if (pg_num_rows($result10)>0 && pg_fetch_result($result10,0,"sta_formas_pago")=="A") echo "CHECKED";?>>Activo
		</td>
		</tr>
		<tr>
		<td>
		</td>
		<td>
			<input type="radio" id="sta_formas_pago" name="sta_formas_pago" value="I" <?php if (pg_num_rows($result10)>0 && pg_fetch_result($result10,0,"sta_formas_pago")=="I") echo "CHECKED";?>>Inactivo

		</td>
	</tr>
	</table>	
</div>
<?php 
}	
?>
</html>