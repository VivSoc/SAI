<?php 
require("../../../../configuracion/config.php");
require("../../../../configuracion/conexion.php");
require("../../../../clases/funciones.php");
require("../../../../sesion.php");

if (@$_REQUEST["sptot_codigo"] != "")
{
	$sql="select codtipord,destipord,movref,tipord,oriord from orttipord where codtipord = '".@$_REQUEST["sptot_codigo"]."'";
}

if (@$_REQUEST["sptot_op"] == "buscar")
{
	$sql="select codtipord,destipord,movref,tipord,oriord from orttipord where codtipord = '".@$_REQUEST["sptot_codigo"]."'";
}
else if (@$_REQUEST["sptot_op"]=="cancelar")
{ 

}
else if (@$_REQUEST["sptot_op"]=="primero")
{
	$sql="select codtipord,destipord,movref,tipord,oriord from orttipord where codtipord = (select min(codtipord) from orttipord)";
}
else if (@$_REQUEST["sptot_op"]=="ultimo")
{
	$sql="select codtipord,destipord,movref,tipord,oriord from orttipord where codtipord = (select max(codtipord) from orttipord)";
}
else if (@$_REQUEST["sptot_op"]=="anterior")
{
	$sql=registro_anterior("orttipord","codtipord",@$_REQUEST["sptot_codigo"],"codtipord,destipord,movref,tipord,oriord");
}
else if (@$_REQUEST["sptot_op"]=="siguiente")
{
	
	$sql=registro_siguiente("orttipord","codtipord",@$_REQUEST["sptot_codigo"],"codtipord,destipord,movref,tipord,oriord");
}
			
if ((@$_REQUEST["sptot_codigo"] != "" || @$_REQUEST["sptot_op"] == "primero" || 
	@$_REQUEST["sptot_op"] == "ultimo" || @$_REQUEST["sptot_op"] == "anterior" || 
	@$_REQUEST["sptot_op"] == "siguiente") && @$_REQUEST["sptot_op"] != "cancelar")
{
	$result10=pg_query($bd_conexion,$sql);
	if(pg_num_rows($result10)>0)
	{
		$codigo = pg_fetch_result($result10,0,"codtipord");
		$descripcion = pg_fetch_result($result10,0,"destipord");
		$movref = pg_fetch_result($result10,0,"movref");
		$tipord = pg_fetch_result($result10,0,"tipord");
		$oriord = pg_fetch_result($result10,0,"oriord");
	}
	else if (@$_REQUEST["sptot_op"] == "buscar")
	{				
		$codigo = @$_REQUEST["sptot_codigo"];
		$descripcion = "";
		$movref = "";
		$tipord = "";
		$oriord = "";
	}
}
else if (@$_REQUEST["sptot_op"] == "cancelar" || @$_REQUEST["sptot_op"] == "guardar")
{				
	$codigo = "";
	$descripcion = "";
	$movref = "";
	$tipord = "";
	$oriord = "";
}	
else if (@$_REQUEST["sptot_op"] == "buscar")
{				
	$codigo = "";
	$descripcion = "";
	$movref = "";
	$tipord = "";
	$oriord = "";
}	

	

