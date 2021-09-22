<?php 
require("../../../configuracion/config.php");
require("../../../configuracion/conexion.php");
require("../../../clases/funciones.php");
require("../../../sesion.php");
if (@$_REQUEST["scu_cedusu"] != "")
{
	$_SESSION["scu_cedusu"] = @$_REQUEST["scu_cedusu"];
	?>

	<table width="700" align="center" class="tbldatos1" hidden="true">	
		<tr><td>
			<table align="center" id="sis_creusu_row"></table> 
			<div id="sis_creusu_prow" align="center"></div> 
			<script src="js/modulos/sistemas/sis_creusu/oficinas.js" type="text/javascript"> </script>
		</td></tr>
	</table>
<?php 
}
?>