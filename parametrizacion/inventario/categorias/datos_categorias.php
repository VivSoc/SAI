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
        <script type="text/javascript" src="javascript/parametrizacion/inventario/categorias.js"> </script>
    </head>
<?php
if (@$_REQUEST["id_categoria"] != "")
{
	$sql="select * from categorias where id_categoria = '".@$_REQUEST["id_categoria"]."'";
}

if (@$_REQUEST["categoria_op"] == "buscar")
{
	$sql="select * from categorias where id_categoria = '".@$_REQUEST["id_categoria"]."'";
		$x=pg_query($sql);
			if(pg_num_rows($x)>0)
			{
				echo "<SCRIPT LANGUAGE='javascript'>document.getElementById('pre_categoria').disabled='true'</SCRIPT> "; 
			}
			else
			{
				echo "<SCRIPT LANGUAGE='javascript'>document.getElementById('pre_categoria').enabled='true'</SCRIPT> "; 
			}
	
}
else if (@$_REQUEST["categoria_op"]=="cancelar")
{
	?> <script>//document.location='categorias.php';</script><?php
}
else if (@$_REQUEST["categoria_op"]=="primero")
{		
	$sql="select * from categorias where id_categoria = (select min(id_categoria) from categorias)";
	$x=pg_query($sql);
			if(pg_num_rows($x)>0)
			{
				echo "<SCRIPT LANGUAGE='javascript'>document.getElementById('pre_categoria').disabled='true'</SCRIPT> "; 
			}
			else
			{
				echo "<SCRIPT LANGUAGE='javascript'>document.getElementById('pre_categoria').enabled='true'</SCRIPT> "; 
			}
}
else if (@$_REQUEST["categoria_op"]=="ultimo")
{
	$sql="select * from categorias where id_categoria = (select max(id_categoria) from categorias)";
	$x=pg_query($sql);
			if(pg_num_rows($x)>0)
			{
				echo "<SCRIPT LANGUAGE='javascript'>document.getElementById('pre_categoria').disabled='true'</SCRIPT> "; 
			}
			else
			{
				echo "<SCRIPT LANGUAGE='javascript'>document.getElementById('pre_categoria').enabled='true'</SCRIPT> "; 
			}
}
else if (@$_REQUEST["categoria_op"]=="anterior")
{
	$sql=registro_anterior("categorias","id_categoria",@$_REQUEST["id_categoria"],"id_categoria,des_categoria,pre_categoria,sta_categoria");
	$x=pg_query($sql);
			if(pg_num_rows($x)>0)
			{
				echo "<SCRIPT LANGUAGE='javascript'>document.getElementById('pre_categoria').disabled='true'</SCRIPT> "; 
			}
			else
			{
				echo "<SCRIPT LANGUAGE='javascript'>document.getElementById('pre_categoria').enabled='true'</SCRIPT> "; 
			}
}
else if (@$_REQUEST["categoria_op"]=="siguiente")
{
	$sql=registro_siguiente("categorias","id_categoria",@$_REQUEST["id_categoria"],"id_categoria,des_categoria,pre_categoria,sta_categoria");
	$x=pg_query($sql);
			if(pg_num_rows($x)>0)
			{
				echo "<SCRIPT LANGUAGE='javascript'>document.getElementById('pre_categoria').disabled='true'</SCRIPT> "; 
			}
			else
			{
				echo "<SCRIPT LANGUAGE='javascript'>document.getElementById('pre_categoria').enabled='true'</SCRIPT> "; 
			}
}

	
if ((@$_REQUEST["id_categoria"] != "" || @$_REQUEST["categoria_op"] == "primero" || 
	@$_REQUEST["categoria_op"] == "ultimo" || @$_REQUEST["categoria_op"] == "anterior" || 
	@$_REQUEST["categoria_op"] == "siguiente") && @$_REQUEST["categoria_op"] != "cancelar")
{
	$result10=pg_query($bd_conexion,$sql);
	if(pg_num_rows($result10)>0)
	{
		$id_categoria = pg_fetch_result($result10,0,"id_categoria");
		$des_categoria = pg_fetch_result($result10,0,"des_categoria");
		$pre_categoria = pg_fetch_result($result10,0,"pre_categoria");
		$sta_categoria = pg_fetch_result($result10,0,"sta_categoria");
		
	}
	else if (@$_REQUEST["categoria_op"] == "buscar")
	{				
		$id_categoria = @$_REQUEST["id_categoria"];
		$des_categoria = "";
		$pre_categoria = "";
		$sta_categoria = "";
	}
}
else if (@$_REQUEST["categoria_op"] == "cancelar" || @$_REQUEST["categoria_op"] == "guardar")
{				
	$id_categoria = "";
	$des_categoria = "";
	$pre_categoria = "";
	$sta_categoria = "";
}

	
if (@$_REQUEST["categoria_op"]=="guardar" && @$_REQUEST["id_categoria"]!= "" && @$_REQUEST["des_categoria"] != "" && @$_REQUEST["pre_categoria"] != "" && @$_REQUEST["sta_categoria"] != "")
{
		$sql="select * from categorias where id_categoria = '".@$_REQUEST["id_categoria"]."'";
		$result10=pg_query($bd_conexion,$sql);
		if(pg_num_rows($result10)==0)
		{
			$sql = "Insert into categorias(id_categoria, des_categoria, sta_categoria, pre_categoria) values ('".@$_REQUEST["id_categoria"]."', UPPER('".@$_REQUEST["des_categoria"]."'), '".@$_REQUEST["sta_categoria"]."', UPPER('".@$_REQUEST["pre_categoria"]."'))";
			$result10 = pg_query($bd_conexion,$sql);
			echo "<SCRIPT LANGUAGE='javascript'>swal('La categoría se registró','correctamente', 'success');</script>";
		}
		else
		{
			$sql = "update categorias set des_categoria = UPPER('".@$_REQUEST["des_categoria"]."'), sta_categoria = '".@$_REQUEST["sta_categoria"]."', pre_categoria = UPPER('".@$_REQUEST["pre_categoria"]."') where id_categoria='".@$_REQUEST["id_categoria"]."'";
			$result10 = pg_query($bd_conexion,$sql);
			echo "<SCRIPT LANGUAGE='javascript'>swal('La categoría se actualizó','correctamente', 'success');</script>";
		}
}
else
{
?>
	<div id="categorias">
	<table width="700" align="center" class="tbldatos1">
<tr><td colspan="2" align="center" class="fondo_fila_amarilla">Parametrización de Categorías</td>
   </tr>    
		<tr>
        
			<td width="80">Id de Categoría</td>
			<td><input type="text" id="id_categoria" name="id_categoria" maxlength="4" value="<?php echo $id_categoria; ?>" size="20" onChange="verificar_categoria('buscar');" onKeyPress="enter2tab(event,'pre_categoria',0);return solo_numeros(event);" /> Formato: (1234)</td>
		</tr>
		<tr>
		<div id="prefijo">
        	<td width="80">Prefijo</td>
			<td><input type="text" id="pre_categoria" name="pre_categoria" maxlength="4" value="<?php echo $pre_categoria; ?>" size="20" onKeyPress="enter2tab(event,'des_categoria',0);return solo_letras(event);" onKeyUp="javascript:this.value=this.value.toUpperCase();" onBlur="valida_prefijo_categoria();"/> Formato: (ABCD)</td>
		</div></tr>
		<tr>
			<td width="80">Descripci&oacute;n</td>
			<td><input type="text" id="des_categoria" name="des_categoria" maxlength="30" value="<?php echo $des_categoria; ?>" size="100" onKeyPress="enter2tab(event,'categoria_guardar',0);"/></td>
		</tr>
		<tr>
		<td width="100">Estatus</td>
		<td  align="left">
			<input type="radio" id="sta_categoria" name="sta_categoria" checked="checked" value="A" <?php if (pg_num_rows($result10)>0 && pg_fetch_result($result10,0,"sta_categoria")=="A") echo "CHECKED";?>>Activo
		</td>
		</tr>
		<tr>
		<td>
		</td>
		<td>
			<input type="radio" id="sta_categoria" name="sta_categoria" value="I" <?php if (pg_num_rows($result10)>0 && pg_fetch_result($result10,0,"sta_categoria")=="I") echo "CHECKED";?>>Inactivo

		</td>
	</tr>
	</table>	
</div>
<?php 
}	
?>
</html>