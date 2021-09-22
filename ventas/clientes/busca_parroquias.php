<?php 
require("../../../configuracion/config.php");
require("../../../configuracion/conexion.php");
require("../../../clases/funciones.php");
require("../../../sesion.php");
echo"<script>document.getElementById('id_parroquia').focus()</script>";
?>
	
<input type="text" id="id_parroquia" name="id_parroquia" size="10" maxlength="4" onkeyup="CodigoToSelect(document.getElementById('id_parroquia').value,document.getElementById('des_parroquia'));" onkeypress="enter2tab(event,'des_parroquia',0); return solo_numeros(event);" />
			<select id="des_parroquia" name="des_parroquia" onchange="document.getElementById('id_parroquia').value=document.getElementById('des_parroquia').options[document.getElementById('des_parroquia').selectedIndex].value;">
				<option value="">Seleccione</option>
				<?php 
				$result=pg_query($bd_conexion,"select * from parroquias where id_provincia = '".@$_REQUEST["id_provincia"]."' and id_canton='".@$_REQUEST["id_canton"]."' and sta_parroquia='A' order by id_canton");
				while ($registro=pg_fetch_assoc($result))
				{
					if ($registro["id_parroquia"] == @$_REQUEST["id_parroquia"])
					{
						echo "<option value=\"".$registro["id_parroquia"]."\" selected=selected>".$registro["id_parroquia"]." - ".utf8($registro["des_parroquia"])."</option>";
					}
					else
					{
						echo "<option value=\"".$registro["id_parroquia"]."\">".$registro["id_parroquia"]." - ".utf8($registro["des_parroquia"])."</option>";
					}
				}
				?>
			</select><font color="#CC0000"> <i> (*) </font></i> 