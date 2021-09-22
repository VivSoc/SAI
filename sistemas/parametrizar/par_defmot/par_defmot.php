<?php 
require("../../../../configuracion/config.php");
require("../../../../configuracion/conexion.php");
require("../../../../clases/funciones.php");
require("../../../../sesion.php");
?>

<script type="text/javascript" src="js/modulos/sistemas/parametrizar/par_defmot/par_defmot.js"> </script>

<h3>Definici&oacute;n de Motivos</h3>
	
<table width="700" align="center" class="tbldatos1">
	<tr>
		<td class="tbldatos1" width="80">Tipo Motivo</td>
		<td class="tbldatos1">
			<input type="text" id="spdm_codmot" name="spdm_codmot" value="<?php echo @$_REQUEST["spdm_codmot"]; ?>" style="width:100px;" maxlength="3" onkeyup="CodigoToSelect(document.getElementById('spdm_codmot').value,document.getElementById('spdm_desmot'));" onkeypress="enter2tab(event,'spdm_desmot',0); return solo_numeros(event);" />
			<select id="spdm_desmot" name="spdm_desmot" style="width:450px;" onchange="document.getElementById('spdm_codmot').value=document.getElementById('spdm_desmot').options[document.getElementById('spdm_desmot').selectedIndex].value; tiporeclamo_par_defmot(); limpiar_par_defmot();" onkeypress="enter2tab(event,'fcpf_reporte1',0);">
				<option value="">Seleccione</option>
				<?php 
				$sql = "SELECT * FROM partipmot WHERE codtip <> '999' ORDER BY codtip";
				$result=pg_query($bd_conexion,$sql);
				while ($registro=pg_fetch_assoc($result))
				{
					echo "<option value=\"".$registro["codtip"]."\">".$registro["codtip"]." - ".$registro["destip"]."</option>";
				}
				?>
			</select>
		</td>
	</tr>
</table>

<div id="par_defmot_codigos">
	<table width="700" align="center" class="tbldatos1">
		<tr>
			<td width="80">C&oacute;digo</td>
			<td>
				<input type="text" id="spdm_codigo" name="spdm_codigo"  maxlength="3" style="width:100px;" onchange="verificar_par_defmot('buscar');" onkeypress="enter2tab(event,'spdm_descripcion',0);"/>
			</td>
		</tr>
		<tr>
			<td width="80">Descripci&oacute;n</td>
			<td>
				<input type="text" id="spdm_descripcion" name="spdm_descripcion" maxlength="100" style="width:550px;" onkeypress="enter2tab(event,'spdm_guardar',0);"/>
			</td>
		</tr>
	</table>	
</div>

<div id="par_defmot_tiporeclamo"> </div>
	
<br />

<table width="700" align="center" class="tbldatos1">	
	<tr>
		<td colspan="" align="center">
			<button type="button" id="spdm_primero" name="spdm_primero" onclick="verificar_par_defmot('primero');" style="width:30px; height:25px;"><img src="css/imagenes/primero.png"></button>
			<button type="button" id="spdm_anterior" name="spdm_anterior" onclick="verificar_par_defmot('anterior');" style="width:30px; height:25px;"><img src="css/imagenes/anterior.png"></button>
			<button type="button" id="spdm_siguiente" name="spdm_siguiente" onclick="verificar_par_defmot('siguiente');" style="width:30px; height:25px;"><img src="css/imagenes/siguiente.png"></button>
			<button type="button" id="spdm_ultimo" name="spdm_ultimo" onclick="verificar_par_defmot('ultimo');" style="width:30px; height:25px;"><img src="css/imagenes/ultimo.png"></button>
			<button type="reset" id="spdm_cancelar" name="spdm_cancelar" onclick="limpiar_par_defmot();" style="width:30px; height:25px;"><img src="css/imagenes/cancelar.png"></button>
			<button type="button" id="spdm_guardar" name="spdm_guardar" onclick="guardar_par_defmot();verificar_par_defmot('cancelar');" style="width:30px; height:25px;"><img src="css/imagenes/guardar.png"></button>
		</td>
	</tr>
</table>

<div id="par_defmot_guardar"> </div>

<div id="mensaje"> </div>
