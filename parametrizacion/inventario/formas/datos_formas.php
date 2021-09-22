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
        <script type="text/javascript" src="javascript/parametrizacion/inventario/formas.js"> </script>
    </head>
<?php
if (@$_REQUEST["id_forma"] != "")
{
	$sql="select * from formas where id_forma = '".@$_REQUEST["id_forma"]."'";
}

if (@$_REQUEST["forma_op"] == "buscar")
{
	$sql="select * from formas where id_forma = '".@$_REQUEST["id_forma"]."'";
	
}
else if (@$_REQUEST["forma_op"]=="cancelar")
{
	?> <script>//document.location='formas.php';</script><?php
}
else if (@$_REQUEST["forma_op"]=="primero")
{		
	$sql="select * from formas where id_forma = (select min(id_forma) from formas)";

}
else if (@$_REQUEST["forma_op"]=="ultimo")
{
	$sql="select * from formas where id_forma = (select max(id_forma) from formas)";
	
}
else if (@$_REQUEST["forma_op"]=="anterior")
{
	$sql=registro_anterior("formas","id_forma",@$_REQUEST["id_forma"],"id_forma,des_forma,sta_forma");
	
}
else if (@$_REQUEST["forma_op"]=="siguiente")
{
	$sql=registro_siguiente("formas","id_forma",@$_REQUEST["id_forma"],"id_forma,des_forma,sta_forma");
	
}

	
if ((@$_REQUEST["id_forma"] != "" || @$_REQUEST["forma_op"] == "primero" || 
	@$_REQUEST["forma_op"] == "ultimo" || @$_REQUEST["forma_op"] == "anterior" || 
	@$_REQUEST["forma_op"] == "siguiente") && @$_REQUEST["forma_op"] != "cancelar")
{
	$result10=pg_query($bd_conexion,$sql);
	if(pg_num_rows($result10)>0)
	{
		$id_forma = pg_fetch_result($result10,0,"id_forma");
		$des_forma = pg_fetch_result($result10,0,"des_forma");
		$sta_forma = pg_fetch_result($result10,0,"sta_forma");
		
	}
	else if (@$_REQUEST["forma_op"] == "buscar")
	{				
		$id_forma = @$_REQUEST["id_forma"];
		$des_forma = "";
		$sta_forma = "";
	}
}
else if (@$_REQUEST["forma_op"] == "cancelar" || @$_REQUEST["forma_op"] == "guardar")
{				
	$id_forma = "";
	$des_forma = "";
	$sta_forma = "";
}

	
if (@$_REQUEST["forma_op"]=="guardar" && @$_REQUEST["id_forma"]!= "" && @$_REQUEST["des_forma"] != "" && @$_REQUEST["sta_forma"] != "")
{
		$sql="select * from formas where id_forma = '".@$_REQUEST["id_forma"]."'";
		$result10=pg_query($bd_conexion,$sql);
		if(pg_num_rows($result10)==0)
		{
			$sql = "Insert into formas(id_forma, des_forma, sta_forma) values ('".@$_REQUEST["id_forma"]."', UPPER('".@$_REQUEST["des_forma"]."'), '".@$_REQUEST["sta_forma"]."')";
			$result10 = pg_query($bd_conexion,$sql);
			echo "<SCRIPT LANGUAGE='javascript'>swal('La forma se registró','correctamente', 'success');</script>";
		}
		else
		{
			$sql = "update formas set des_forma = UPPER('".@$_REQUEST["des_forma"]."'), sta_forma = '".@$_REQUEST["sta_forma"]."' where id_forma='".@$_REQUEST["id_forma"]."'";
			$result10 = pg_query($bd_conexion,$sql);
			echo "<SCRIPT LANGUAGE='javascript'>swal('La forma se actualizó','correctamente', 'success');</script>";
		}
}
else
{
?>
	<div id="formas">
	<table width="700" align="center" class="tbldatos1">
<tr><td colspan="2" align="center" class="fondo_fila_amarilla">Parametrización de Formas</td>
   </tr>    
		<tr>
        
			<td width="80">Id de la forma</td>
			<td><input type="text" id="id_forma" name="id_forma" maxlength="4" value="<?php echo $id_forma; ?>" size="20" onChange="verificar_forma('buscar');" onKeyPress="enter2tab(event,'des_forma',0);return solo_numeros(event);" /> Formato: (1234)</td>
		</tr>
			<td width="80">Descripci&oacute;n</td>
			<td><input type="text" id="des_forma" name="des_forma" maxlength="30" value="<?php echo $des_forma; ?>" size="100" onKeyPress="enter2tab(event,'forma_guardar',0);"/></td>
		</tr>
		<tr>
		<td width="100">Estatus</td>
		<td  align="left">
			<input type="radio" id="sta_forma" name="sta_forma" checked="checked" value="A" <?php if (pg_num_rows($result10)>0 && pg_fetch_result($result10,0,"sta_forma")=="A") echo "CHECKED";?>>Activo
		</td>
		</tr>
		<tr>
		<td>
		</td>
		<td>
			<input type="radio" id="sta_forma" name="sta_forma" value="I" <?php if (pg_num_rows($result10)>0 && pg_fetch_result($result10,0,"sta_forma")=="I") echo "CHECKED";?>>Inactivo

		</td>
	</tr>
	</table>	
</div>
<?php 
}	
?>
</html>