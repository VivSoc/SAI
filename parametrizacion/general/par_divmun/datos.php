<?php 
require("../../../../configuracion/config.php");
require("../../../../configuracion/conexion.php");
require("../../../../clases/funciones.php");
require("../../../../sesion.php");

if (@$_REQUEST["cpdm_codigo"] != "")
{
	$sql="select codpai,codest,codmun,nommun,alimun from pardefmun where codmun = '".@$_REQUEST["cpdm_codigo"]."' and codest='".@$_REQUEST["cpdm_codest"]."' and codpai = '01'";
}

if (@$_REQUEST["cpdm_op"] == "buscar")
{
	$sql="select codpai,codest,codmun,nommun,alimun from pardefmun where codmun = '".@$_REQUEST["cpdm_codigo"]."' and codest='".@$_REQUEST["cpdm_codest"]."' and codpai = '01'";
}
else if (@$_REQUEST["cpdm_op"]=="cancelar")
{
	?> <script>//document.location='par_divmun.php';</script><?php
}
else if (@$_REQUEST["cpdm_op"]=="primero")
{
	$sql="select codpai,codest,codmun,nommun,alimun from pardefmun where codmun = (select min(codmun) from pardefmun where codest = '".@$_REQUEST["cpdm_codest"]."' and codpai = '01') and codest='".@$_REQUEST["cpdm_codest"]."' and codpai = '01'";
}
else if (@$_REQUEST["cpdm_op"]=="ultimo")
{
		$sql="select codpai,codest,codmun,nommun,alimun from pardefmun where codmun = (select max(codmun) from pardefmun where codest = '".@$_REQUEST["cpdm_codest"]."' and codpai = '01') and codest='".@$_REQUEST["cpdm_codest"]."' and codpai = '01'";
} 
else if (@$_REQUEST["cpdm_op"]=="anterior")
{
	if (@$_REQUEST["cpdm_codigo"]==primer_registro("pardefmun where codest = '".@$_REQUEST["cpdm_codest"]."' and codpai = '01'","codmun"))
	{
		$sql="select codpai,codest,codmun,nommun,alimun from pardefmun where codmun = (select max(codmun) from pardefmun where codest = '".@$_REQUEST["cpdm_codest"]."' and codpai = '01') and codest='".@$_REQUEST["cpdm_codest"]."' and codpai = '01'";
	}
	else
	{
		if (@$_REQUEST["cpdm_codigo"]=="")
		{
			$sql="select codpai,codest,codmun,nommun,alimun from pardefmun where codmun = (select min(codmun) from pardefmun where codest = '".@$_REQUEST["cpdm_codest"]."' and codpai = '01') and codest='".@$_REQUEST["cpdm_codest"]."' and codpai = '01'";
		}
		else
		{
			$sql="select codpai,codest,codmun,nommun,alimun from pardefmun where codmun < '".@$_REQUEST["cpdm_codigo"]."' and codest='".@$_REQUEST["cpdm_codest"]."'  and codpai = '01' order by codmun desc limit 1";
		}
	}
}
else if (@$_REQUEST["cpdm_op"]=="siguiente")
{
	if (@$_REQUEST["cpdm_codigo"]==ultimo_registro("pardefmun where codest = '".@$_REQUEST["cpdm_codest"]."' and codpai = '01'","codmun"))
	{
		$sql="select codpai,codest,codmun,nommun,alimun from pardefmun where codmun = (select min(codmun) from pardefmun where codest = '".@$_REQUEST["cpdm_codest"]."' and codpai = '01') and codest='".@$_REQUEST["cpdm_codest"]."' and codpai = '01'";
	}
	else
	{
		if (@$_REQUEST["cpdm_codigo"]=="")
		{
			$sql="select codpai,codest,codmun,nommun,alimun from pardefmun where codmun = (select max(codmun) from pardefmun where codest = '".@$_REQUEST["cpdm_codest"]."' and codpai = '01') and codest='".@$_REQUEST["cpdm_codest"]."' and codpai = '01'";
		}
		else
		{
			$sql="select codpai,codest,codmun,nommun,alimun from pardefmun where codmun > '".@$_REQUEST["cpdm_codigo"]."' and codest='".@$_REQUEST["cpdm_codest"]."'  and codpai = '01' order by codmun limit 1";
		}
	}
}
			
if ((@$_REQUEST["cpdm_codigo"] != "" || @$_REQUEST["cpdm_op"] == "primero" || 
	@$_REQUEST["cpdm_op"] == "ultimo" || @$_REQUEST["cpdm_op"] == "anterior" || 
	@$_REQUEST["cpdm_op"] == "siguiente") && @$_REQUEST["cpdm_op"] != "cancelar")
{
	$result10=pg_query($bd_conexion,$sql);
	if(pg_num_rows($result10)>0)
	{
		$cpdm_codigo = pg_fetch_result($result10,0,"codmun");
		$cpdm_descripcion = pg_fetch_result($result10,0,"nommun");
		$cpdm_codest = pg_fetch_result($result10,0,"codest");
		$cpdm_alias = pg_fetch_result($result10,0,"alimun");
	}
	else if (@$_REQUEST["cpdm_op"] == "buscar")
	{			
		$cpdm_codest = @$_REQUEST["cpdm_codest"];
		$cpdm_codigo = @$_REQUEST["cpdm_codigo"];
		$cpdm_descripcion = "";
		$cpdm_alias = "";
	}
}
else if (@$_REQUEST["cpdm_op"] == "cancelar" || @$_REQUEST["cpdm_op"] == "guardar")
{				
	$cpdm_codigo = "";
	$cpdm_descripcion = "";
	$cpdm_codest = @$_REQUEST["cpdm_codest"];
	$cpdm_alias = "";
}
else if (@$_REQUEST["cpdm_op"] == "buscar")
{
	$cpdm_codigo = "";
	$cpdm_descripcion = "";
	$cpdm_codest = @$_REQUEST["cpdm_codest"];
	$cpdm_alias = "";	
}

