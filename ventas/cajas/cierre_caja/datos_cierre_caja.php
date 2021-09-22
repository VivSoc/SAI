<?php 
session_start();
require("../../../../configuracion/config.php");
require("../../../../configuracion/conexion.php");
require("../../../../clases/funciones.php");
require_once("../../../../clases/utilidades.class.php");
//require("../../sesion.php");


?>
<script type="text/javascript" src="js/jquery.js"></script>
		<script type="text/javascript" src="js/jquery-1.4.2.min.js"></script>
		<script type="text/javascript" src="js/jquery-ui-1.8.1.custom.min.js"></script>
		<script type="text/javascript" src="js/javascript.js"></script>
        <script type="text/javascript" src="javascript/ventas/cierre_caja/cierre_caja.js"></script>
		<script type="text/javascript" src="js/sweetalert.min.js"></script>
<table  width="100%" align="center" class='tbldatos1'>
	<tr>
		<td colspan="4" align="center" class="fondo_fila_amarilla">Cobro en Caja</td>
        <input type='hidden' id='cie_caj_pagos' value='cie_caj_pagos'>
	</tr>   
	<tr>
	    <td width="20%" align="center" class="fondo_fila_amarilla"> </td>
		<td width="20%" align="center" class="fondo_fila_amarilla">Formas de Pago</td>
		<td width="20%" align="center" class="fondo_fila_amarilla">Monto del Pago</td>
	    <td width="40%" align="center" class="fondo_fila_amarilla"></td>    

   </tr>   
<?php 
	$tmp="select * from formas_pago where sta_for_pago='A' and id_for_pago<>'9999' order by id_for_pago";
$result=pg_query($tmp);
$fila=0;
$objUtilidades=new utilidades;
$pagos=pg_num_rows($result);


echo "<script>document.getElementById('pagos').value='".$pagos."';</script>";
while(($datos=pg_fetch_assoc($result))>0)
//escapar comillas: &#39
{
	$fila+=1;
	echo "<tr><td width='20%' align='center' class='tbldatos1'> </td> <input type='hidden' id='cierre_caja_id_pago".$fila."' value='".$datos['id_for_pago']."'>
			<td width='20%' align='left' >".$datos['des_for_pago']."</td>
			<td width='20%' align='right' ><input type='text' id='cierre_caja_monto_pago".$fila."' size='15' value=0.00  style='text-align:right; font-size:20;' onkeypress='enter2tab(event,&#39;num_pago".$fila."&#39;,0);MASK(event,this,this.value,&#39-###,###,##0.00&#39,1);return solo_dinero(event);'</td>
			
</tr>";
	
	
}?>
</table>

<table  width="100%" align="center" class='tbldatos1'>   
	<tr>
		<td align="center"><button id="limpiar_cierre" onClick="limpiar_cie_caja();"  style="width:75px;height:70px;border-radius: 12px;" title="Cancelar el Cierre"><img src="css/imagenes/iconos/cancelar.png"/>Limpiar</button></td>   	<td align="center"><button name="cie_caja" id="cie_caja" onClick="cerrar_caja();"  style="width:75px;height:70px;border-radius: 12px;" title="Cerrar caja"><img src="css/imagenes/iconos/imprimir.png"/>Cerrar</button></td>
    </tr>
    
</table>

<div id="cierre_caja"></div>