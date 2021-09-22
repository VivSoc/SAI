<?php 
require("../../../../configuracion/config.php");
require("../../../../configuracion/conexion.php");
require("../../../../clases/funciones.php");
require_once("../../../../clases/utilidades.class.php");
require("../../../../sesion.php");

?>
<html>
	<head>
        <link rel="stylesheet" href="css/sweetalert.css" type="text/css">
        <script type="text/javascript" src="javascript/sweetalert.min.js"></script>
        <script type="text/javascript" src="javascript/parametrizacion/general/cantones.js"> </script>
    </head>
<?php

if (@$_REQUEST["id_canton_c"] != "")
{
	$sql="select * from cantones where id_canton = '".@$_REQUEST["id_canton_c"]."' and id_provincia = '".@$_REQUEST["id_provincia_c"]."'";
	

}

if (@$_REQUEST["canton_op"] == "buscar")
{
	$sql="select * from cantones where id_canton = '".@$_REQUEST["id_canton_c"]."' and id_provincia = '".@$_REQUEST["id_provincia_c"]."'";
	
	
}
else if (@$_REQUEST["canton_op"]=="cancelar")
{
	?> <script>//document.location='cantones.php';</script><?php
}
else if (@$_REQUEST["canton_op"]=="primero")
{		
	$sql="select * from cantones where id_canton = (select min(id_canton) from cantones where id_provincia = '".@$_REQUEST["id_provincia_c"]."' ) and id_provincia='".@$_REQUEST["id_provincia_c"]."'";

}
else if (@$_REQUEST["canton_op"]=="ultimo")
{
	$sql="select * from cantones where id_canton = (select max(id_canton) from cantones where id_provincia = '".@$_REQUEST["id_provincia_c"]."' ) and id_provincia='".@$_REQUEST["id_provincia_c"]."'";
	
}
else if (@$_REQUEST["canton_op"]=="anterior")
{
	
	if (@$_REQUEST["id_canton_c"]==primer_registro("cantones where id_provincia = '".@$_REQUEST["id_provincia_c"]."'","id_canton"))
	
	{
		$sql="select * from cantones where id_canton = (select max(id_canton) from cantones where id_provincia = '".@$_REQUEST["id_provincia_c"]."') and id_provincia='".@$_REQUEST["id_provincia_c"]."'";
		
	}
	else
	{
		if (@$_REQUEST["canton_op"]=="")
		{
			$sql="select * from cantones where id_canton = (select min(id_canton) from cantones where id_provincia = '".@$_REQUEST["id_provincia_c"]."') and id_provincia='".@$_REQUEST["id_provincia_c"]."'";
			
		}
		else
		{
			$sql="select * from cantones where id_canton < '".@$_REQUEST["id_canton_c"]."' and id_provincia='".@$_REQUEST["id_provincia_c"]."' order by id_canton desc limit 1";
			
		}
	}
}
	
