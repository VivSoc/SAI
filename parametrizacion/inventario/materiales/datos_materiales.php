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
        <script type="text/javascript" src="javascript/parametrizacion/inventario/materiales.js"> </script>
    </head>
<?php
if (@$_REQUEST["id_material"] != "")
{
	$sql="select * from materiales where id_material = '".@$_REQUEST["id_material"]."'";
}

if (@$_REQUEST["material_op"] == "buscar")
{
	$sql="select * from materiales where id_material = '".@$_REQUEST["id_material"]."'";
	
}
else if (@$_REQUEST["material_op"]=="cancelar")
{
	?> <script>//document.location='materiales.php';</script><?php
}
else if (@$_REQUEST["material_op"]=="primero")
{		
	$sql="select * from materiales where id_material = (select min(id_material) from materiales)";

}
else if (@$_REQUEST["material_op"]=="ultimo")
{
	$sql="select * from materiales where id_material = (select max(id_material) from materiales)";
	
}
else if (@$_REQUEST["material_op"]=="anterior")
{
	$sql=registro_anterior("materiales","id_material",@$_REQUEST["id_material"],"id_material,des_material,sta_material");
	
}
else if (@$_REQUEST["material_op"]=="siguiente")
{
	$sql=registro_siguiente("materiales","id_material",@$_REQUEST["id_material"],"id_material,des_material,sta_material");
	
}

	
if ((@$_REQUEST["id_material"] != "" || @$_REQUEST["material_op"] == "primero" || 
	@$_REQUEST["material_op"] == "ultimo" || @$_REQUEST["material_op"] == "anterior" || 
	@$_REQUEST["material_op"] == "siguiente") && @$_REQUEST["material_op"] != "cancelar")
{
	$result10=pg_query($bd_conexion,$sql);
	if(pg_num_rows($result10)>0)
	{
		$id_material = pg_fetch_result($result10,0,"id_material");
		$des_material = pg_fetch_result($result10,0,"des_material");
		$sta_material = pg_fetch_result($result10,0,"sta_material");
		
	}
	else if (@$_REQUEST["material_op"] == "buscar")
	{				
		$id_material = @$_REQUEST["id_material"];
		$des_material = "";
		$sta_material = "";
	}
}
else if (@$_REQUEST["material_op"] == "cancelar" || @$_REQUEST["material_op"] == "guardar")
{				
	$id_material = "";
	$des_material = "";
	$sta_material = "";
}

	
if (@$_REQUEST["material_op"]=="guardar" && @$_REQUEST["id_material"]!= "" && @$_REQUEST["des_material"] != "" && @$_REQUEST["sta_material"] != "")
{
		$sql="select * from materiales where id_material = '".@$_REQUEST["id_material"]."'";
		$result10=pg_query($bd_conexion,$sql);
		if(pg_num_rows($result10)==0)
		{
			$sql = "Insert into materiales(id_material, des_material, sta_material) values ('".@$_REQUEST["id_material"]."', UPPER('".@$_REQUEST["des_material"]."'), '".@$_REQUEST["sta_material"]."')";
			$result10 = pg_query($bd_conexion,$sql);
			echo "<SCRIPT LANGUAGE='javascript'>swal('El material se registró','correctamente', 'success');</script>";
		}
		else
		{
			$sql = "update materiales set des_material = UPPER('".@$_REQUEST["des_material"]."'), sta_material = '".@$_REQUEST["sta_material"]."' where id_material='".@$_REQUEST["id_material"]."'";
			$result10 = pg_query($bd_conexion,$sql);
			echo "<SCRIPT LANGUAGE='javascript'>swal('El material se actualizó','correctamente', 'success');</script>";
		}
}
else
{
?>
	<div id="materiales">
	<table width="700" align="center" class="tbldatos1">
<tr><td colspan="2" align="center" class="fondo_fila_amarilla">Parametrización de Materiales</td>
   </tr>    
		<tr>
        
			<td width="80">Id del material</td>
			<td><input type="text" id="id_material" name="id_material" maxlength="4" value="<?php echo $id_material; ?>" size="20" onChange="verificar_material('buscar');" onKeyPress="enter2tab(event,'des_material',0);return solo_numeros(event);" /> Formato: (1234)</td>
		</tr>
			<td width="80">Descripci&oacute;n</td>
			<td><input type="text" id="des_material" name="des_material" maxlength="30" value="<?php echo $des_material; ?>" size="100" onKeyPress="enter2tab(event,'material_guardar',0);"/></td>
		</tr>
		<tr>
		<td width="100">Estatus</td>
		<td  align="left">
			<input type="radio" id="sta_material" name="sta_material" checked="checked" value="A" <?php if (pg_num_rows($result10)>0 && pg_fetch_result($result10,0,"sta_material")=="A") echo "CHECKED";?>>Activo
		</td>
		</tr>
		<tr>
		<td>
		</td>
		<td>
			<input type="radio" id="sta_material" name="sta_material" value="I" <?php if (pg_num_rows($result10)>0 && pg_fetch_result($result10,0,"sta_material")=="I") echo "CHECKED";?>>Inactivo

		</td>
	</tr>
	</table>	
</div>
<?php 
}	
?>
</html>