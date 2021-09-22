<?php 
require("../../../../configuracion/config.php");
require("../../../../configuracion/conexion.php");
require("../../../../clases/funciones.php");
require("../../../../sesion.php");
?>
	
<table width="700" align="center" class="tbldatos1">
	<tr>
		<td  width="120">Cantón</td>
		<td >
			<input type="text" id="id_canton_p" name="id_canton_p" value="<?php echo @$_REQUEST["id_canton_p"]; ?>" size="10" maxlength="4" onkeyup="CodigoToSelect(document.getElementById('id_canton_p').value,document.getElementById('des_canton_p'));" onkeypress="enter2tab(event,'des_canton_p',0); return solo_numeros(event);" />
			<select id="des_canton_p" name="des_canton_p" onchange="document.getElementById('id_canton_p').value=document.getElementById('des_canton_p').options[document.getElementById('des_canton_p').selectedIndex].value;" onkeypress="enter2tab(event,'id_parroquia_p',0);">
				<option value="">Seleccione</option>
				<?php 
				$result=pg_query($bd_conexion,"select * from cantones where id_provincia = '".@$_REQUEST["id_provincia_p"]."' and sta_canton='A' order by id_provincia");
				while ($registro=pg_fetch_assoc($result))
				{
					if ($registro["id_canton"] == @$_REQUEST["id_canton_p"])
					{
						echo "<option value=\"".$registro["id_canton"]."\" selected=selected>".$registro["id_canton"]." - ".utf8($registro["des_canton"])."</option>";
					}
					else
					{
						echo "<option value=\"".$registro["id_canton"]."\">".$registro["id_canton"]." - ".utf8($registro["des_canton"])."</option>";
					}
				}
				?>
			</select>
		</td>
	</tr>
</table>