<?php 
require("../../../../configuracion/config.php");
require("../../../../configuracion/conexion.php");
require("../../../../clases/funciones.php");
require("../../../../sesion.php");

if (@$_REQUEST["spdm_codigo"] != "")
{
	$sql="select codmot,desmot,tipmot,tiprec from pardefmot where codmot = '".@$_REQUEST["spdm_codigo"]."'";
}

if (@$_REQUEST["spdm_op"] == "buscar")
{
	$sql="select codmot,desmot,tipmot,tiprec from pardefmot where codmot = '".@$_REQUEST["spdm_codigo"]."'";
}
else if (@$_REQUEST["spdm_op"]=="cancelar")
{
	?> <script>//document.location='par_defmot.php';</script><?php
}
else if (@$_REQUEST["spdm_op"]=="primero")
{
	$sql="select codmot,desmot,tipmot,tiprec from pardefmot where codmot = (select min(codmot) from pardefmot where tipmot = '".@$_REQUEST["spdm_codmot"]."') and tipmot = '".@$_REQUEST["spdm_codmot"]."'";
}
else if (@$_REQUEST["spdm_op"]=="ultimo")
{
	$sql="select codmot,desmot,tipmot,tiprec from pardefmot where codmot = (select max(codmot) from pardefmot where tipmot = '".@$_REQUEST["spdm_codmot"]."') and tipmot = '".@$_REQUEST["spdm_codmot"]."'";
}

/*
else if (@$_REQUEST["spdm_op"]=="anterior")
{
	$sql=registro_anterior("pardefmot","codmot",@$_REQUEST["spdm_codigo"],"codmot,desmot");
}
else if (@$_REQUEST["spdm_op"]=="siguiente")
{
	$sql=registro_siguiente("pardefmot","codmot",@$_REQUEST["spdm_codigo"],"codmot,desmot");
}
*/






else if (@$_REQUEST["spdm_op"]=="anterior")
{
	if (@$_REQUEST["spdm_codigo"]==primer_registro("pardefmot where tipmot='".@$_REQUEST["spdm_codmot"]."'","codmot"))
	{
		$sql="select codmot,desmot,tipmot,tiprec from pardefmot where codmot = (select max(codmot) from pardefmot where tipmot = '".@$_REQUEST["spdm_codmot"]."') and tipmot='".@$_REQUEST["spdm_codmot"]."'";
	}
	else
	{
		if (@$_REQUEST["spdm_codigo"]=="")
		{
			$sql="select codmot,desmot,tipmot,tiprec from pardefmot where codmot = (select min(codmot) from pardefmot where tipmot = '".@$_REQUEST["spdm_codmot"]."') and tipmot='".@$_REQUEST["spdm_codmot"]."'";
		}
		else
		{
			$sql="select codmot,desmot,tipmot,tiprec from pardefmot where codmot < '".@$_REQUEST["spdm_codigo"]."' and tipmot='".@$_REQUEST["spdm_codmot"]."' order by codmot desc limit 1";
		}
	}
}
else if (@$_REQUEST["spdm_op"]=="siguiente")
{
	if (@$_REQUEST["spdm_codigo"]==ultimo_registro("pardefmot where tipmot='".@$_REQUEST["spdm_codmot"]."'","codmot"))
	{
		$sql="select codmot,desmot,tipmot,tiprec from pardefmot where codmot = (select min(codmot) from pardefmot where tipmot = '".@$_REQUEST["spdm_codmot"]."') and tipmot='".@$_REQUEST["spdm_codmot"]."'";
	}
	else
	{
		if (@$_REQUEST["spdm_codigo"]=="")
		{
			$sql="select codmot,desmot,tipmot,tiprec from pardefmot where codmot = (select max(codmot) from pardefmot where tipmot = '".@$_REQUEST["spdm_codmot"]."') and tipmot='".@$_REQUEST["spdm_codmot"]."'";
		}
		else
		{
			$sql="select codmot,desmot,tipmot,tiprec from pardefmot where codmot > '".@$_REQUEST["spdm_codigo"]."' and tipmot='".@$_REQUEST["spdm_codmot"]."' order by codmot limit 1";
		}
	}
}









			
if ((@$_REQUEST["spdm_codigo"] != "" || @$_REQUEST["spdm_op"] == "primero" || 
	@$_REQUEST["spdm_op"] == "ultimo" || @$_REQUEST["spdm_op"] == "anterior" || 
	@$_REQUEST["spdm_op"] == "siguiente") && @$_REQUEST["spdm_op"] != "cancelar")
{
	$result10=pg_query($bd_conexion,$sql);
	if(pg_num_rows($result10)>0)
	{
		$codigo = pg_fetch_result($result10,0,"codmot");
		$descripcion = pg_fetch_result($result10,0,"desmot");
		$tiporeclamo = pg_fetch_result($result10,0,"tiprec");
		$tipmot = pg_fetch_result($result10,0,"tipmot");
	}
	else if (@$_REQUEST["spdm_op"] == "buscar")
	{				
		$codigo = @$_REQUEST["spdm_codigo"];
		$descripcion = "";
		$tiporeclamo = "";
		$tipmot = "";
	}	
}
else if (@$_REQUEST["spdm_op"] == "cancelar" || @$_REQUEST["spdm_op"] == "guardar")
{				
	$codigo = "";
	$descripcion = "";
	$tiporeclamo = "";
	$tipmot = "";
}	