if (@$_REQUEST["sptot_op"]=="guardar" && @$_REQUEST["sptot_tiptra"]!= "" && 
	@$_REQUEST["sptot_tipord"]!= "" && @$_REQUEST["sptot_oritra"]!= "" &&
	@$_REQUEST["sptot_codigo"]!= "" && @$_REQUEST["sptot_descripcion"] != "")
{
	$sql="select codtipord,destipord,movref,tipord,oriord from orttipord where codtipord='".@$_REQUEST["sptot_codigo"]."'";
	$result10=pg_query($bd_conexion,$sql);
	if(pg_num_rows($result10)==0)
	{
		$sql = "Insert into orttipord (
					codtipord,
					destipord,
					movref,
					tipord,
					oriord) 
				values (
					'".@$_REQUEST["sptot_codigo"]."',
					'".@$_REQUEST["sptot_descripcion"]."',
					'".@$_REQUEST["sptot_tipord"]."',
					'".@$_REQUEST["sptot_tiptra"]."',
					'".@$_REQUEST["sptot_oritra"]."')";
		$result10=pg_query($bd_conexion,$sql);
		cuadro_mensaje2("Se inserto Correctamente el tipo de orden de trabajo: ".@$_REQUEST["sptot_descripcion"]);
	}
	else
	{
		$sql = "update 
					orttipord 
				set 
					destipord='".@$_REQUEST["sptot_descripcion"]."',
					movref='".@$_REQUEST["sptot_tipord"]."',
					tipord='".@$_REQUEST["sptot_tiptra"]."',
					oriord='".@$_REQUEST["sptot_oritra"]."'
				where 
					codtipord = '".@$_REQUEST["sptot_codigo"]."'";
		$result10=pg_query($bd_conexion,$sql);
		cuadro_mensaje2("Se actualizo Correctamente el tipo de orden de trabajo: ".@$_REQUEST["sptot_descripcion"]);
	}
}
else
{
	$movref = array('','','','','','');
	$tipord = array('','','','','','');
	$oriord = array('','','','','','');
	switch (pg_fetch_result($result10,0,"movref"))
	{
		case "S": { $movref[0]="SELECTED"; break; }
		case "Q": { $movref[1]="SELECTED"; break; }
		case "F": { $movref[2]="SELECTED"; break; }
		case "I": { $movref[3]="SELECTED"; break; }
		case "C": { $movref[4]="SELECTED"; break; }
		case "R": { $movref[5]="SELECTED"; break; }
	}
	switch (pg_fetch_result($result10,0,"tipord"))
	{
		case "D": { $tipord[0]="SELECTED"; break; }
		case "I": { $tipord[1]="SELECTED"; break; }
	}
	switch (pg_fetch_result($result10,0,"oriord"))
	{
		case "I": { $oriord[0]="SELECTED"; break; }
		case "E": { $oriord[1]="SELECTED"; break; }
	}
?>
	
<div id="par_tipordtra_codigos">
	<table width="700" align="center" class="tbldatos1">
		<tr>
			<td width="120">C&oacute;digo</td>
			<td>
				<input type="text"  name="sptot_codigo" maxlength="3" id="sptot_codigo" style="width:100px;" value="<?php echo $codigo; ?>" onChange="verificar_par_tipordtra('buscar');" onkeypress="enter2tab(event,'sptot_descripcion',0);"/>
			</td>
		</tr>
		<tr>
			<td width="120">Descripci&oacute;n</td>
			<td>
				<input type="text" name="sptot_descripcion" maxlength="100" id="sptot_descripcion" style="width:550px;" value="<?php echo $descripcion; ?>" onkeypress="enter2tab(event,'sptot_tipord',0);"/>
			</td>
		</tr>
	</table>	


<table width="700" align="center" class="tbldatos1">
	<tr>
		<td class="tbldatos1" width="120">Refiere a</td>
		<td class="tbldatos1">
			<select id="sptot_tipord" name="sptot_tipord" style="width:200px;" onkeypress="enter2tab(event,'sptot_tiptra',0);">
				<option value="">Seleccione...</option>
				<option value="S" <?php echo $movref[0];?>>SOLICITUD DE SERVICIOS</option>
				<option value="Q" <?php echo $movref[1];?>>QUEJAS Y RECLAMOS</option>
				<option value="F" <?php echo $movref[2];?>>FACTIBILIDAD</option>
				<option value="I" <?php echo $movref[3];?>>INSTALACION DE NUEVA TOMA</option>
				<option value="C" <?php echo $movref[4];?>>CORTES</option>
				<option value="R" <?php echo $movref[5];?>>REINSTALACION</option>
			</select>
		</td>
	</tr>
</table>

<table width="700" align="center" class="tbldatos1">
	<tr>
		<td class="tbldatos1" width="120">Tipo de Trabajo</td>
		<td class="tbldatos1">
			<select id="sptot_tiptra" name="sptot_tiptra" style="width:200px;" onkeypress="enter2tab(event,'sptot_oritra',0);">
				<option value="">Seleccione...</option>
				<option value="D" <?php echo $tipord[0];?>>DE CAMPO</option>
				<option value="I" <?php echo $tipord[1];?>>INTERNA</option>
			</select>
		</td>
	</tr>
</table>

<table width="700" align="center" class="tbldatos1">
	<tr>
		<td class="tbldatos1" width="120">Origen de Trabajo</td>
		<td class="tbldatos1">
			<select id="sptot_oritra" name="sptot_oritra" style="width:200px;" onkeypress="enter2tab(event,'sptot_guardar',0);">
				<option value="">Seleccione...</option>
				<option value="I" <?php echo $oriord[0];?>>INTERNA</option>
				<option value="E" <?php echo $oriord[1];?>>EXTERNA</option>
			</select>
		</td>
	</tr>
</table>
</div>

<?php 
}
?>

