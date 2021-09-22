<?php 
require("../../../../configuracion/config.php");
require("../../../../configuracion/conexion.php");
require("../../../../clases/funciones.php");
require("../../../../sesion.php");

if (@$_REQUEST["sptm_codigo"] != "")
{
	$sql="select codtip,destip from partipmot where codtip = '".@$_REQUEST["sptm_codigo"]."'";
}

if (@$_REQUEST["sptm_op"] == "buscar")
{
	$sql="select codtip,destip from partipmot where codtip = '".@$_REQUEST["sptm_codigo"]."'";
}
else if (@$_REQUEST["sptm_op"]=="cancelar")
{
	?> <script>//document.location='par_tipmot.php';</script><?php
}
else if (@$_REQUEST["sptm_op"]=="primero")
{
	$sql="select codtip,destip from partipmot where codtip = (select min(codtip) from partipmot)";
}
else if (@$_REQUEST["sptm_op"]=="ultimo")
{
	$sql="select codtip,destip from partipmot where codtip = (select max(codtip) from partipmot)";
}
else if (@$_REQUEST["sptm_op"]=="anterior")
{
	$sql=registro_anterior("partipmot","codtip",@$_REQUEST["sptm_codigo"],"codtip,destip");
}
else if (@$_REQUEST["sptm_op"]=="siguiente")
{
	$sql=registro_siguiente("partipmot","codtip",@$_REQUEST["sptm_codigo"],"codtip,destip");
}
			
if ((@$_REQUEST["sptm_codigo"] != "" || @$_REQUEST["sptm_op"] == "primero" || 
	@$_REQUEST["sptm_op"] == "ultimo" || @$_REQUEST["sptm_op"] == "anterior" || 
	@$_REQUEST["sptm_op"] == "siguiente") && @$_REQUEST["sptm_op"] != "cancelar")
{
	$result10=pg_query($bd_conexion,$sql);
	if(pg_num_rows($result10)>0)
	{
		$codigo = pg_fetch_result($result10,0,"codtip");
		$descripcion = pg_fetch_result($result10,0,"destip");
	}
	else if (@$_REQUEST["sptm_op"] == "buscar")
	{				
		$codigo = @$_REQUEST["sptm_codigo"];
		$descripcion = "";
	}	
}
else if (@$_REQUEST["sptm_op"] == "cancelar" || @$_REQUEST["sptm_op"] == "guardar")
{				
	$codigo = "";
	$descripcion = "";
}	

if (@$_REQUEST["sptm_op"]=="guardar" && @$_REQUEST["sptm_codigo"]!= "" && @$_REQUEST["sptm_descripcion"] != "")
{
	$sql="select codtip,destip from partipmot where codtip = '".@$_REQUEST["sptm_codigo"]."'";
	$result10=pg_query($bd_conexion,$sql);
	if(pg_num_rows($result10)==0)
	{
		$sql="Insert into partipmot (codtip,destip) values ('".@$_REQUEST["sptm_codigo"]."','".@$_REQUEST["sptm_descripcion"]."')";
		$result10=pg_query($bd_conexion,$sql);
		cuadro_mensaje2("Se inserto Correctamente el Tipo de Motivo: ".@$_REQUEST["sptm_descripcion"]);
	}
	else
	{
		$sql="update partipmot set destip='".@$_REQUEST["sptm_descripcion"]."' where codtip='".@$_REQUEST["sptm_codigo"]."'";
		$result10=pg_query($bd_conexion,$sql);
		cuadro_mensaje2("Se actualizo Correctamente el Tipo de Motivo: ".@$_REQUEST["sptm_descripcion"]);
	}
}
else
{
?>
	<div id="par_tipmot_codigos">
		<table width="700" align="center" class="tbldatos1">
			<tr>
				<td width="80">C&oacute;digo</td>
				<td>
					<input type="text" id="sptm_codigo" name="sptm_codigo" value="<?php echo $codigo; ?>" onchange="verificar_par_tipmot('buscar');" maxlength="4" style="width:100px;" onkeypress="enter2tab(event,'sptm_descripcion',0);"/>
				</td>
			</tr>
			<tr>
				<td width="80">Descripci&oacute;n</td>
				<td>
					<input type="text" id="sptm_descripcion" name="sptm_descripcion" value="<?php echo $descripcion; ?>" maxlength="100" style="width:550px;" onkeypress="enter2tab(event,'sptm_guardar',0);"/>
				</td>
			</tr>
		</table>	
	</div>	
<?php 
}
?>
