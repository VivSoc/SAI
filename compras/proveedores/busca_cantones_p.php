<?php 
require("../../../configuracion/config.php");
require("../../../configuracion/conexion.php");
require("../../../clases/funciones.php");
require("../../../sesion.php");
echo"<script>document.getElementById('par_id_canton').focus()</script>";
?>
	
<input type="text" id="par_id_canton" name="par_id_canton" size="10" maxlength="4" onkeyup="CodigoToSelect(document.getElementById('par_id_canton').value,document.getElementById('par_des_canton'));" onkeypress="enter2tab(event,'par_des_canton',0); return solo_numeros(event);" />
			<select id="par_des_canton" name="par_des_canton" onchange="document.getElementById('par_id_canton').value=document.getElementById('par_des_canton').options[document.getElementById('par_des_canton').selectedIndex].value; par_busca_parroquias_p();" onkeypress="enter2tab(event,'par_id_parroquia',0);">
				<option value="">Seleccione</option>
				<?php 
				$result=pg_query($bd_conexion,"select * from cantones where id_provincia = '".@$_REQUEST["par_id_provincia"]."' and sta_canton='A' order by id_provincia");
				while ($registro=pg_fetch_assoc($result))
				{
					if ($registro["id_canton"] == @$_REQUEST["par_id_canton"])
					{
						echo "<option value=\"".$registro["id_canton"]."\" selected=selected>".$registro["id_canton"]." - ".utf8($registro["des_canton"])."</option>";
					}
					else
					{
						echo "<option value=\"".$registro["id_canton"]."\">".$registro["id_canton"]." - ".utf8($registro["des_canton"])."</option>";
					}
				}
				?>
			</select><font color="#CC0000"> <i> (*) </font></i> 