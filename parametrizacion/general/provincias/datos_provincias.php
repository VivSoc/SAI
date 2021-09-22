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
        <script type="text/javascript" src="javascript/parametrizacion/general/provincias.js"> </script>
    </head>
<?php
if (@$_REQUEST["id_provincia"] != "")
{
	$sql="select * from provincias where id_provincia = '".@$_REQUEST["id_provincia"]."'";
}

if (@$_REQUEST["provincia_op"] == "buscar")
{
	$sql="select * from provincias where id_provincia = '".@$_REQUEST["id_provincia"]."'";
	
}
else if (@$_REQUEST["provincia_op"]=="cancelar")
{
	?> <script>//document.location='provincias.php';</script><?php
}
else if (@$_REQUEST["provincia_op"]=="primero")
{		
	$sql="select * from provincias where id_provincia = (select min(id_provincia) from provincias)";

}
else if (@$_REQUEST["provincia_op"]=="ultimo")
{
	$sql="select * from provincias where id_provincia = (select max(id_provincia) from provincias)";
	
}
else if (@$_REQUEST["provincia_op"]=="anterior")
{
	$sql=registro_anterior("provincias","id_provincia",@$_REQUEST["id_provincia"],"id_provincia,des_provincia,sta_provincia");
	
}
else if (@$_REQUEST["provincia_op"]=="siguiente")
{
	$sql=registro_siguiente("provincias","id_provincia",@$_REQUEST["id_provincia"],"id_provincia,des_provincia,sta_provincia");
	
}

	
if ((@$_REQUEST["id_provincia"] != "" || @$_REQUEST["provincia_op"] == "primero" || 
	@$_REQUEST["provincia_op"] == "ultimo" || @$_REQUEST["provincia_op"] == "anterior" || 
	@$_REQUEST["provincia_op"] == "siguiente") && @$_REQUEST["provincia_op"] != "cancelar")
{
	$result10=pg_query($bd_conexion,$sql);
	if(pg_num_rows($result10)>0)
	{
		$id_provincia = pg_fetch_result($result10,0,"id_provincia");
		$des_provincia = pg_fetch_result($result10,0,"des_provincia");
		$sta_provincia = pg_fetch_result($result10,0,"sta_provincia");
		
	}
	else if (@$_REQUEST["provincia_op"] == "buscar")
	{				
		$id_provincia = @$_REQUEST["id_provincia"];
		$des_provincia = "";
		$sta_provincia = "";
	}
}
else if (@$_REQUEST["provincia_op"] == "cancelar" || @$_REQUEST["provincia_op"] == "guardar")
{				
	$id_provincia = "";
	$des_provincia = "";
	$sta_provincia = "";
}

	
if (@$_REQUEST["provincia_op"]=="guardar" && @$_REQUEST["id_provincia"]!= "" && @$_REQUEST["des_provincia"] != "" && @$_REQUEST["sta_provincia"] != "")
{
		$sql="select * from provincias where id_provincia = '".@$_REQUEST["id_provincia"]."'";
		$result10=pg_query($bd_conexion,$sql);
		if(pg_num_rows($result10)==0)
		{
			$sql = "Insert into provincias(id_provincia, des_provincia, sta_provincia) values ('".@$_REQUEST["id_provincia"]."', UPPER('".@$_REQUEST["des_provincia"]."'), '".@$_REQUEST["sta_provincia"]."')";
			$result10 = pg_query($bd_conexion,$sql);
			echo "<SCRIPT LANGUAGE='javascript'>swal('La provincia se registró','correctamente', 'success');</script>";
		}
		else
		{
			$sql = "update provincias set des_provincia = UPPER('".@$_REQUEST["des_provincia"]."'), sta_provincia = '".@$_REQUEST["sta_provincia"]."' where id_provincia='".@$_REQUEST["id_provincia"]."'";
			$result10 = pg_query($bd_conexion,$sql);
			echo "<SCRIPT LANGUAGE='javascript'>swal('La provincia se actualizó','correctamente', 'success');</script>";
		}
}
else
{
?>
	<div id="provincias">
	<table width="700" align="center" class="tbldatos1">
<tr><td colspan="2" align="center" class="fondo_fila_amarilla">Parametrización de Provincias</td>
   </tr>    
		<tr>
        
			<td width="80">Id de la Provincia</td>
			<td><input type="text" id="id_provincia" name="id_provincia" maxlength="4" value="<?php echo $id_provincia; ?>" size="20" onChange="verificar_provincia('buscar');" onKeyPress="enter2tab(event,'des_provincia',0);return solo_numeros(event);" /> Formato: (1234)</td>
		</tr>
			<td width="80">Descripci&oacute;n</td>
			<td><input type="text" id="des_provincia" name="des_provincia" maxlength="30" value="<?php echo $des_provincia; ?>" size="100" onKeyPress="enter2tab(event,'provincia_guardar',0);"/></td>
		</tr>
		<tr>
		<td width="100">Estatus</td>
		<td  align="left">
			<input type="radio" id="sta_provincia" name="sta_provincia" checked="checked" value="A" <?php if (pg_num_rows($result10)>0 && pg_fetch_result($result10,0,"sta_provincia")=="A") echo "CHECKED";?>>Activo
		</td>
		</tr>
		<tr>
		<td>
		</td>
		<td>
			<input type="radio" id="sta_provincia" name="sta_provincia" value="I" <?php if (pg_num_rows($result10)>0 && pg_fetch_result($result10,0,"sta_provincia")=="I") echo "CHECKED";?>>Inactivo

		</td>
	</tr>
	</table>	
</div>
<?php 
}	
?>
</html>