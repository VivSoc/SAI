<?php 
require("../../../../configuracion/config.php");
require("../../../../configuracion/conexion.php");
require("../../../../clases/funciones.php");
require("../../../../sesion.php");
?>
	
<table width="700" align="center" class="tbldatos1">
	<tr>
		<td  width="120">Municipio</td>
		<td >
			<input type="text" id="cpdp_codmun" name="cpdp_codmun" value="<?php echo @$_REQUEST["cpdp_codmun"]; ?>" size="10" maxlength="3" onkeyup="CodigoToSelect(document.getElementById('cpdp_codmun').value,document.getElementById('cpdp_nommun'));" onkeypress="enter2tab(event,'cpdp_nommun',0); return solo_numeros(event);" />
			<select id="cpdp_nommun" name="cpdp_nommun" onchange="document.getElementById('cpdp_codmun').value=document.getElementById('cpdp_nommun').options[document.getElementById('cpdp_nommun').selectedIndex].value;" onkeypress="enter2tab(event,'cpdp_codigo',0);">
				<option value="">Seleccione</option>
				<?php 
				$result=pg_query($bd_conexion,"select * from pardefmun where codmun <> '999' and codest = '".@$_REQUEST["cpdp_codest"]."' and codpai = '01' order by codmun");
				while ($registro=pg_fetch_assoc($result))
				{
					if ($registro["codmun"] == @$_REQUEST["cpdp_codmun"])
					{
						echo "<option value=\"".$registro["codmun"]."\" selected=selected>".$registro["codmun"]." - ".utf8($registro["nommun"])."</option>";
					}
					else
					{
						echo "<option value=\"".$registro["codmun"]."\">".$registro["codmun"]." - ".utf8($registro["nommun"])."</option>";
					}
				}
				?>
			</select>
		</td>
	</tr>
</table>