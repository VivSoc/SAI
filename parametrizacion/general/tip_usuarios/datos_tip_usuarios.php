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
        <script type="text/javascript" src="javascript/parametrizacion/general/tip_usuarios.js"> </script>
    </head>
<?php
if (@$_REQUEST["id_tip_usuario"] != "")
{
	$sql="select * from tipos_usuarios where id_tip_usuario = '".@$_REQUEST["id_tip_usuario"]."'";
}

if (@$_REQUEST["tip_usuario_op"] == "buscar")
{
	$sql="select * from tipos_usuarios where id_tip_usuario = '".@$_REQUEST["id_tip_usuario"]."'";
	
}
else if (@$_REQUEST["tipos_usuario_op"]=="cancelar")
{
	?> <script>//document.location='tip_usuarios.php';</script><?php
}
else if (@$_REQUEST["tip_usuario_op"]=="primero")
{		
	$sql="select * from tipos_usuarios where id_tip_usuario = (select min(id_tip_usuario) from tipos_usuarios)";

}
else if (@$_REQUEST["tip_usuario_op"]=="ultimo")
{
	$sql="select * from tipos_usuarios where id_tip_usuario = (select max(id_tip_usuario) from tipos_usuarios)";
	
}
else if (@$_REQUEST["tip_usuario_op"]=="anterior")
{
	$sql=registro_anterior("tipos_usuarios","id_tip_usuario",@$_REQUEST["id_tip_usuario"],"id_tip_usuario,des_tip_usuario,sta_tip_usuario");
	
}
else if (@$_REQUEST["tip_usuario_op"]=="siguiente")
{
	$sql=registro_siguiente("tipos_usuarios","id_tip_usuario",@$_REQUEST["id_tip_usuario"],"id_tip_usuario,des_tip_usuario,sta_tip_usuario");
	
}

	
if ((@$_REQUEST["id_tip_usuario"] != "" || @$_REQUEST["tip_usuario_op"] == "primero" || 
	@$_REQUEST["tip_usuario_op"] == "ultimo" || @$_REQUEST["tip_usuario_op"] == "anterior" || 
	@$_REQUEST["tip_usuario_op"] == "siguiente") && @$_REQUEST["tip_usuario_op"] != "cancelar")
{
	$result10=pg_query($bd_conexion,$sql);
	if(pg_num_rows($result10)>0)
	{
		$id_tip_usuario = pg_fetch_result($result10,0,"id_tip_usuario");
		$des_tip_usuario = pg_fetch_result($result10,0,"des_tip_usuario");
		$sta_tip_usuario = pg_fetch_result($result10,0,"sta_tip_usuario");
		
	}
	else if (@$_REQUEST["tip_usuario_op"] == "buscar")
	{				
		$id_tip_usuario = @$_REQUEST["id_tip_usuario"];
		$des_tip_usuario = "";
		$sta_tip_usuario = "";
	}
}
else if (@$_REQUEST["tip_usuario_op"] == "cancelar" || @$_REQUEST["tip_usuario_op"] == "guardar")
{				
	$id_tip_usuario = "";
	$des_tip_usuario = "";
	$sta_tip_usuario = "";
}

	
if (@$_REQUEST["tip_usuario_op"]=="guardar" && @$_REQUEST["id_tip_usuario"]!= "" && @$_REQUEST["des_tip_usuario"] != "" && @$_REQUEST["sta_tip_usuario"] != "")
{
		$sql="select * from tipos_usuarios where id_tip_usuario = '".@$_REQUEST["id_tip_usuario"]."'";
		$result10=pg_query($bd_conexion,$sql);
		if(pg_num_rows($result10)==0)
		{
			$sql = "Insert into tipos_usuarios(id_tip_usuario, des_tip_usuario, sta_tip_usuario) values ('".@$_REQUEST["id_tip_usuario"]."', UPPER('".@$_REQUEST["des_tip_usuario"]."'), '".@$_REQUEST["sta_tip_usuario"]."')";
			$result10 = pg_query($bd_conexion,$sql);
			echo "<SCRIPT LANGUAGE='javascript'>swal('El tipo de usuario se registró','correctamente', 'success');</script>";
		}
		else
		{
			$sql = "update tipos_usuarios set des_tip_usuario = UPPER('".@$_REQUEST["des_tip_usuario"]."'), sta_tip_usuario = '".@$_REQUEST["sta_tip_usuario"]."' where id_tip_usuario='".@$_REQUEST["id_tip_usuario"]."'";
			$result10 = pg_query($bd_conexion,$sql);
			echo "<SCRIPT LANGUAGE='javascript'>swal('El tipo de usuario se actualizó','correctamente', 'success');</script>";
		}
}
else
{
?>
	<div id="tip_usuarios">
	<table width="700" align="center" class="tbldatos1">
<tr><td colspan="2" align="center" class="fondo_fila_amarilla">Parametrización de Tipos de Usuarios</td>
   </tr>    
		<tr>
        
			<td width="80">Id del tipo de usuario</td>
			<td><input type="text" id="id_tip_usuario" name="id_tip_usuario" maxlength="4" value="<?php echo $id_tip_usuario; ?>" size="20" onChange="verificar_tip_usuario('buscar');" onKeyPress="enter2tab(event,'des_tip_usuario',0);return solo_numeros(event);" /> Formato: (1234)</td>
		</tr>
			<td width="80">Descripci&oacute;n</td>
			<td><input type="text" id="des_tip_usuario" name="des_tip_usuario" maxlength="30" value="<?php echo $des_tip_usuario; ?>" size="100" onKeyPress="enter2tab(event,'tip_usuario_guardar',0);"/></td>
		</tr>
		<tr>
		<td width="100">Estatus</td>
		<td  align="left">
			<input type="radio" id="sta_tip_usuario" name="sta_tip_usuario" checked="checked" value="A" <?php if (pg_num_rows($result10)>0 && pg_fetch_result($result10,0,"sta_tip_usuario")=="A") echo "CHECKED";?>>Activo
		</td>
		</tr>
		<tr>
		<td>
		</td>
		<td>
			<input type="radio" id="sta_tip_usuario" name="sta_tip_usuario" value="I" <?php if (pg_num_rows($result10)>0 && pg_fetch_result($result10,0,"sta_tip_usuario")=="I") echo "CHECKED";?>>Inactivo

		</td>
	</tr>
	</table>	
</div>
<?php 
}	
?>
</html>