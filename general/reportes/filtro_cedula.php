<?php 
require("../../../configuracion/config.php");
require("../../../configuracion/conexion.php");
require("../../../clases/funciones.php");
require("../../../sesion.php");
?>

<script type="text/javascript" src="javascript/general/general.js"> </script>

<div>
	<table width="700" align="center" class="tbldatos1">
    <tr  >
      <td colspan="3" align="center" class="fondo_fila_amarilla">LISTADO DE CEDULAS ERRADAS</td>
   </tr> 
			<tr>
				<td  width="100">Oficina Comercial</td>
				<td >
					<input type="text" id="cede_codofi" name="cede_codofi" value="<?php echo @$_REQUEST["cede_codofi"]; ?>" size="10" maxlength="3" onkeyup="CodigoToSelect(document.getElementById('cede_codofi').value,document.getElementById('cede_nomofi'));" onkeypress="enter2tab(event,'cede_nomofi',0); return solo_numeros(event);" />
					<select id="cede_nomofi" name="cede_nomofi" onchange="document.getElementById('cede_codofi').value=document.getElementById('cede_nomofi').options[document.getElementById('cede_nomofi').selectedIndex].value;">
						<option value="">Seleccione</option>
						<?php 
						$result=pg_query($bd_conexion,"select * from paroficom order by codofi");
						while ($registro=pg_fetch_assoc($result))
						{
							echo "<option value=\"".$registro["codofi"]."\">".$registro["codofi"]." - ".$registro["nomofi"]."</option>";
						}
						?>
				</select>
			</td>
		</tr>
	</table>
</div>
	

<br />

<?php //if(@$_REQUEST["reporte1"] == "2")  echo 'CHECKED';  ?>
	
<table width="700" align="center" class="tbldatos1">	
	<tr>
    
    
		<td>
			<input type="radio" id="cede_reporte1" name="cede_reporte" value="0" checked="checked"><b>Suscriptor</b>
			<input type="radio" id="cede_reporte2" name="cede_reporte" value="1" ><b>Receptor</b>
		</td> 
	</tr>
</table>
	
<br />
	
<table width="700" align="center" class="tbldatos1">	
	<tr >
		<td colspan="" align="center">
			<button type="button" id="cede_imprimir" name="cede_imprimir" value="imprimir" onclick="listado_cderradas()" style="width:30px; height:25px;" title="Generar Reporte"><img src="css/imagenes/imprimir.png"></button>
		</td>
	</tr>
</table>

