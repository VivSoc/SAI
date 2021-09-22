<?php 
require("../../../../configuracion/config.php");
require("../../../../configuracion/conexion.php");
require("../../../../clases/funciones.php");
require("../../../../sesion.php");
 
if (@$_REQUEST["cpdp_codigo"] != "")
{
	$sql="select codpar,nompar,alipar,codest,codmun from pardefpar where codpar = '".@$_REQUEST["cpdp_codigo"]."' and codest='".@$_REQUEST["cpdp_codest"]."' and codmun='".@$_REQUEST["cpdp_codmun"]."' and codpai = '01'";
}

if (@$_REQUEST["cpdp_op"] == "buscar")
{
	$sql="select codpar,nompar,alipar,codest,codmun from pardefpar where codpar = '".@$_REQUEST["cpdp_codigo"]."' and codest='".@$_REQUEST["cpdp_codest"]."' and codmun='".@$_REQUEST["cpdp_codmun"]."' and codpai = '01'";
}
else if (@$_REQUEST["cpdp_op"]=="cancelar")
{
	?> <script>//document.location='par_divpar.php';</script><?php
}
else if (@$_REQUEST["cpdp_op"]=="primero")
{
	$sql="select codpar,nompar,alipar,codest,codmun from pardefpar where codpar = (select min(codpar) from pardefpar where codest = '".@$_REQUEST["cpdp_codest"]."' and codmun='".@$_REQUEST["cpdp_codmun"]."' and codpai = '01') and codest='".@$_REQUEST["cpdp_codest"]."' and codmun='".@$_REQUEST["cpdp_codmun"]."' and codpai = '01'";
}
else if (@$_REQUEST["cpdp_op"]=="ultimo")
{
	$sql="select codpar,nompar,alipar,codest,codmun from pardefpar where codpar = (select max(codpar) from pardefpar where codest = '".@$_REQUEST["cpdp_codest"]."'  and codmun='".@$_REQUEST["cpdp_codmun"]."' and codpai = '01') and codest='".@$_REQUEST["cpdp_codest"]."' and codmun='".@$_REQUEST["cpdp_codmun"]."' and codpai = '01'";
}
else if (@$_REQUEST["cpdp_op"]=="anterior")
{
	if (@$_REQUEST["cpdp_codigo"]==primer_registro("pardefpar where codest = '".@$_REQUEST["cpdp_codest"]."' and codmun='".@$_REQUEST["cpdp_codmun"]."' and codpai = '01'","codpar"))
	{
		$sql="select codpar,nompar,alipar,codest,codmun from pardefpar where codpar = (select max(codpar) from pardefpar where codest = '".@$_REQUEST["cpdp_codest"]."'  and codmun='".@$_REQUEST["cpdp_codmun"]."' and codpai = '01') and codest='".@$_REQUEST["cpdp_codest"]."' and codmun='".@$_REQUEST["cpdp_codmun"]."' and codpai = '01'";
	}
	else
	{
		if (@$_REQUEST["cpdp_codigo"]=="")
		{
			$sql="select codpar,nompar,alipar,codest,codmun from pardefpar where codpar = (select min(codpar) from pardefpar where codest = '".@$_REQUEST["cpdp_codest"]."'  and codmun='".@$_REQUEST["cpdp_codmun"]."' and codpai = '01') and codest='".@$_REQUEST["cpdp_codest"]."' and codmun='".@$_REQUEST["cpdp_codmun"]."' and codpai = '01'";
		}
		else
		{
			$sql="select codpar,nompar,alipar,codest,codmun from pardefpar where codpar < '".@$_REQUEST["cpdp_codigo"]."' and codest='".@$_REQUEST["cpdp_codest"]."'  and codmun='".@$_REQUEST["cpdp_codmun"]."' and codpai = '01' order by codpar desc limit 1";
		}
	}
}
else if (@$_REQUEST["cpdp_op"]=="siguiente")
{
	if (@$_REQUEST["cpdp_codigo"]==ultimo_registro("pardefpar where codest = '".@$_REQUEST["cpdp_codest"]."' and codmun='".@$_REQUEST["cpdp_codmun"]."' and codpai = '01'","codpar"))
	{
		$sql="select codpar,nompar,alipar,codest,codmun from pardefpar where codpar = (select min(codpar) from pardefpar where codest = '".@$_REQUEST["cpdp_codest"]."'  and codmun='".@$_REQUEST["cpdp_codmun"]."' and codpai = '01') and codest='".@$_REQUEST["cpdp_codest"]."' and codmun='".@$_REQUEST["cpdp_codmun"]."' and codpai = '01'";
	}
	else
	{
		if (@$_REQUEST["cpdp_codigo"]=="")
		{
			$sql="select codpar,nompar,alipar,codest,codmun from pardefpar where codpar = (select max(codpar) from pardefpar where codest = '".@$_REQUEST["cpdp_codest"]."' and codmun='".@$_REQUEST["cpdp_codmun"]."' and codpai = '01') and codest='".@$_REQUEST["cpdp_codest"]."' and codmun='".@$_REQUEST["cpdp_codmun"]."' and codpai = '01'";
		}
		else
		{
			$sql="select codpar,nompar,alipar,codest,codmun from pardefpar where codpar > '".@$_REQUEST["cpdp_codigo"]."' and codest='".@$_REQUEST["cpdp_codest"]."' and codmun='".@$_REQUEST["cpdp_codmun"]."' and codpai = '01' order by codpar limit 1";
		}
	}
}
			
