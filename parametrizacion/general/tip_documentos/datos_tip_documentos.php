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
        <script type="text/javascript" src="javascript/parametrizacion/general/tip_documentos.js"> </script>
    </head>
<?php
if (@$_REQUEST["id_tip_documento"] != "")
{
	$sql="select * from tipos_documentos where id_tip_documento = '".@$_REQUEST["id_tip_documento"]."'";
	
}

if (@$_REQUEST["tip_documento_op"] == "buscar")
{
	$sql="select * from tipos_documentos where id_tip_documento = '".@$_REQUEST["id_tip_documento"]."'";
	
	
}
else if (@$_REQUEST["tip_documento_op"]=="cancelar")
{
	?> <script>//document.location='tip_documentos.php';</script><?php
}
else if (@$_REQUEST["tip_documento_op"]=="primero")
{		
	$sql="select * from tipos_documentos where id_tip_documento = (select min(id_tip_documento) from tipos_documentos)";
	

}
else if (@$_REQUEST["tip_documento_op"]=="ultimo")
{
	$sql="select * from tipos_documentos where id_tip_documento = (select max(id_tip_documento) from tipos_documentos)";
	
	
}
else if (@$_REQUEST["tip_documento_op"]=="anterior")
{
	$sql=registro_anterior("tipos_documentos","id_tip_documento",@$_REQUEST["id_tip_documento"],"id_tip_documento,des_tip_documento,sta_tip_documento");
	
	
}
else if (@$_REQUEST["tip_documento_op"]=="siguiente")
{
	$sql=registro_siguiente("tipos_documentos","id_tip_documento",@$_REQUEST["id_tip_documento"],"id_tip_documento,des_tip_documento,sta_tip_documento");
	
	
}

	
if ((@$_REQUEST["id_tip_documento"] != "" || @$_REQUEST["tip_documento_op"] == "primero" || 
	@$_REQUEST["tip_documento_op"] == "ultimo" || @$_REQUEST["tip_documento_op"] == "anterior" || 
	@$_REQUEST["tip_documento_op"] == "siguiente") && @$_REQUEST["tip_documento_op"] != "cancelar")
{
	$result10=pg_query($bd_conexion,$sql);
	if(pg_num_rows($result10)>0)
	{
		$id_tip_documento = pg_fetch_result($result10,0,"id_tip_documento");
		$des_tip_documento = pg_fetch_result($result10,0,"des_tip_documento");
		$sta_tip_documento = pg_fetch_result($result10,0,"sta_tip_documento");
		
	}
	else if (@$_REQUEST["tip_documento_op"] == "buscar")
	{				
		$id_tip_documento = @$_REQUEST["id_tip_documento"];
		$des_tip_documento = "";
		$sta_tip_documento = "";
	}
}
else if (@$_REQUEST["tip_documento_op"] == "cancelar" || @$_REQUEST["tip_documento_op"] == "guardar")
{				
	$id_tip_documento = "";
	$des_tip_documento = "";
	$sta_tip_documento = "";
}

	
if (@$_REQUEST["tip_documento_op"]=="guardar" && @$_REQUEST["id_tip_documento"]!= "" && @$_REQUEST["des_tip_documento"] != "" && @$_REQUEST["sta_tip_documento"] != "")
{
		$sql="select * from tipos_documentos where id_tip_documento = '".@$_REQUEST["id_tip_documento"]."'";
		$result10=pg_query($bd_conexion,$sql);
		if(pg_num_rows($result10)==0)
		{
			$sql = "Insert into tipos_documentos(id_tip_documento, des_tip_documento, sta_tip_documento) values ('".@$_REQUEST["id_tip_documento"]."', UPPER('".@$_REQUEST["des_tip_documento"]."'), '".@$_REQUEST["sta_tip_documento"]."')";
			$result10 = pg_query($bd_conexion,$sql);
			
			echo "<SCRIPT LANGUAGE='javascript'>swal('El tipo de documento se registró','correctamente', 'success');</script>";
		}
		else
		{
			$sql = "update tipos_documentos set des_tip_documento = UPPER('".@$_REQUEST["des_tip_documento"]."'), sta_tip_documento = '".@$_REQUEST["sta_tip_documento"]."' where id_tip_documento='".@$_REQUEST["id_tip_documento"]."'";
			$result10 = pg_query($bd_conexion,$sql);
			
			echo "<SCRIPT LANGUAGE='javascript'>swal('El tipo de documento se actualizó','correctamente', 'success');</script>";
		}
}
else
{
?>
	<div id="tip_documentos">
	<table width="700" align="center" class="tbldatos1">
<tr><td colspan="2" align="center" class="fondo_fila_amarilla">Parametrización de Tipos de Documentos</td>
   </tr>    
		<tr>
        
			<td width="80">Id del tipo de Documento</td>
			<td><input type="text" id="id_tip_documento" name="id_tip_documento" maxlength="4" value="<?php echo $id_tip_documento; ?>" size="20" onChange="verificar_tip_documento('buscar');" onKeyPress="enter2tab(event,'des_tip_documento',0);return solo_numeros(event);" /> Formato: (1234)</td>
		</tr>
			<td width="80">Descripci&oacute;n</td>
			<td><input type="text" id="des_tip_documento" name="des_tip_documento" maxlength="30" value="<?php echo $des_tip_documento; ?>" size="100" onKeyPress="enter2tab(event,'tip_documento_guardar',0);"/></td>
		</tr>
		<tr>
		<td width="100">Estatus</td>
		<td  align="left">
			<input type="radio" id="sta_tip_documento" name="sta_tip_documento" checked="checked" value="A" <?php if (pg_num_rows($result10)>0 && pg_fetch_result($result10,0,"sta_tip_documento")=="A") echo "CHECKED";?>>Activo
		</td>
		</tr>
		<tr>
		<td>
		</td>
		<td>
			<input type="radio" id="sta_tip_documento" name="sta_tip_documento" value="I" <?php if (pg_num_rows($result10)>0 && pg_fetch_result($result10,0,"sta_tip_documento")=="I") echo "CHECKED";?>>Inactivo

		</td>
	</tr>
	</table>	
</div>
<?php 
}	
?>
</html>