if (@$_REQUEST["cpdm_op"]=="guardar" && @$_REQUEST["cpdm_codigo"]!= "" && 
	@$_REQUEST["cpdm_descripcion"] != "" && @$_REQUEST["cpdm_codest"] != "")
{
	$sql="select codpai,codest,codmun,nommun,alimun from pardefmun where codmun = '".@$_REQUEST["cpdm_codigo"]."' and codest='".@$_REQUEST["cpdm_codest"]."'";
	$result10=pg_query($bd_conexion,$sql);
	if(pg_num_rows($result10)==0)
	{
		$sql="Insert into pardefmun (codpai, codest, codmun, nommun, alimun) 
			values ('01', '".@$_REQUEST["cpdm_codest"]."', '".@$_REQUEST["cpdm_codigo"]."'
			,upper('".@$_REQUEST["cpdm_descripcion"]."'), upper('".@$_REQUEST["cpdm_alias"]."'))";
		$result10=pg_query($bd_conexion,$sql);
		cuadro_mensaje2("Se inserto Correctamente el Municipio: ".@$_REQUEST["cpdm_descripcion"]);
	}
	else
	{
		$sql="update pardefmun set nommun = upper('".@$_REQUEST["cpdm_descripcion"]."'),
			alimun = upper('".@$_REQUEST["cpdm_alias"]."')
			where codmun='".@$_REQUEST["cpdm_codigo"]."' and codest = '".@$_REQUEST["cpdm_codest"]."'
			and codpai = '01'";
		$result10=pg_query($bd_conexion,$sql);
		cuadro_mensaje2("Se actualizo Correctamente el Municipio: ".@$_REQUEST["cpdm_descripcion"]);
	}
}
else
{
?>
	<div id="par_divmun_codigos">
		<table width="700" align="center" class="tbldatos1">
<tr><td colspan="2" align="center" class="fondo_fila_amarilla">DEFINICI&Oacute;N DE MUNICIPIOS</td>
   </tr>        
			<tr>
				<td  width="120">Estado</td>
				<td >
					<input type="text" value="<?php echo $cpdm_codest; ?>" id="cpdm_codest" name="cpdm_codest" size="10" maxlength="3" onkeyup="CodigoToSelect(document.getElementById('cpdm_codest').value,document.getElementById('cpdm_nomest'))" onkeypress="enter2tab(event,'cpdm_nomest',0); return solo_numeros(event);" />
					<select id="cpdm_nomest" name="cpdm_nomest" onchange="document.getElementById('cpdm_codest').value=document.getElementById('cpdm_nomest').options[document.getElementById('cpdm_nomest').selectedIndex].value; " onkeypress="enter2tab(event,'cpdm_codigo',0);">
						<option value="">Seleccione</option>
						<?php 
						$result=pg_query($bd_conexion,"select * from pardefest where codest <> '999' and codpai='01' order by codest");
						while ($registro=pg_fetch_assoc($result))
						{
							if ($registro["codest"] == $cpdm_codest)
							{
								echo "<option value=\"".$registro["codest"]."\" selected=selected>".$registro["codest"]." - ".$registro["nomest"]."</option>";
							}
							else
							{
								echo "<option value=\"".$registro["codest"]."\">".$registro["codest"]." - ".$registro["nomest"]."</option>";
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
				<td width="120">C&oacute;digo del Municipio</td>
				<td>
					<input type="text" id="cpdm_codigo" name="cpdm_codigo"  value="<?php echo $cpdm_codigo; ?>" maxlength="20" size="10" onChange="verificar_par_divmun('buscar');" onkeypress="enter2tab(event,'cpdm_descripcion',0);"/>
				</td>
			</tr>
			<tr>
				<td width="120">Nombre del Municipio</td>
				<td>
					<input type="text" id="cpdm_descripcion" name="cpdm_descripcion" value="<?php echo utf8($cpdm_descripcion); ?>" maxlength="100" size="100" onkeypress="enter2tab(event,'cpdm_alias',0);"/>
				</td>
			</tr>
			<tr>
				<td width="120">Alias del Municipio</td>
				<td>
					<input type="text" id="cpdm_alias" name="cpdm_alias" value="<?php echo utf8($cpdm_alias); ?>" maxlength="100" size="100" onkeypress="enter2tab(event,'cpdm_guardar',0);"/>
				</td>
			</tr>
		</table>	
	</div>	
<?php 
}	
?>