<?php 
require("../../../configuracion/config.php");
require("../../../configuracion/conexion.php");
require("../../../clases/funciones.php");
require("../../../sesion.php");

?>

<script type="text/javascript" src="javascript/general/general.js"> </script>

<h3>Reporte de Clientes con N&uacute;mero de Cuenta igual al N&uacute;mero de C&eacute;dula</h3>

<table class="tbldatos1" width="600" align="center">
    <tr>
		<td width="200">Todas las Oficinas Comerciales:</td>
        <td width="400" align="left"><input type="checkbox" name="genchekofi" id="genchekofi" onclick="recarga_chekofi();">
		
	</tr>
    <tr>
		<td width="200">Oficina Comercial:</td>
        <td width="400" align="left">
		<select id="cedcta_oficina" name="cedcta_oficina" style="width:250px;"  onchange="document.getElementById('cedcta_oficina').value=document.getElementById('cedcta_oficina').options[document.getElementById('cedcta_oficina').selectedIndex].value " >
				<option value="">Seleccione</option>
				<?php 
				$result=pg_query($bd_conexion,"select * from paroficom where codofi <> '999' order by codofi");
				while ($registro=pg_fetch_assoc($result))
				{
					echo "<option value=\"".$registro["codofi"]."\">".$registro["codofi"]." - ".$registro["nomofi"]."</option>";
				}
				?>
			</select>
        </td>
	</tr>
    <tr>
		<td  width="160">Estatus:</td>
		<td  width="528">
			Activos<INPUT  type="checkbox" id="act_ced" name="act_ced" value="1"/>
            Inactivos<INPUT  type="checkbox" id="ina_ced" name="ina_ced" value="2"/>
            Cortados<INPUT  type="checkbox" id="cor_ced" name="cor_ced" value="3"/> 
            Retirados<INPUT  type="checkbox" id="ret_ced" name="ret_ced" value="5"/>                                 
		</td>
	</tr>
		
  </table>
<table class="tbldatos1" width="600" align="center">
    <tr>
    	<td colspan="2" align="center">
        	<button type="button" id="lis_cedcta" name="lis_cedcta" onclick="listado_ctaced();" style="width:30px; height:25px;"><img src="css/imagenes/imprimir.png"></button>
        </td>
    </tr>
</table>


