<?php 
require("../../../../configuracion/config.php");
require("../../../../configuracion/conexion.php");
require("../../../../sesion.php");

if (@$_REQUEST["spdm_codmot"] == "00R")
{
?>
<div id="par_defmot_tiporeclamo"> 
<table width="700" align="center" class="tbldatos1">
	<tr>
		<td class="tbldatos1" width="80">Tipo Reclamo</td>
		<td class="tbldatos1">
			<input type="text" id="spdm_coddef" name="spdm_coddef" value="<?php echo @$_REQUEST["spdm_coddef"]; ?>" style="width:100px;" maxlength="3" onkeyup="CodigoToSelect(document.getElementById('spdm_coddef').value,document.getElementById('spdm_desdef'));" onkeypress="enter2tab(event,'spdm_desdef',0); return solo_numeros(event);" />
			<select id="spdm_desdef" name="spdm_desdef" style="width:450px;" onchange="document.getElementById('spdm_coddef').value=document.getElementById('spdm_desdef').options[document.getElementById('spdm_desdef').selectedIndex].value; tiporeclamo_par_defmot();" onkeypress="enter2tab(event,'fcpf_reporte1',0);">
				<option value="">Seleccione</option>
				<?php 
				$sql = "SELECT * FROM pardefrec WHERE coddef <> '999' ORDER BY coddef";
				$result=pg_query($bd_conexion,$sql);
				while ($registro=pg_fetch_assoc($result))
				{
					if ($registro["coddef"] == @$_REQUEST["spdm_coddef"])
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
