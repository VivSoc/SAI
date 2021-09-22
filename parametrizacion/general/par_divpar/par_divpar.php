<?php 
require("../../../../configuracion/config.php");
require("../../../../configuracion/conexion.php");
require("../../../../clases/funciones.php");
require("../../../../sesion.php");
?>

<script type="text/javascript" src="js/modulos/catastro/parametrizar/par_divpar/par_divpar.js"> </script>
	
<h3>Definici&oacute;n de Parroquia</h3>
	
<table width="700" align="center" class="tbldatos1">
<tr><td colspan="2" align="center" class="fondo_fila_amarilla">DEFINICI&Oacute;N DE PARROQUIA</td>
   </tr>
	<tr>
		<td  width="120">Estado</td>
		<td >
			<input type="text" id="cpdp_codest" name="cpdp_codest" size="10" maxlength="2" onkeyup="CodigoToSelect(document.getElementById('cpdp_codest').value,document.getElementById('cpdp_nomest'))" onkeypress="enter2tab(event,'cpdp_nomest',0); return solo_numeros(event);" />
			<select id="cpdp_nomest" name="cpdp_nomest" onchange="document.getElementById('cpdp_codest').value=document.getElementById('cpdp_nomest').options[document.getElementById('cpdp_nomest').selectedIndex].value; municipios_par_divpar();" onkeypress="enter2tab(event,'cpdp_codmun',0);">
				<option value="">Seleccione</option>
				<?php 
				$result=pg_query($bd_conexion,"select * from pardefest where codest <> '999' and codpai='01' order by codest");
				while ($registro=pg_fetch_assoc($result))
				{
					echo "<option value=\"".$registro["codest"]."\">".$registro["codest"]." - ".$registro["nomest"]."</option>";
				}
				?>
			</select>
		</td>
	</tr>
</table>
		
<div id="par_divpar_municipios">
	<table width="700" align="center" class="tbldatos1">
		<tr>
			<td  width="120">Municipio</td>
			<td >
				<input type="text" id="cpdp_codmun" name="cpdp_codmun" size="10" maxlength="2" onkeyup="CodigoToSelect(document.getElementById('cpdp_codmun').value,document.getElementById('cpdp_nommun'));" onkeypress="enter2tab(event,'cpdp_nommun',0); return solo_numeros(event);" />
				<select id="cpdp_nommun" name="cpdp_nommun" onchange="document.getElementById('cpdp_codmun').value=document.getElementById('cpdp_nommun').options[document.getElementById('cpdp_nommun').selectedIndex].value;" onkeypress="enter2tab(event,'cpdp_codigo',0);">
					<option value="">Seleccione</option>
					<?php 
					$result=pg_query($bd_conexion,"select * from pardefmun where codmun <> '999' and codest = '".$codest."' and codpai = '01' order by codmun");
					while ($registro=pg_fetch_assoc($result))
					{
						echo "<option value=\"".$registro["codmun"]."\">".$registro["codmun"]." - ".utf8($registro["nommun"])."</option>";
					}
					?>
				</select>
			</td>
		</tr>
	</table>
</div>
	
<br />
	
<div id="par_divpar_codigos">
	<table width="700" align="center" class="tbldatos1">
		<tr>
			<td width="120">C&oacute;digo Parroquia</td>
			<td><input type="text" id="cpdp_codigo" name="cpdp_codigo"  maxlength="2" size="10" onChange="verificar_par_divpar('buscar');" onkeypress="enter2tab(event,'cpdp_descripcion',0);"/></td>
		</tr>
		<tr>
			<td width="120">Nombre Parroquia</td>
			<td><input type="text" id="cpdp_descripcion" name="cpdp_descripcion" maxlength="50" size="100" onkeypress="enter2tab(event,'cpdp_alias',0);"/></td>
		</tr>
		<tr>
			<td width="120">Alias Parroquia</td>
			<td><input type="text" id="cpdp_alias" name="cpdp_alias" maxlength="50" size="100" onkeypress="enter2tab(event,'cpdp_guardar',0);"/></td>
		</tr>
	</table>	
</div>

<br />
	
<table width="700" align="center" class="tbldatos1">	
	<tr>
		<td colspan="" align="center">
			<button type="button" id="cpdp_primero" name="cpdp_primero" onclick="verificar_par_divpar('primero');" style="width:30px; height:25px;"><img src="css/imagenes/primero.png"></button>
			<button type="button" id="cpdp_anterior" name="cpdp_anterior" onclick="verificar_par_divpar('anterior');" style="width:30px; height:25px;"><img src="css/imagenes/anterior.png"></button>
			<button type="button" id="cpdp_siguiente" name="cpdp_siguiente" onclick="verificar_par_divpar('siguiente');" style="width:30px; height:25px;"><img src="css/imagenes/siguiente.png"></button>
			<button type="button" id="cpdp_ultimo" name="cpdp_ultimo" onclick="verificar_par_divpar('ultimo');" style="width:30px; height:25px;"><img src="css/imagenes/ultimo.png"></button>
			<button type="reset" id="cpdp_cancelar" name="cpdp_cancelar" onclick="limpiar_par_divpar();" style="width:30px; height:25px;"><img src="css/imagenes/cancelar.png"></button>
			<?php //if ($_SESSION["codacc"]["catasoges"]=="si"){ ?>
			<button type="button" id="cpdp_guardar" name="cpdp_guardar" onclick="guardar_par_divpar();verificar_par_divpar('cancelar');" style="width:30px; height:25px;"><img src="css/imagenes/guardar.png"></button>
			<?php //} ?>
		</td>
	</tr>
</table>

<div id="par_divpar_guardar"> </div>

<div id="mensaje"> </div>