else if (@$_REQUEST["canton_op"]=="siguiente")
{
	
	{
	if (@$_REQUEST["id_canton_c"]==ultimo_registro("cantones where id_provincia = '".@$_REQUEST["id_provincia_c"]."'","id_canton"))
	{
		$sql="select * from cantones where id_canton = (select min(id_canton) from cantones where id_provincia = '".@$_REQUEST["id_provincia_c"]."') and id_provincia='".@$_REQUEST["id_provincia_c"]."'";
		
	}
	else
	{
		if (@$_REQUEST["canton_op"]=="")
		{
			$sql="select * from cantones where id_canton = (select max(id_canton) from cantones where id_provincia = '".@$_REQUEST["id_provincia_c"]."') and id_provincia='".@$_REQUEST["id_provincia_c"]."'";
			
		}
		else
		{
			$sql="select * from cantones where id_canton > '".@$_REQUEST["id_canton_c"]."' and id_provincia='".@$_REQUEST["id_provincia_c"]."' order by id_canton limit 1";
			
			
		}
	}
}
}

	
if ((@$_REQUEST["id_canton_c"] != "" || @$_REQUEST["canton_op"] == "primero" || 
	@$_REQUEST["canton_op"] == "ultimo" || @$_REQUEST["canton_op"] == "anterior" || 
	@$_REQUEST["canton_op"] == "siguiente") && @$_REQUEST["canton_op"] != "cancelar")
{

	$result10=pg_query($bd_conexion,$sql);
	if(pg_num_rows($result10)>0)
	{
		$id_canton_c = pg_fetch_result($result10,0,"id_canton");
		$des_canton_c = pg_fetch_result($result10,0,"des_canton");
		$sta_canton_c = pg_fetch_result($result10,0,"sta_canton");
		$id_provincia_c = pg_fetch_result($result10,0,"id_provincia");
		
	}
	else if (@$_REQUEST["canton_op"] == "buscar")
	{	
				
		$id_canton_c = @$_REQUEST["id_canton_c"];
		$des_canton_c = "";
		$sta_canton_c = "";
		$id_provincia_c = "";
	}
}
else if (@$_REQUEST["canton_op"] == "cancelar" || @$_REQUEST["canton_op"] == "guardar")
{				
	$id_canton_c = "";
	$des_canton_c = "";
	$sta_canton_c= "";
	$id_provincia_c = "";
}
	
	
if (@$_REQUEST["canton_op"]=="guardar" && @$_REQUEST["id_canton_c"]!= "" && @$_REQUEST["des_canton_c"] != "" && @$_REQUEST["sta_canton_c"] != "" && @$_REQUEST["id_provincia_c"] != "")
{
		$sql="select * from cantones where id_canton = '".@$_REQUEST["id_canton_c"]."' and id_provincia = '".@$_REQUEST["id_provincia_c"]."'";
	
		$result10=pg_query($bd_conexion,$sql);
		if(pg_num_rows($result10)==0)
		{
			$sql = "Insert into cantones(id_canton, des_canton, sta_canton, id_provincia) values ('".@$_REQUEST["id_canton_c"]."', UPPER('".@$_REQUEST["des_canton_c"]."'), '".@$_REQUEST["sta_canton_c"]."', '".@$_REQUEST["id_provincia_c"]."')";
			$result10 = pg_query($bd_conexion,$sql);
			
			echo "<SCRIPT LANGUAGE='javascript'>swal('El cantón se registró','correctamente', 'success');</script>";
			
		}
		else
		{
			$sql = "update cantones set des_canton = UPPER('".@$_REQUEST["des_canton_c"]."'), sta_canton = '".@$_REQUEST["sta_canton_c"]."', id_provincia = '".@$_REQUEST["id_provincia_c"]."' where id_canton='".@$_REQUEST["id_canton_c"]."' and id_provincia = '".@$_REQUEST["id_provincia_c"]."'";
			$result10 = pg_query($bd_conexion,$sql);
			
			echo "<SCRIPT LANGUAGE='javascript'>swal('El cantón se actualizó','correctamente', 'success');</script>";
			
		}
}
else
{
?>
	<div id="cantones">
		<table width="700" align="center" class="tbldatos1">
<tr><td colspan="2" align="center" class="fondo_fila_amarilla">Parametización de Cantones</td>
   </tr>    
		<tr>
			<td  width="120">Provincia</td>
			<td >
					<input type="text" value="<?php echo @$_REQUEST["id_provincia_c"]; ?>" id="id_provincia_c" name="id_provincia_c" size="10" maxlength="4" onKeyUp="CodigoToSelect(document.getElementById('id_provincia_c').value,document.getElementById('des_provincia_c'))" onKeyPress="enter2tab(event,'des_provincia_c',0); return solo_numeros(event);" />
					<select id="des_provincia_c" name="des_provincia_c" onChange="document.getElementById('id_provincia_c').value=document.getElementById('des_provincia_c').options[document.getElementById('des_provincia_c').selectedIndex].value; " onkeypress="enter2tab(event,'id_provincia_c',0);">
						<option value="">Seleccione</option>
						<?php 
						
						$result=pg_query($bd_conexion,"select * from provincias where sta_provincia='A' order by id_provincia");
						while ($registro=pg_fetch_assoc($result))
						{
							if ($registro["id_provincia"] == $id_provincia_c)
							{
								echo "<option value=\"".$registro["id_provincia"]."\" selected=selected>".$registro["id_provincia"]." - ".$registro["des_provincia"]."</option>";
							}
							else
							{
								echo "<option value=\"".$registro["id_provincia"]."\">".$registro["id_provincia"]." - ".$registro["des_provincia"]."</option>";
							}
						}
						?>
					</select>
				</td>
			</tr>
		</table>
	
		<br />
	
    <table width="700" align="center" class="tbldatos1">
		<tr>
			<td width="120">C&oacute;digo del Cantón</td>
			<td><input type="text" id="id_canton_c" name="id_canton_c" value="<?php echo $id_canton_c; ?>" maxlength="4" size="10" onChange="verificar_canton('buscar');" onKeyPress="enter2tab(event,'des_canton_c',0);"/></td>
		</tr>
		<tr>
			<td width="120">Nombre del Cantón</td>
			<td><input type="text" id="des_canton_c" name="des_canton_c" value="<?php echo $des_canton_c; ?>"maxlength="50" size="100" onKeyPress="enter2tab(event,'sta_canton_c',0);"/></td>
		</tr>
		<tr>
		<td width="152">Estatus</td>
		<td  align="left">
			<input type="radio" id="sta_canton_c" name="sta_canton_c" checked="checked" value="A" <?php if (pg_num_rows($result10)>0 && pg_fetch_result($result10,0,"sta_canton")=="A") echo "CHECKED";?>>Activo

			<input type="radio" id="sta_canton_c" name="sta_canton_c" value="I" <?php if (pg_num_rows($result10)>0 && pg_fetch_result($result10,0,"sta_canton")=="I") echo "CHECKED";?>>Inactivo
		</tr>
	</table>	
	</div>	
<?php 
}	
?>