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
        <script type="text/javascript" src="javascript/parametrizacion/inventario/modelos.js"> </script>
    </head>
<?php
if (@$_REQUEST["id_modelo"] != "")
{
	$sql="select * from modelos where id_modelo = '".@$_REQUEST["id_modelo"]."'";
}

if (@$_REQUEST["modelo_op"] == "buscar")
{
	$sql="select * from modelos where id_modelo = '".@$_REQUEST["id_modelo"]."'";
	
}
else if (@$_REQUEST["modelo_op"]=="cancelar")
{
	?> <script>//document.location='modelos.php';</script><?php
}
else if (@$_REQUEST["modelo_op"]=="primero")
{		
	$sql="select * from modelos where id_modelo = (select min(id_modelo) from modelos)";

}
else if (@$_REQUEST["modelo_op"]=="ultimo")
{
	$sql="select * from modelos where id_modelo = (select max(id_modelo) from modelos)";
	
}
else if (@$_REQUEST["modelo_op"]=="anterior")
{
	$sql=registro_anterior("modelos","id_modelo",@$_REQUEST["id_modelo"],"id_modelo,des_modelo,sta_modelo");
	
}
else if (@$_REQUEST["modelo_op"]=="siguiente")
{
	$sql=registro_siguiente("modelos","id_modelo",@$_REQUEST["id_modelo"],"id_modelo,des_modelo,sta_modelo");
	
}

	
if ((@$_REQUEST["id_modelo"] != "" || @$_REQUEST["modelo_op"] == "primero" || 
	@$_REQUEST["modelo_op"] == "ultimo" || @$_REQUEST["modelo_op"] == "anterior" || 
	@$_REQUEST["modelo_op"] == "siguiente") && @$_REQUEST["modelo_op"] != "cancelar")
{
	$result10=pg_query($bd_conexion,$sql);
	if(pg_num_rows($result10)>0)
	{
		$id_modelo = pg_fetch_result($result10,0,"id_modelo");
		$des_modelo = pg_fetch_result($result10,0,"des_modelo");
		$sta_modelo = pg_fetch_result($result10,0,"sta_modelo");
		
	}
	else if (@$_REQUEST["modelo_op"] == "buscar")
	{				
		$id_modelo = @$_REQUEST["id_modelo"];
		$des_modelo = "";
		$sta_modelo = "";
	}
}
else if (@$_REQUEST["modelo_op"] == "cancelar" || @$_REQUEST["modelo_op"] == "guardar")
{				
	$id_modelo = "";
	$des_modelo = "";
	$sta_modelo = "";
}

	
if (@$_REQUEST["modelo_op"]=="guardar" && @$_REQUEST["id_modelo"]!= "" && @$_REQUEST["des_modelo"] != "" && @$_REQUEST["sta_modelo"] != "")
{
		$sql="select * from modelos where id_modelo = '".@$_REQUEST["id_modelo"]."'";
		$result10=pg_query($bd_conexion,$sql);
		if(pg_num_rows($result10)==0)
		{
			$sql = "Insert into modelos(id_modelo, des_modelo, sta_modelo) values ('".@$_REQUEST["id_modelo"]."', UPPER('".@$_REQUEST["des_modelo"]."'), '".@$_REQUEST["sta_modelo"]."')";
			$result10 = pg_query($bd_conexion,$sql);
			echo "<SCRIPT LANGUAGE='javascript'>swal('El modelo se registró','correctamente', 'success');</script>";
		}
		else
		{
			$sql = "update modelos set des_modelo = UPPER('".@$_REQUEST["des_modelo"]."'), sta_modelo = '".@$_REQUEST["sta_modelo"]."' where id_modelo='".@$_REQUEST["id_modelo"]."'";
			$result10 = pg_query($bd_conexion,$sql);
			echo "<SCRIPT LANGUAGE='javascript'>swal('El modelo se actualizó','correctamente', 'success');</script>";
		}
}
else
{
?>
	<div id="modelos">
	<table width="700" align="center" class="tbldatos1">
<tr><td colspan="2" align="center" class="fondo_fila_amarilla">Parametrización de Modelos</td>
   </tr>    
		<tr>
        
			<td width="80">Id del Modelo</td>
			<td><input type="text" id="id_modelo" name="id_modelo" maxlength="4" value="<?php echo $id_modelo; ?>" size="20" onChange="verificar_modelo('buscar');" onKeyPress="enter2tab(event,'des_modelo',0);return solo_numeros(event);" /> Formato: (1234)</td>
		</tr>
			<td width="80">Descripci&oacute;n</td>
			<td><input type="text" id="des_modelo" name="des_modelo" maxlength="30" value="<?php echo $des_modelo; ?>" size="100" onKeyPress="enter2tab(event,'modelo_guardar',0);"/></td>
		</tr>
		<tr>
		<td width="100">Estatus</td>
		<td  align="left">
			<input type="radio" id="sta_modelo" name="sta_modelo" checked="checked" value="A" <?php if (pg_num_rows($result10)>0 && pg_fetch_result($result10,0,"sta_modelo")=="A") echo "CHECKED";?>>Activo
		</td>
		</tr>
		<tr>
		<td>
		</td>
		<td>
			<input type="radio" id="sta_modelo" name="sta_modelo" value="I" <?php if (pg_num_rows($result10)>0 && pg_fetch_result($result10,0,"sta_modelo")=="I") echo "CHECKED";?>>Inactivo

		</td>
	</tr>
	</table>	
</div>
<?php 
}	
?>
</html>