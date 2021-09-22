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
        <script type="text/javascript" src="javascript/parametrizacion/general/bancos.js"> </script>
    </head>
<?php
if (@$_REQUEST["id_banco"] != "")
{
	$sql="select * from bancos where id_banco = '".@$_REQUEST["id_banco"]."'";
}

if (@$_REQUEST["banco_op"] == "buscar")
{
	$sql="select * from bancos where id_banco = '".@$_REQUEST["id_banco"]."'";
	
}
else if (@$_REQUEST["banco_op"]=="cancelar")
{
	?> <script>//document.location='bancos.php';</script><?php
}
else if (@$_REQUEST["banco_op"]=="primero")
{		
	$sql="select * from bancos where id_banco = (select min(id_banco) from bancos)";

}
else if (@$_REQUEST["banco_op"]=="ultimo")
{
	$sql="select * from bancos where id_banco = (select max(id_banco) from bancos)";
	
}
else if (@$_REQUEST["banco_op"]=="anterior")
{
	$sql=registro_anterior("bancos","id_banco",@$_REQUEST["id_banco"],"id_banco,des_banco,sta_banco");
	
}
else if (@$_REQUEST["banco_op"]=="siguiente")
{
	$sql=registro_siguiente("bancos","id_banco",@$_REQUEST["id_banco"],"id_banco,des_banco,sta_banco");
	
}

	
if ((@$_REQUEST["id_banco"] != "" || @$_REQUEST["banco_op"] == "primero" || 
	@$_REQUEST["banco_op"] == "ultimo" || @$_REQUEST["banco_op"] == "anterior" || 
	@$_REQUEST["banco_op"] == "siguiente") && @$_REQUEST["banco_op"] != "cancelar")
{
	$result10=pg_query($bd_conexion,$sql);
	if(pg_num_rows($result10)>0)
	{
		$id_banco = pg_fetch_result($result10,0,"id_banco");
		$des_banco = pg_fetch_result($result10,0,"des_banco");
		$sta_banco = pg_fetch_result($result10,0,"sta_banco");
		
	}
	else if (@$_REQUEST["banco_op"] == "buscar")
	{				
		$id_banco = @$_REQUEST["id_banco"];
		$des_banco = "";
		$sta_banco = "";
	}
}
else if (@$_REQUEST["banco_op"] == "cancelar" || @$_REQUEST["banco_op"] == "guardar")
{				
	$id_banco = "";
	$des_banco = "";
	$sta_banco = "";
}

	
if (@$_REQUEST["banco_op"]=="guardar" && @$_REQUEST["id_banco"]!= "" && @$_REQUEST["des_banco"] != "" && @$_REQUEST["sta_banco"] != "")
{
		$sql="select * from bancos where id_banco = '".@$_REQUEST["id_banco"]."'";
		$result10=pg_query($bd_conexion,$sql);
		if(pg_num_rows($result10)==0)
		{
			$sql = "Insert into bancos(id_banco, des_banco, sta_banco) values ('".@$_REQUEST["id_banco"]."', UPPER('".@$_REQUEST["des_banco"]."'), '".@$_REQUEST["sta_banco"]."')";
			$result10 = pg_query($bd_conexion,$sql);
			echo "<SCRIPT LANGUAGE='javascript'>swal('El banco se registró','correctamente', 'success');</script>";
		}
		else
		{
			$sql = "update bancos set des_banco = UPPER('".@$_REQUEST["des_banco"]."'), sta_banco = '".@$_REQUEST["sta_banco"]."' where id_banco='".@$_REQUEST["id_banco"]."'";
			$result10 = pg_query($bd_conexion,$sql);
			echo "<SCRIPT LANGUAGE='javascript'>swal('El banco se actualizó','correctamente', 'success');</script>";
		}
}
else
{
?>
	<div id="bancos">
	<table width="700" align="center" class="tbldatos1">
<tr><td colspan="2" align="center" class="fondo_fila_amarilla">Parametrización de Bancos</td>
   </tr>    
		<tr>
        
			<td width="80">Id del banco</td>
			<td><input type="text" id="id_banco" name="id_banco" maxlength="4" value="<?php echo $id_banco; ?>" size="20" onChange="verificar_banco('buscar');" onKeyPress="enter2tab(event,'des_banco',0);return solo_numeros(event);"  /> Formato: (1234)</td>
		</tr>
			<td width="80">Descripci&oacute;n</td>
			<td><input type="text" id="des_banco" name="des_banco" maxlength="200" value="<?php echo $des_banco; ?>" size="100" onKeyPress="enter2tab(event,'banco_guardar',0);"/></td>
		</tr>
		<tr>
		<td width="100">Estatus</td>
		<td  align="left">
			<input type="radio" id="sta_banco" name="sta_banco" checked="checked" value="A" <?php if (pg_num_rows($result10)>0 && pg_fetch_result($result10,0,"sta_banco")=="A") echo "CHECKED";?>>Activo
		</td>
		</tr>
		<tr>
		<td>
		</td>
		<td>
			<input type="radio" id="sta_banco" name="sta_banco" value="I" <?php if (pg_num_rows($result10)>0 && pg_fetch_result($result10,0,"sta_banco")=="I") echo "CHECKED";?>>Inactivo

		</td>
	</tr>
	</table>	
</div>
<?php 
}	
?>
</html>