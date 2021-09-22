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
        <script type="text/javascript" src="javascript/parametrizacion/general/parroquias.js"> </script>
    </head>
<?php

if (@$_REQUEST["id_parroquia_p"] != "")
{
	$sql="select * from parroquias where id_parroquia = '".@$_REQUEST["id_parroquia_p"]."' and id_provincia = '".@$_REQUEST["id_provincia_p"]."' and id_canton = '".@$_REQUEST["id_canton_p"]."'";
	
}

if (@$_REQUEST["parroquia_op"] == "buscar")
{
	$sql="select * from parroquias where id_parroquia = '".@$_REQUEST["id_parroquia_p"]."' and id_provincia = '".@$_REQUEST["id_provincia_p"]."' and id_canton = '".@$_REQUEST["id_canton_p"]."'";	
	
	
}
else if (@$_REQUEST["parroquia_op"]=="cancelar")
{
	?> <script>//document.location='parroquias.php';</script><?php
}
else if (@$_REQUEST["parroquia_op"]=="primero")
{		
	$sql="select * from parroquias where id_parroquia = (select min(id_parroquia) from parroquias where id_provincia = '".@$_REQUEST["id_provincia_p"]."' and id_canton='".@$_REQUEST["id_canton_p"]."') and id_provincia='".@$_REQUEST["id_provincia_p"]."' and id_canton='".@$_REQUEST["id_canton_p"]."'";
	

}
else if (@$_REQUEST["parroquia_op"]=="ultimo")
{
	$sql="select * from parroquias where id_parroquia = (select max(id_parroquia) from parroquias where id_provincia = '".@$_REQUEST["id_provincia_p"]."' and id_canton='".@$_REQUEST["id_canton_p"]."') and id_provincia='".@$_REQUEST["id_provincia_p"]."' and id_canton='".@$_REQUEST["id_canton_p"]."'";
	
	
}
else if (@$_REQUEST["parroquia_op"]=="anterior")
{
	if (@$_REQUEST["id_parroquia_p"]==primer_registro("parroquias where id_provincia = '".@$_REQUEST["id_provincia_p"]."' and id_canton='".@$_REQUEST["id_canton_p"]."'","id_parroquia"))
	{
		$sql="select * from parroquias where id_parroquia = (select max(id_parroquia) from parroquias where id_provincia = '".@$_REQUEST["id_provincia_p"]."'  and id_canton='".@$_REQUEST["id_canton_p"]."') and id_provincia='".@$_REQUEST["id_provincia_p"]."' and id_canton='".@$_REQUEST["id_canton_p"]."'";
		
	}
	else
	{
		if (@$_REQUEST["id_parroquia_p"]=="")
		{
			$sql="select * from parroquias where id_parroquia = (select min(id_parroquia) from parroquias where id_provincia = '".@$_REQUEST["id_provincia_p"]."'  and id_canton='".@$_REQUEST["id_canton_p"]."') and id_provincia='".@$_REQUEST["id_provincia_p"]."' and id_canton='".@$_REQUEST["id_canton_p"]."'";
			
		}
		else
		{
			$sql="select * from parroquias where id_parroquia < '".@$_REQUEST["id_parroquia_p"]."' and id_provincia='".@$_REQUEST["id_provincia_p"]."'  and id_canton='".@$_REQUEST["id_canton_p"]."' order by id_parroquia desc limit 1";
			
		}
	}
}
else if (@$_REQUEST["parroquia_op"]=="siguiente")
{
	if (@$_REQUEST["id_parroquia_p"]==ultimo_registro("parroquias where id_provincia = '".@$_REQUEST["id_provincia_p"]."' and id_canton='".@$_REQUEST["id_canton_p"]."'","id_parroquia"))
	{
		$sql="select * from parroquias where id_parroquia = (select min(id_parroquia) from parroquias where id_provincia = '".@$_REQUEST["id_provincia_p"]."'  and id_canton='".@$_REQUEST["id_canton_p"]."') and id_provincia='".@$_REQUEST["id_provincia_p"]."' and id_canton='".@$_REQUEST["id_canton_p"]."'";
	}
	else
	{
		if (@$_REQUEST["id_parroquia_p"]=="")
		{
			$sql="select * from parroquias where id_parroquia = (select max(id_parroquia) from parroquias where id_provincia = '".@$_REQUEST["id_provincia_p"]."' and id_canton='".@$_REQUEST["id_canton_p"]."') and id_provincia='".@$_REQUEST["id_provincia_p"]."' and id_canton='".@$_REQUEST["id_canton_p"]."'";
		}
		else
		{
			$sql="select * from parroquias where id_parroquia > '".@$_REQUEST["id_parroquia_p"]."' and id_provincia='".@$_REQUEST["id_provincia_p"]."' and id_canton='".@$_REQUEST["id_canton_p"]."' order by id_parroquia limit 1";
		}
	}
}

	
if ((@$_REQUEST["id_parroquia_p"] != "" || @$_REQUEST["parroquia_op"] == "primero" || 
	@$_REQUEST["parroquia_op"] == "ultimo" || @$_REQUEST["parroquia_op"] == "anterior" || 
	@$_REQUEST["parroquia_op"] == "siguiente") && @$_REQUEST["parroquia_op"] != "cancelar")
{
	$result10=pg_query($bd_conexion,$sql);
	if(pg_num_rows($result10)>0)
	{
		$id_parroquia_p = pg_fetch_result($result10,0,"id_parroquia");
		$des_parroquia_p = pg_fetch_result($result10,0,"des_parroquia");
		$sta_parroquia_p = pg_fetch_result($result10,0,"sta_parroquia");
		$id_provincia_p = pg_fetch_result($result10,0,"id_provincia");
		$id_canton_p = pg_fetch_result($result10,0,"id_canton");
		
	}
	else if (@$_REQUEST["parroquia_op"] == "buscar")
	{				
		$id_parroquia_p = @$_REQUEST["id_parroquia_p"];
		$des_parroquia_p = "";
		$id_provincia_p = @$_REQUEST["id_provincia_p"];
		$id_canton_p = @$_REQUEST["id_canton_p"];
		$sta_parroquia_p = "";
		
	}
}
else if (@$_REQUEST["parroquia_op"] == "cancelar" || @$_REQUEST["parroquia_op"] == "guardar")
{				
	$id_parroquia_p = "";
	$des_parroquia_p = "";
	$sta_parroquia_p = "";
	$id_provincia_p = "";
	$id_canton_p = "";
}
else if (@$_REQUEST["parroquia_op"] == "buscar")
{				
	$id_parroquia_p = "";
	$des_parroquia_p = "";
	$id_provincia_p = @$_REQUEST["id_provincia_p"];
	$id_canton_p = @$_REQUEST["id_canton_p"];
	$sta_parroquia_p = "";
}

	
if (@$_REQUEST["parroquia_op"]=="guardar" && @$_REQUEST["id_provincia_p"]!= "" && @$_REQUEST["id_canton_p"]!= ""&& @$_REQUEST["id_parroquia_p"]!= "" && @$_REQUEST["des_parroquia_p"] != "" && @$_REQUEST["sta_parroquia_p"] != "")
{
		$sql="select * from parroquias where id_provincia = '".@$_REQUEST["id_provincia_p"]."' and id_canton='".@$_REQUEST["id_canton_p"]."' and id_parroquia='".@$_REQUEST["id_parroquia_p"]."'";
	$result10=pg_query($bd_conexion,$sql);
	if(pg_num_rows($result10)==0)
	{
		$sql="Insert into parroquias (id_parroquia, des_parroquia, sta_parroquia, id_provincia, id_canton) 
			values ('".@$_REQUEST["id_parroquia_p"]."', upper('".@$_REQUEST["des_parroquia_p"]."'),'".@$_REQUEST["sta_parroquia_p"]."','".@$_REQUEST["id_provincia_p"]."','".@$_REQUEST["id_canton_p"]."')";
		$result10=pg_query($bd_conexion,$sql);
		echo "<SCRIPT LANGUAGE='javascript'>swal('La parroquia se registró','correctamente', 'success');</script>";
	}
	else
	{
		$sql="update parroquias set des_parroquia = upper('".@$_REQUEST["des_parroquia_p"]."'), sta_parroquia='".@$_REQUEST["sta_parroquia_p"]."', id_provincia='".@$_REQUEST["id_provincia_p"]."', id_canton='".@$_REQUEST["id_canton_p"]."'
			where id_parroquia = '".@$_REQUEST["id_parroquia_p"]."' and id_provincia = '".@$_REQUEST["id_provincia_p"]."' 
			and id_canton = '".@$_REQUEST["id_canton_p"]."'";
		$result10=pg_query($bd_conexion,$sql);
		
		echo "<SCRIPT LANGUAGE='javascript'>swal('La parroquia se actualizó','correctamente', 'success');</script>";
	}
}
else
{
?>
	<div id="parroquias">
	<table width="700" align="center" class="tbldatos1">
	<tr>
			<td width="80">Id de la Parroquia</td>
			<td><input type="text" id="id_parroquia_p" name="id_parroquia_p" maxlength="4" value="<?php echo $id_parroquia_p; ?>" size="20" onChange="verificar_parroquia('buscar');" onKeyPress="enter2tab(event,'des_parroquia_p',0);return solo_numeros(event);" /> Formato: (1234)</td>
		</tr>
			<td width="80">Descripci&oacute;n</td>
			<td><input type="text" id="des_parroquia_p" name="des_parroquia_p" maxlength="30" value="<?php echo $des_parroquia_p; ?>" size="100" onKeyPress="enter2tab(event,'parroquia_guardar',0);"/></td>
		</tr>
		<tr>
		<td width="100">Estatus</td>
		<td  align="left">
			<input type="radio" id="sta_parroquia_p" name="sta_parroquia_p" checked="checked" value="A" <?php if (pg_num_rows($result10)>0 && pg_fetch_result($result10,0,"sta_parroquia")=="A") echo "CHECKED";?>>Activo
		</td>
		</tr>
		<tr>
		<td>
		</td>
		<td>
			<input type="radio" id="sta_parroquia_p" name="sta_parroquia_p" value="I" <?php if (pg_num_rows($result10)>0 && pg_fetch_result($result10,0,"sta_parroquia")=="I") echo "CHECKED";?>>Inactivo

		</td>
	</tr>
	</table>	
</div>
<?php 
}	
?>
</html>