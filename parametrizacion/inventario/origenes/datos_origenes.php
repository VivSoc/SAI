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
        <script type="text/javascript" src="javascript/parametrizacion/inventario/origenes.js"> </script>
    </head>
<?php
if (@$_REQUEST["id_origen"] != "")
{
	$sql="select * from origenes where id_origen = '".@$_REQUEST["id_origen"]."'";
}

if (@$_REQUEST["origen_op"] == "buscar")
{
	$sql="select * from origenes where id_origen = '".@$_REQUEST["id_origen"]."'";
	
}
else if (@$_REQUEST["origen_op"]=="cancelar")
{
	?> <script>//document.location='origenes.php';</script><?php
}
else if (@$_REQUEST["origen_op"]=="primero")
{		
	$sql="select * from origenes where id_origen = (select min(id_origen) from origenes)";

}
else if (@$_REQUEST["origen_op"]=="ultimo")
{
	$sql="select * from origenes where id_origen = (select max(id_origen) from origenes)";
	
}
else if (@$_REQUEST["origen_op"]=="anterior")
{
	$sql=registro_anterior("origenes","id_origen",@$_REQUEST["id_origen"],"id_origen,des_origen,sta_origen");
	
}
else if (@$_REQUEST["origen_op"]=="siguiente")
{
	$sql=registro_siguiente("origenes","id_origen",@$_REQUEST["id_origen"],"id_origen,des_origen,sta_origen");
	
}

	
if ((@$_REQUEST["id_origen"] != "" || @$_REQUEST["origen_op"] == "primero" || 
	@$_REQUEST["origen_op"] == "ultimo" || @$_REQUEST["origen_op"] == "anterior" || 
	@$_REQUEST["origen_op"] == "siguiente") && @$_REQUEST["origen_op"] != "cancelar")
{
	$result10=pg_query($bd_conexion,$sql);
	if(pg_num_rows($result10)>0)
	{
		$id_origen = pg_fetch_result($result10,0,"id_origen");
		$des_origen = pg_fetch_result($result10,0,"des_origen");
		$sta_origen = pg_fetch_result($result10,0,"sta_origen");
		
	}
	else if (@$_REQUEST["origen_op"] == "buscar")
	{				
		$id_origen = @$_REQUEST["id_origen"];
		$des_origen = "";
		$sta_origen = "";
	}
}
else if (@$_REQUEST["origen_op"] == "cancelar" || @$_REQUEST["origen_op"] == "guardar")
{				
	$id_origen = "";
	$des_origen = "";
	$sta_origen = "";
}

	
if (@$_REQUEST["origen_op"]=="guardar" && @$_REQUEST["id_origen"]!= "" && @$_REQUEST["des_origen"] != "" && @$_REQUEST["sta_origen"] != "")
{
		$sql="select * from origenes where id_origen = '".@$_REQUEST["id_origen"]."'";
		$result10=pg_query($bd_conexion,$sql);
		if(pg_num_rows($result10)==0)
		{
			$sql = "Insert into origenes(id_origen, des_origen, sta_origen) values ('".@$_REQUEST["id_origen"]."', UPPER('".@$_REQUEST["des_origen"]."'), '".@$_REQUEST["sta_origen"]."')";
			$result10 = pg_query($bd_conexion,$sql);
			echo "<SCRIPT LANGUAGE='javascript'>swal('El origen se registró','correctamente', 'success');</script>";
		}
		else
		{
			$sql = "update origenes set des_origen = UPPER('".@$_REQUEST["des_origen"]."'), sta_origen = '".@$_REQUEST["sta_origen"]."' where id_origen='".@$_REQUEST["id_origen"]."'";
			$result10 = pg_query($bd_conexion,$sql);
			echo "<SCRIPT LANGUAGE='javascript'>swal('El origen se actualizó','correctamente', 'success');</script>";
		}
}
else
{
?>
	<div id="origenes">
	<table width="700" align="center" class="tbldatos1">
<tr><td colspan="2" align="center" class="fondo_fila_amarilla">Parametrización de Origenes</td>
   </tr>    
		<tr>
        
			<td width="80">Id del origen</td>
			<td><input type="text" id="id_origen" name="id_origen" maxlength="4" value="<?php echo $id_origen; ?>" size="20" onChange="verificar_origen('buscar');" onKeyPress="enter2tab(event,'des_origen',0);return solo_numeros(event);" /> Formato: (1234)</td>
		</tr>
			<td width="80">Descripci&oacute;n</td>
			<td><input type="text" id="des_origen" name="des_origen" maxlength="30" value="<?php echo $des_origen; ?>" size="100" onKeyPress="enter2tab(event,'origen_guardar',0);"/></td>
		</tr>
		<tr>
		<td width="100">Estatus</td>
		<td  align="left">
			<input type="radio" id="sta_origen" name="sta_origen" checked="checked" value="A" <?php if (pg_num_rows($result10)>0 && pg_fetch_result($result10,0,"sta_origen")=="A") echo "CHECKED";?>>Activo
		</td>
		</tr>
		<tr>
		<td>
		</td>
		<td>
			<input type="radio" id="sta_origen" name="sta_origen" value="I" <?php if (pg_num_rows($result10)>0 && pg_fetch_result($result10,0,"sta_origen")=="I") echo "CHECKED";?>>Inactivo

		</td>
	</tr>
	</table>	
</div>
<?php 
}	
?>
</html>