if ((@$_REQUEST["cpdp_codigo"] != "" || @$_REQUEST["cpdp_op"] == "primero" || 
	@$_REQUEST["cpdp_op"] == "ultimo" || @$_REQUEST["cpdp_op"] == "anterior" || 
	@$_REQUEST["cpdp_op"] == "siguiente") && @$_REQUEST["cpdp_op"] != "cancelar")
{
	$result10=pg_query($bd_conexion,$sql);
	if(pg_num_rows($result10)>0)
	{
		$cpdp_codigo = pg_fetch_result($result10,0,"codpar");
		$cpdp_descripcion = pg_fetch_result($result10,0,"nompar");
		$cpdp_codest = pg_fetch_result($result10,0,"codest");
		$cpdp_codmun = pg_fetch_result($result10,0,"codmun");
		$cpdp_alias = pg_fetch_result($result10,0,"alipar");
	}
	else if (@$_REQUEST["cpdp_op"] == "buscar")
	{				
		$cpdp_codigo = @$_REQUEST["cpdp_codigo"];
		$cpdp_descripcion = "";
		$cpdp_codest = @$_REQUEST["cpdp_codest"];
		$cpdp_codmun = @$_REQUEST["cpdp_codmun"];
		$cpdp_alias = "";
	}
}
else if (@$_REQUEST["cpdp_op"] == "cancelar" || @$_REQUEST["cpdp_op"] == "guardar")
{				
	$cpdp_codigo = "";
	$cpdp_descripcion = "";
	$cpdp_codest = "";
	$cpdp_codmun = "";
	$cpdp_alias = "";
}
else if (@$_REQUEST["cpdp_op"] == "buscar")
{				
	$cpdp_codigo = "";
	$cpdp_descripcion = "";
	$cpdp_codest = @$_REQUEST["cpdp_codest"];
	$cpdp_codmun = @$_REQUEST["cpdp_codmun"];
	$cpdp_alias = "";
}


if (@$_REQUEST["cpdp_op"]=="guardar" && @$_REQUEST["cpdp_codmun"]!= "" && @$_REQUEST["cpdp_codest"]!= "" && 
	@$_REQUEST["cpdp_codigo"]!= "" && @$_REQUEST["cpdp_descripcion"] != "")
{
	$sql="select codpar,nompar,alipar,codest,codmun from pardefpar where codmun = '".@$_REQUEST["cpdp_codmun"]."' and codest='".@$_REQUEST["cpdp_codest"]."' and codpar='".@$_REQUEST["cpdp_codigo"]."' and codpai ='01'";
	$result10=pg_query($bd_conexion,$sql);
	if(pg_num_rows($result10)==0)
	{
		$sql="Insert into pardefpar (codpai,codpar,nompar,alipar,codest,codmun) 
			values ('01','".@$_REQUEST["cpdp_codigo"]."', upper('".@$_REQUEST["cpdp_descripcion"]."'), upper('".@$_REQUEST["cpdp_alias"]."'),
			'".@$_REQUEST["cpdp_codest"]."', '".@$_REQUEST["cpdp_codmun"]."')";
		$result10=pg_query($bd_conexion,$sql);
		cuadro_mensaje2("Se inserto Correctamente la Parroquia: ".@$_REQUEST["cpdp_descripcion"]);
	}
	else
	{
		$sql="update pardefpar set nompar = upper('".@$_REQUEST["cpdp_descripcion"]."'), alipar = upper('".@$_REQUEST["cpdp_alias"]."')
			where codpar = '".@$_REQUEST["cpdp_codigo"]."' and codmun = '".@$_REQUEST["cpdp_codmun"]."' 
			and codest = '".@$_REQUEST["cpdp_codest"]."' and codpai = '01'";
		$result10=pg_query($bd_conexion,$sql);
		cuadro_mensaje2("Se actualizo Correctamente la Parroquia: ".@$_REQUEST["cpdp_descripcion"]);
	}
}
else
{
?>
	<div id="par_divpar_codigos">
		<table width="700" align="center" class="tbldatos1">
			<tr>
				<td width="120">C&oacute;digo Parroquia</td>
				<td><input type="text" id="cpdp_codigo" name="cpdp_codigo"  value="<?php echo $cpdp_codigo; ?>" maxlength="20" size="10" onChange="verificar_par_divpar('buscar');" onkeypress="enter2tab(event,'cpdp_descripcion',0);"/></td>
			</tr>
			<tr>
				<td width="120">Nombre Parroquia</td>
				<td><input type="text" id="cpdp_descripcion" name="cpdp_descripcion" value="<?php echo utf8($cpdp_descripcion); ?>" maxlength="100" size="100" onkeypress="enter2tab(event,'cpdp_alias',0);"/></td>
			</tr>
			<tr>
				<td width="120">Alias Parroquia</td>
				<td><input type="text" id="cpdp_alias" name="cpdp_alias" value="<?php echo utf8($cpdp_alias); ?>" maxlength="100" size="100" onkeypress="enter2tab(event,'cpdp_guardar',0);"/></td>
			</tr>
		</table>	
	</div>	
<?php 
}
?>