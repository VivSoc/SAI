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
        <script type="text/javascript" src="javascript/parametrizacion/inventario/colores.js"> </script>
    </head>
<?php
if (@$_REQUEST["id_color"] != "")
{
	$sql="select * from colores where id_color = '".@$_REQUEST["id_color"]."'";
}

if (@$_REQUEST["color_op"] == "buscar")
{
	$sql="select * from colores where id_color = '".@$_REQUEST["id_color"]."'";
	
}
else if (@$_REQUEST["color_op"]=="cancelar")
{
	?> <script>//document.location='colores.php';</script><?php
}
else if (@$_REQUEST["color_op"]=="primero")
{		
	$sql="select * from colores where id_color = (select min(id_color) from colores)";

}
else if (@$_REQUEST["color_op"]=="ultimo")
{
	$sql="select * from colores where id_color = (select max(id_color) from colores)";
	
}
else if (@$_REQUEST["color_op"]=="anterior")
{
	$sql=registro_anterior("colores","id_color",@$_REQUEST["id_color"],"id_color,des_color,sta_color");
	
}
else if (@$_REQUEST["color_op"]=="siguiente")
{
	$sql=registro_siguiente("colores","id_color",@$_REQUEST["id_color"],"id_color,des_color,sta_color");
	
}

	
if ((@$_REQUEST["id_color"] != "" || @$_REQUEST["color_op"] == "primero" || 
	@$_REQUEST["color_op"] == "ultimo" || @$_REQUEST["color_op"] == "anterior" || 
	@$_REQUEST["color_op"] == "siguiente") && @$_REQUEST["color_op"] != "cancelar")
{
	$result10=pg_query($bd_conexion,$sql);
	if(pg_num_rows($result10)>0)
	{
		$id_color = pg_fetch_result($result10,0,"id_color");
		$des_color = pg_fetch_result($result10,0,"des_color");
		$sta_color = pg_fetch_result($result10,0,"sta_color");
		
	}
	else if (@$_REQUEST["color_op"] == "buscar")
	{				
		$id_color = @$_REQUEST["id_color"];
		$des_color = "";
		$sta_color = "";
	}
}
else if (@$_REQUEST["color_op"] == "cancelar" || @$_REQUEST["color_op"] == "guardar")
{				
	$id_color = "";
	$des_color = "";
	$sta_color = "";
}

	
if (@$_REQUEST["color_op"]=="guardar" && @$_REQUEST["id_color"]!= "" && @$_REQUEST["des_color"] != "" && @$_REQUEST["sta_color"] != "")
{
		$sql="select * from colores where id_color = '".@$_REQUEST["id_color"]."'";
		$result10=pg_query($bd_conexion,$sql);
		if(pg_num_rows($result10)==0)
		{
			$sql = "Insert into colores(id_color, des_color, sta_color) values ('".@$_REQUEST["id_color"]."', UPPER('".@$_REQUEST["des_color"]."'), '".@$_REQUEST["sta_color"]."')";
			$result10 = pg_query($bd_conexion,$sql);
			echo "<SCRIPT LANGUAGE='javascript'>swal('El color se registró','correctamente', 'success');</script>";
		}
		else
		{
			$sql = "update colores set des_color = UPPER('".@$_REQUEST["des_color"]."'), sta_color = '".@$_REQUEST["sta_color"]."' where id_color='".@$_REQUEST["id_color"]."'";
			$result10 = pg_query($bd_conexion,$sql);
			echo "<SCRIPT LANGUAGE='javascript'>swal('El color se actualizó','correctamente', 'success');</script>";
		}
}
else
{
?>
	<div id="colores">
	<table width="700" align="center" class="tbldatos1">
<tr><td colspan="2" align="center" class="fondo_fila_amarilla">Parametrización de Colores</td>
   </tr>    
		<tr>
        
			<td width="80">Id del Color</td>
			<td><input type="text" id="id_color" name="id_color" maxlength="4" value="<?php echo $id_color; ?>" size="20" onChange="verificar_color('buscar');" onKeyPress="enter2tab(event,'des_color',0);return solo_numeros(event);" /> Formato: (1234)</td>
		</tr>
			<td width="80">Descripci&oacute;n</td>
			<td><input type="text" id="des_color" name="des_color" maxlength="30" value="<?php echo $des_color; ?>" size="100" onKeyPress="enter2tab(event,'color_guardar',0);"/></td>
		</tr>
		<tr>
		<td width="100">Estatus</td>
		<td  align="left">
			<input type="radio" id="sta_color" name="sta_color" checked="checked" value="A" <?php if (pg_num_rows($result10)>0 && pg_fetch_result($result10,0,"sta_color")=="A") echo "CHECKED";?>>Activo
		</td>
		</tr>
		<tr>
		<td>
		</td>
		<td>
			<input type="radio" id="sta_color" name="sta_color" value="I" <?php if (pg_num_rows($result10)>0 && pg_fetch_result($result10,0,"sta_color")=="I") echo "CHECKED";?>>Inactivo

		</td>
	</tr>
	</table>	
</div>
<?php 
}	
?>
</html>