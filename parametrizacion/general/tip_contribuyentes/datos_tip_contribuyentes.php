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
        <script type="text/javascript" src="javascript/parametrizacion/general/tip_contribuyentes.js"> </script>
    </head>
<?php
if (@$_REQUEST["id_tip_contribuyente"] != "")
{
	$sql="select * from tipos_contribuyentes where id_tip_contribuyente = '".@$_REQUEST["id_tip_contribuyente"]."'";
	
}

if (@$_REQUEST["tip_contribuyente_op"] == "buscar")
{
	$sql="select * from tipos_contribuyentes where id_tip_contribuyente = '".@$_REQUEST["id_tip_contribuyente"]."'";
	
	
}
else if (@$_REQUEST["tip_contribuyente_op"]=="cancelar")
{
	?> <script>//document.location='tip_contribuyentes.php';</script><?php
}
else if (@$_REQUEST["tip_contribuyente_op"]=="primero")
{		
	$sql="select * from tipos_contribuyentes where id_tip_contribuyente = (select min(id_tip_contribuyente) from tipos_contribuyentes)";
	

}
else if (@$_REQUEST["tip_contribuyente_op"]=="ultimo")
{
	$sql="select * from tipos_contribuyentes where id_tip_contribuyente = (select max(id_tip_contribuyente) from tipos_contribuyentes)";
	
	
}
else if (@$_REQUEST["tip_contribuyente_op"]=="anterior")
{
	$sql=registro_anterior("tipos_contribuyentes","id_tip_contribuyente",@$_REQUEST["id_tip_contribuyente"],"id_tip_contribuyente,des_tip_contribuyente,sta_tip_contribuyente");
	
	
}
else if (@$_REQUEST["tip_contribuyente_op"]=="siguiente")
{
	$sql=registro_siguiente("tipos_contribuyentes","id_tip_contribuyente",@$_REQUEST["id_tip_contribuyente"],"id_tip_contribuyente,des_tip_contribuyente,sta_tip_contribuyente");
	
	
}

	
if ((@$_REQUEST["id_tip_contribuyente"] != "" || @$_REQUEST["tip_contribuyente_op"] == "primero" || 
	@$_REQUEST["tip_contribuyente_op"] == "ultimo" || @$_REQUEST["tip_contribuyente_op"] == "anterior" || 
	@$_REQUEST["tip_contribuyente_op"] == "siguiente") && @$_REQUEST["tip_contribuyente_op"] != "cancelar")
{
	$result10=pg_query($bd_conexion,$sql);
	if(pg_num_rows($result10)>0)
	{
		$id_tip_contribuyente = pg_fetch_result($result10,0,"id_tip_contribuyente");
		$des_tip_contribuyente = pg_fetch_result($result10,0,"des_tip_contribuyente");
		$sta_tip_contribuyente = pg_fetch_result($result10,0,"sta_tip_contribuyente");
		
	}
	else if (@$_REQUEST["tip_contribuyente_op"] == "buscar")
	{				
		$id_tip_contribuyente = @$_REQUEST["id_tip_contribuyente"];
		$des_tip_contribuyente = "";
		$sta_tip_contribuyente = "";
	}
}
else if (@$_REQUEST["tip_contribuyente_op"] == "cancelar" || @$_REQUEST["tip_contribuyente_op"] == "guardar")
{				
	$id_tip_contribuyente = "";
	$des_tip_contribuyente = "";
	$sta_tip_contribuyente = "";
}

	
if (@$_REQUEST["tip_contribuyente_op"]=="guardar" && @$_REQUEST["id_tip_contribuyente"]!= "" && @$_REQUEST["des_tip_contribuyente"] != "" && @$_REQUEST["sta_tip_contribuyente"] != "")
{
		$sql="select * from tipos_contribuyentes where id_tip_contribuyente = '".@$_REQUEST["id_tip_contribuyente"]."'";
		$result10=pg_query($bd_conexion,$sql);
		if(pg_num_rows($result10)==0)
		{
			$sql = "Insert into tipos_contribuyentes(id_tip_contribuyente, des_tip_contribuyente, sta_tip_contribuyente) values ('".@$_REQUEST["id_tip_contribuyente"]."', UPPER('".@$_REQUEST["des_tip_contribuyente"]."'), '".@$_REQUEST["sta_tip_contribuyente"]."')";
			$result10 = pg_query($bd_conexion,$sql);
			
			echo "<SCRIPT LANGUAGE='javascript'>swal('El tipo de contribuyente se registró','correctamente', 'success');</script>";
		}
		else
		{
			$sql = "update tipos_contribuyentes set des_tip_contribuyente = UPPER('".@$_REQUEST["des_tip_contribuyente"]."'), sta_tip_contribuyente = '".@$_REQUEST["sta_tip_contribuyente"]."' where id_tip_contribuyente='".@$_REQUEST["id_tip_contribuyente"]."'";
			$result10 = pg_query($bd_conexion,$sql);
			
			echo "<SCRIPT LANGUAGE='javascript'>swal('El tipo de contribuyente se actualizó','correctamente', 'success');</script>";
		}
}
else
{
?>
	<div id="tip_contribuyentes">
	<table width="700" align="center" class="tbldatos1">
<tr><td colspan="2" align="center" class="fondo_fila_amarilla">Parametrización de Tipos de Contribuyentes</td>
   </tr>    
		<tr>
        
			<td width="80">Id del tipo de contribuyente</td>
			<td><input type="text" id="id_tip_contribuyente" name="id_tip_contribuyente" maxlength="4" value="<?php echo $id_tip_contribuyente; ?>" size="20" onChange="verificar_tip_contribuyente('buscar');" onKeyPress="enter2tab(event,'des_tip_contribuyente',0);return solo_numeros(event);"  /> Formato: (1234)</td>
		</tr>
			<td width="80">Descripci&oacute;n</td>
			<td><input type="text" id="des_tip_contribuyente" name="des_tip_contribuyente" maxlength="30" value="<?php echo $des_tip_contribuyente; ?>" size="100" onKeyPress="enter2tab(event,'tip_contribuyente_guardar',0);"/></td>
		</tr>
		<tr>
		<td width="100">Estatus</td>
		<td  align="left">
			<input type="radio" id="sta_tip_contribuyente" name="sta_tip_contribuyente" checked="checked" value="A" <?php if (pg_num_rows($result10)>0 && pg_fetch_result($result10,0,"sta_tip_contribuyente")=="A") echo "CHECKED";?>>Activo
		</td>
		</tr>
		<tr>
		<td>
		</td>
		<td>
			<input type="radio" id="sta_tip_contribuyente" name="sta_tip_contribuyente" value="I" <?php if (pg_num_rows($result10)>0 && pg_fetch_result($result10,0,"sta_tip_contribuyente")=="I") echo "CHECKED";?>>Inactivo

		</td>
	</tr>
	</table>	
</div>
<?php 
}	
?>
</html>