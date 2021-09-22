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
        <script type="text/javascript" src="javascript/parametrizacion/general/ivas.js"> </script>
    </head>
<?php
if (@$_REQUEST["id_iva"] != "")
{
	$sql="select * from ivas where id_iva = '".@$_REQUEST["id_iva"]."'";
}

if (@$_REQUEST["iva_op"] == "buscar")
{
	$sql="select * from ivas where id_iva = '".@$_REQUEST["id_iva"]."'";
		$x=pg_query($sql);
			if(pg_num_rows($x)>0)
			{
				echo "<SCRIPT LANGUAGE='javascript'>document.getElementById('mon_iva').disabled='true'</SCRIPT> "; 
			}
			else
			{
				echo "<SCRIPT LANGUAGE='javascript'>document.getElementById('mon_iva').enabled='true'</SCRIPT> "; 
			}
	
}
else if (@$_REQUEST["iva_op"]=="cancelar")
{
	?> <script>//document.location='ivas.php';</script><?php
}
else if (@$_REQUEST["iva_op"]=="primero")
{		
	$sql="select * from ivas where id_iva = (select min(id_iva) from ivas)";
	$x=pg_query($sql);
			if(pg_num_rows($x)>0)
			{
				echo "<SCRIPT LANGUAGE='javascript'>document.getElementById('mon_iva').disabled='true'</SCRIPT> "; 
			}
			else
			{
				echo "<SCRIPT LANGUAGE='javascript'>document.getElementById('mon_iva').enabled='true'</SCRIPT> "; 
			}
}
else if (@$_REQUEST["iva_op"]=="ultimo")
{
	$sql="select * from ivas where id_iva = (select max(id_iva) from ivas)";
	$x=pg_query($sql);
			if(pg_num_rows($x)>0)
			{
				echo "<SCRIPT LANGUAGE='javascript'>document.getElementById('mon_iva').disabled='true'</SCRIPT> "; 
			}
			else
			{
				echo "<SCRIPT LANGUAGE='javascript'>document.getElementById('mon_iva').enabled='true'</SCRIPT> "; 
			}
}
else if (@$_REQUEST["iva_op"]=="anterior")
{
	$sql=registro_anterior("ivas","id_iva",@$_REQUEST["id_iva"],"id_iva,des_iva,mon_iva,sta_iva,let_iva,ley_iva");
	$x=pg_query($sql);
			if(pg_num_rows($x)>0)
			{
				echo "<SCRIPT LANGUAGE='javascript'>document.getElementById('mon_iva').disabled='true'</SCRIPT> "; 
			}
			else
			{
				echo "<SCRIPT LANGUAGE='javascript'>document.getElementById('mon_iva').enabled='true'</SCRIPT> "; 
			}
}
else if (@$_REQUEST["iva_op"]=="siguiente")
{
	$sql=registro_siguiente("ivas","id_iva",@$_REQUEST["id_iva"],"id_iva,des_iva,mon_iva,sta_iva,let_iva,ley_iva");
	$x=pg_query($sql);
			if(pg_num_rows($x)>0)
			{
				echo "<SCRIPT LANGUAGE='javascript'>document.getElementById('mon_iva').disabled='true'</SCRIPT> "; 
			}
			else
			{
				echo "<SCRIPT LANGUAGE='javascript'>document.getElementById('mon_iva').enabled='true'</SCRIPT> "; 
			}
}

	
if ((@$_REQUEST["id_iva"] != "" || @$_REQUEST["iva_op"] == "primero" || 
	@$_REQUEST["iva_op"] == "ultimo" || @$_REQUEST["iva_op"] == "anterior" || 
	@$_REQUEST["iva_op"] == "siguiente") && @$_REQUEST["iva_op"] != "cancelar")
{
	$result10=pg_query($bd_conexion,$sql);
	if(pg_num_rows($result10)>0)
	{
		$id_iva = pg_fetch_result($result10,0,"id_iva");
		$des_iva = pg_fetch_result($result10,0,"des_iva");
		$mon_iva = pg_fetch_result($result10,0,"mon_iva");
		$sta_iva = pg_fetch_result($result10,0,"sta_iva");
		$let_iva = pg_fetch_result($result10,0,"let_iva");
		$ley_iva = pg_fetch_result($result10,0,"ley_iva");
		
	}
	else if (@$_REQUEST["iva_op"] == "buscar")
	{				
		$id_iva = @$_REQUEST["id_iva"];
		$des_iva = "";
		$mon_iva = "";
		$sta_iva = "";
		$let_iva = "";
		$ley_iva = "";
	}
}
else if (@$_REQUEST["iva_op"] == "cancelar" || @$_REQUEST["iva_op"] == "guardar")
{				
	$id_iva = "";
	$des_iva = "";
	$mon_iva = "";
	$sta_iva = "";
	$let_iva = "";
	$ley_iva = "";
}

	
if (@$_REQUEST["iva_op"]=="guardar" && @$_REQUEST["id_iva"]!= "" && @$_REQUEST["des_iva"] != "" && @$_REQUEST["mon_iva"] != "" && @$_REQUEST["sta_iva"] != "")
{
		$sql="select * from ivas where id_iva = '".@$_REQUEST["id_iva"]."'";
		$result10=pg_query($bd_conexion,$sql);
		if(pg_num_rows($result10)==0)
		{
			$sql = "Insert into ivas(id_iva, des_iva, sta_iva, mon_iva, let_iva, ley_iva) values ('".@$_REQUEST["id_iva"]."', UPPER('".@$_REQUEST["des_iva"]."'), '".@$_REQUEST["sta_iva"]."', '".@$_REQUEST["mon_iva"]."',UPPER('".@$_REQUEST["let_iva"]."'),'".@$_REQUEST["ley_iva"]."')";
			$result10 = pg_query($bd_conexion,$sql);
			echo "<SCRIPT LANGUAGE='javascript'>swal('El iva se registró','correctamente', 'success');</script>";
		}
		else
		{
			$sql = "update ivas set des_iva = UPPER('".@$_REQUEST["des_iva"]."'), sta_iva = '".@$_REQUEST["sta_iva"]."', mon_iva = '".@$_REQUEST["mon_iva"]."', let_iva = UPPER('".@$_REQUEST["let_iva"]."'), ley_iva = '".@$_REQUEST["ley_iva"]."'  where id_iva='".@$_REQUEST["id_iva"]."'";
			$result10 = pg_query($bd_conexion,$sql);
			echo "<SCRIPT LANGUAGE='javascript'>swal('El iva se actualizó','correctamente', 'success');</script>";
		}
}
else
{
?>
	<div id="ivas">
	<table width="700" align="center" class="tbldatos1">
<tr><td colspan="2" align="center" class="fondo_fila_amarilla">Parametrización de Iva</td>
   </tr>    
		<tr>
        
			<td width="80">Id del Iva</td>
			<td><input type="text" id="id_iva" name="id_iva" maxlength="4" value="<?php echo $id_iva; ?>" size="20" onChange="verificar_iva('buscar');" onKeyPress="enter2tab(event,'des_iva',0);return solo_numeros(event);" /> Formato: (1234)</td>
		</tr>
			<td width="80">Descripci&oacute;n</td>
			<td><input type="text" id="des_iva" name="des_iva" maxlength="30" value="<?php echo $des_iva; ?>" size="100" onKeyPress="enter2tab(event,'mon_iva',0);"/></td>
		</tr>
        <tr>
		<div id="valor">
        	<td width="80">Monto</td>
			<td><input type="text" id="mon_iva" name="mon_iva" maxlength="5" value="<?php echo $mon_iva; ?>" size="6" onKeyPress="enter2tab(event,'let_iva',0);return solo_dinero(event);" onBlur="valida_monto_iva();"/> %</td>
		</div></tr>
        <tr>
        <div id="letra">
			<td width="80">Letra</td>
			<td><input type="text" id="let_iva" name="let_iva" maxlength="1" size="6" value="<?php echo $let_iva; ?>" onKeyPress="enter2tab(event,'ley_iva',0); return solo_letras(event);" onKeyUp="javascript:this.value=this.value.toUpperCase();" onBlur="valida_letra_iva();"/> Formato: (ABC)</td>
		</div></tr>	
        <tr>
        <tr>
			<td width="80">Leyenda</td>
			<td><input type="text" id="ley_iva" name="ley_iva" maxlength="50" value="<?php echo $ley_iva; ?>" size="100" onKeyPress="enter2tab(event,'iva_guardar',0);"/></td>
		</tr>	
        <tr>
		<tr>
		<tr>
		<td width="100">Estatus</td>
		<td  align="left">
			<input type="radio" id="sta_iva" name="sta_iva" checked="checked" value="A" <?php if (pg_num_rows($result10)>0 && pg_fetch_result($result10,0,"sta_iva")=="A") echo "CHECKED";?>>Activo
		</td>
		</tr>
		<tr>
		<td>
		</td>
		<td>
			<input type="radio" id="sta_iva" name="sta_iva" value="I" <?php if (pg_num_rows($result10)>0 && pg_fetch_result($result10,0,"sta_iva")=="I") echo "CHECKED";?>>Inactivo

		</td>
	</tr>
	</table>	
</div>
<?php 
}	
?>
</html>