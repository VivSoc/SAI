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
        <script type="text/javascript" src="javascript/parametrizacion/inventario/marcas.js"> </script>
    </head>
<?php
if (@$_REQUEST["id_marca"] != "")
{
	$sql="select * from marcas where id_marca = '".@$_REQUEST["id_marca"]."'";
}

if (@$_REQUEST["marca_op"] == "buscar")
{
	$sql="select * from marcas where id_marca = '".@$_REQUEST["id_marca"]."'";
	
}
else if (@$_REQUEST["marca_op"]=="cancelar")
{
	?> <script>//document.location='marcas.php';</script><?php
}
else if (@$_REQUEST["marca_op"]=="primero")
{		
	$sql="select * from marcas where id_marca = (select min(id_marca) from marcas)";

}
else if (@$_REQUEST["marca_op"]=="ultimo")
{
	$sql="select * from marcas where id_marca = (select max(id_marca) from marcas)";
	
}
else if (@$_REQUEST["marca_op"]=="anterior")
{
	$sql=registro_anterior("marcas","id_marca",@$_REQUEST["id_marca"],"id_marca,des_marca,sta_marca");
	
}
else if (@$_REQUEST["marca_op"]=="siguiente")
{
	$sql=registro_siguiente("marcas","id_marca",@$_REQUEST["id_marca"],"id_marca,des_marca,sta_marca");
	
}

	
if ((@$_REQUEST["id_marca"] != "" || @$_REQUEST["marca_op"] == "primero" || 
	@$_REQUEST["marca_op"] == "ultimo" || @$_REQUEST["marca_op"] == "anterior" || 
	@$_REQUEST["marca_op"] == "siguiente") && @$_REQUEST["marca_op"] != "cancelar")
{
	$result10=pg_query($bd_conexion,$sql);
	if(pg_num_rows($result10)>0)
	{
		$id_marca = pg_fetch_result($result10,0,"id_marca");
		$des_marca = pg_fetch_result($result10,0,"des_marca");
		$sta_marca = pg_fetch_result($result10,0,"sta_marca");
		
	}
	else if (@$_REQUEST["marca_op"] == "buscar")
	{				
		$id_marca = @$_REQUEST["id_marca"];
		$des_marca = "";
		$sta_marca = "";
	}
}
else if (@$_REQUEST["marca_op"] == "cancelar" || @$_REQUEST["marca_op"] == "guardar")
{				
	$id_marca = "";
	$des_marca = "";
	$sta_marca = "";
}

	
if (@$_REQUEST["marca_op"]=="guardar" && @$_REQUEST["id_marca"]!= "" && @$_REQUEST["des_marca"] != "" && @$_REQUEST["sta_marca"] != "")
{
		$sql="select * from marcas where id_marca = '".@$_REQUEST["id_marca"]."'";
		$result10=pg_query($bd_conexion,$sql);
		if(pg_num_rows($result10)==0)
		{
			$sql = "Insert into marcas(id_marca, des_marca, sta_marca) values ('".@$_REQUEST["id_marca"]."', UPPER('".@$_REQUEST["des_marca"]."'), '".@$_REQUEST["sta_marca"]."')";
			$result10 = pg_query($bd_conexion,$sql);
			echo "<SCRIPT LANGUAGE='javascript'>swal('La marca se registró','correctamente', 'success');</script>";
		}
		else
		{
			$sql = "update marcas set des_marca = UPPER('".@$_REQUEST["des_marca"]."'), sta_marca = '".@$_REQUEST["sta_marca"]."' where id_marca='".@$_REQUEST["id_marca"]."'";
			$result10 = pg_query($bd_conexion,$sql);
			echo "<SCRIPT LANGUAGE='javascript'>swal('La marca se actualizó','correctamente', 'success');</script>";
		}
}
else
{
?>
	<div id="marcas">
	<table width="700" align="center" class="tbldatos1">
<tr><td colspan="2" align="center" class="fondo_fila_amarilla">Parametrización de Marcas</td>
   </tr>    
		<tr>
        
			<td width="80">Id de la Marca</td>
			<td><input type="text" id="id_marca" name="id_marca" maxlength="4" value="<?php echo $id_marca; ?>" size="20" onKeyPress="return solo_numeros(event);enter2tab(event,'des_marca',0);" onChange="verificar_marca('buscar');"  /> Formato: (1234)</td>
		</tr>
			<td width="80">Descripci&oacute;n</td>
			<td><input type="text" id="des_marca" name="des_marca" maxlength="30" value="<?php echo $des_marca; ?>" size="100" onKeyPress="enter2tab(event,'marca_guardar',0);"/></td>
		</tr>
		<tr>
		<td width="100">Estatus</td>
		<td  align="left">
			<input type="radio" id="sta_marca" name="sta_marca" checked="checked" value="A" <?php if (pg_num_rows($result10)>0 && pg_fetch_result($result10,0,"sta_marca")=="A") echo "CHECKED";?>>Activo
		</td>
		</tr>
		<tr>
		<td>
		</td>
		<td>
			<input type="radio" id="sta_marca" name="sta_marca" value="I" <?php if (pg_num_rows($result10)>0 && pg_fetch_result($result10,0,"sta_marca")=="I") echo "CHECKED";?>>Inactivo

		</td>
	</tr>
	</table>	
</div>
<?php 
}	
?>
</html>