<?php 
require("../../../../configuracion/config.php");
require("../../../../configuracion/conexion.php");
require("../../../../clases/funciones.php");
require("../../../../sesion.php");
?>

<script type="text/javascript" src="js/modulos/catastro/parametrizar/par_divmun/par_divmun.js"> </script>


	
<div id="par_divmun_codigos">
	<table width="700" align="center" class="tbldatos1">
<tr><td colspan="2" align="center" class="fondo_fila_amarilla">DEFINICI&Oacute;N DE MUNICIPIOS</td>
   </tr>    
		<tr>
			<td  width="120">Estado</td>
			<td >
				<input type="text" id="cpdm_codest" name="cpdm_codest" value="<?php echo @$_REQUEST["cpdm_codest"]; ?>" size="10" maxlength="2" onkeyup="CodigoToSelect(document.getElementById('cpdm_codest').value,document.getElementById('cpdm_nomest'))" onkeypress="enter2tab(event,'cpdm_nomest',0); return solo_numeros(event);" />
				<select id="cpdm_nomest"  name="cpdm_nomest" onchange="document.getElementById('cpdm_codest').value=document.getElementById('cpdm_nomest').options[document.getElementById('cpdm_nomest').selectedIndex].value; " onkeypress="enter2tab(event,'cpdm_codigo',0);">
					<option value="">Seleccione</option>
					<?php 
					$result=pg_query($bd_conexion,"select * from pardefest where codest <> '999' and codpai = '01' order by codest");
					while ($registro=pg_fetch_assoc($result))
					{
						echo "<option value=\"".$registro["codest"]."\">".$registro["codest"]." - ".$registro["nomest"]."</option>";
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
			<td><input type="text" id="cpdm_codigo" name="cpdm_codigo"  maxlength="2" size="10" onChange="verificar_par_divmun('buscar');" onkeypress="enter2tab(event,'cpdm_descripcion',0);"/></td>
		</tr>
		<tr>
			<td width="120">Nombre del Municipio</td>
			<td><input type="text" id="cpdm_descripcion" name="cpdm_descripcion" maxlength="50" size="100" onkeypress="enter2tab(event,'cpdm_alias',0);"/></td>
		</tr>
		<tr>
			<td width="120">Alias del Municipio</td>
			<td><input type="text" id="cpdm_alias" name="cpdm_alias" maxlength="50" size="100" onkeypress="enter2tab(event,'cpdm_guardar',0);"/></td>
		</tr>
	</table>	
</div>
	
<br />
	
<table width="700" align="center" class="tbldatos1">	
	<tr>
		<td colspan="" align="center">
			<button type="button" id="cpdm_primero" name="cpdm_primero" onclick="verificar_par_divmun('primero');" style="width:30px; height:25px;"><img src="css/imagenes/primero.png"></button>
			<button type="button" id="cpdm_anterior" name="cpdm_anterior" onclick="verificar_par_divmun('anterior');" style="width:30px; height:25px;"><img src="css/imagenes/anterior.png"></button>
			<button type="button" id="cpdm_siguiente" name="cpdm_siguiente" onclick="verificar_par_divmun('siguiente');" style="width:30px; height:25px;"><img src="css/imagenes/siguiente.png"></button>
			<button type="button" id="cpdm_ultimo" name="cpdm_ultimo" onclick="verificar_par_divmun('ultimo');" style="width:30px; height:25px;"><img src="css/imagenes/ultimo.png"></button>
			<button type="reset" id="cpdm_cancelar" name="cpdm_cancelar" onclick="limpiar_par_divmun();" style="width:30px; height:25px;"><img src="css/imagenes/cancelar.png"></button>
			<?php //if ($_SESSION["codacc"]["catasoges"]=="si"){ ?>
			<button type="button" id="cpdm_guardar" name="cpdm_guardar" onclick="guardar_par_divmun();limpiar_par_divmun();" style="width:30px; height:25px;"><img src="css/imagenes/guardar.png"></button>
			<?php //} ?>
		</td>
	</tr>
</table>

<div id="par_divmun_guardar"> </div>

<div id="mensaje"> </div>