if (@$_REQUEST["spdm_op"]=="guardar" && @$_REQUEST["spdm_codigo"]!= "" && @$_REQUEST["spdm_descripcion"] != "")
{
	$sql="select codmot,desmot,tipmot,tiprec from pardefmot where codmot = '".@$_REQUEST["spdm_codigo"]."'";
	$result10=pg_query($bd_conexion,$sql);
	if(pg_num_rows($result10)==0)
	{
		$sql = "Insert into pardefmot (
					codmot,
					desmot,
					tiprec,
					tipmot,
					status) 
				values (
					'".@$_REQUEST["spdm_codigo"]."',
					'".@$_REQUEST["spdm_descripcion"]."',
					'".@$_REQUEST["spdm_coddef"]."',
					'".@$_REQUEST["spdm_codmot"]."',
					'1')";
		$result10=pg_query($bd_conexion,$sql);
		cuadro_mensaje2("Se inserto Correctamente el Tipo de Motivo: ".@$_REQUEST["spdm_descripcion"]);
	}
	else
	{
		$sql = "update pardefmot set 
					desmot='".@$_REQUEST["spdm_descripcion"]."',
					tipmot='".@$_REQUEST["spdm_codmot"]."',
					tiprec='".@$_REQUEST["spdm_coddef"]."',
					status='1' 
				where 
					codmot='".@$_REQUEST["spdm_codigo"]."'";
		$result10=pg_query($bd_conexion,$sql);
		cuadro_mensaje2("Se actualizo Correctamente el Tipo de Motivo: ".@$_REQUEST["spdm_descripcion"]);
	}
}
else
{
?>
	<div id="par_defmot_codigos">
		<table width="700" align="center" class="tbldatos1">
			<tr>
				<td width="80">C&oacute;digo</td>
				<td>
					<input type="text" id="spdm_codigo" name="spdm_codigo" value="<?php echo $codigo; ?>" onchange="verificar_par_defmot('buscar');" maxlength="4" style="width:100px;" onkeypress="enter2tab(event,'spdm_descripcion',0);"/>
				</td>
			</tr>
			<tr>
				<td width="80">Descripci&oacute;n</td>
				<td>
					<input type="text" id="spdm_descripcion" name="spdm_descripcion" value="<?php echo utf8($descripcion); ?>" maxlength="100" style="width:550px;" onkeypress="enter2tab(event,'spdm_guardar',0);"/>
				</td>
			</tr>
		</table>
	</div>	
	
	
	<?php
	if ($tipmot == "00R" || @$_REQUEST["spdm_codmot"]=="00R")
	{
	?>
	<div id="par_defmot_tiporeclamo">
			<table width="700" align="center" class="tbldatos1">
	<tr>
		<td class="tbldatos1" width="80">Tipo Reclamo</td>
		<td class="tbldatos1">
			<input type="text" id="spdm_coddef" name="spdm_coddef" value="<?php echo $tiporeclamo; ?>" style="width:100px;" maxlength="3" onkeyup="CodigoToSelect(document.getElementById('spdm_coddef').value,document.getElementById('spdm_desdef'));" onkeypress="enter2tab(event,'spdm_desdef',0); return solo_numeros(event);" />
			<select id="spdm_desdef" name="spdm_desdef" style="width:450px;" onchange="document.getElementById('spdm_coddef').value=document.getElementById('spdm_desdef').options[document.getElementById('spdm_desdef').selectedIndex].value; tiporeclamo_par_defmot();" onkeypress="enter2tab(event,'fcpf_reporte1',0);">
				<option value="">Seleccione</option>
				<?php 
				$sql = "SELECT * FROM pardefrec WHERE coddef <> '999' ORDER BY coddef";
				$result=pg_query($bd_conexion,$sql);
				while ($registro=pg_fetch_assoc($result))
				{
					if ($registro["coddef"] == $tiporeclamo)
					{
						echo "<option value=\"".$registro["coddef"]."\" SELECTED>".$registro["coddef"]." - ".$registro["desdef"]."</option>";
					}
					else
					{
						echo "<option value=\"".$registro["coddef"]."\">".$registro["coddef"]." - ".$registro["desdef"]."</option>";
					}
				}
				?>
			</select>
		</td>
	</tr>
</table>
	</div>
	<?php
}
else
{
	?>
	
	<div id="par_defmot_tiporeclamo">
	</div>
	<?php
}
?>

<?php 
}
?>
