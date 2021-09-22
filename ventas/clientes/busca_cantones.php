<?php 
require("../../../configuracion/config.php");
require("../../../configuracion/conexion.php");
require("../../../clases/funciones.php");
require("../../../sesion.php");
echo"<script>document.getElementById('id_canton').focus()</script>";
?>
	
<input type="text" id="id_canton" name="id_canton" size="10" maxlength="4" onkeyup="CodigoToSelect(document.getElementById('id_canton').value,document.getElementById('des_canton'));" onkeypress="enter2tab(event,'des_canton',0); return solo_numeros(event);" />
			<select id="des_canton" name="des_canton" onchange="document.getElementById('id_canton').value=document.getElementById('des_canton').options[document.getElementById('des_canton').selectedIndex].value; busca_parroquias();" onkeypress="enter2tab(event,'id_parroquia',0);">
				<option value="">Seleccione</option>
				<?php 
				$result=pg_query($bd_conexion,"select * from cantones where id_provincia = '".@$_REQUEST["id_provincia"]."' and sta_canton='A' order by id_provincia");
				while ($registro=pg_fetch_assoc($result))
				{
					if ($registro["id_canton"] == @$_REQUEST["id_canton"])
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