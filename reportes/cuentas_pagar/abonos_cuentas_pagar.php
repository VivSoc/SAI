<link rel="stylesheet" href="css/sweetalert.css" type="text/css">

<script type="text/javascript" src="javascript/ctas_pagar/ctas_pagar.js"></script>
<script type="text/javascript" src="js/javascript.js"></script>
<?php 
session_start();
require("../../configuracion/config.php");
require("../../configuracion/conexion.php");
require("../../clases/funciones.php");
require_once("../../clases/utilidades.class.php");
$objUtilidades=new utilidades;
$id_compra_cxp=$_REQUEST['id_compra_cxp'];
$saldo_cxp=$_REQUEST['saldo_cxp'];
$abonado_cxp=$_REQUEST['abonado_cxp'];
$sql = "SELECT * FROM detalle_cuentas_pagar where id_cue_pagar = '".@$_REQUEST['id_cuenta_cxp']."'";
$result = pg_query($bd_conexion,$sql);
?>
<table  width="100%" align="center" class='tbldatos1'>    
	<tr>
        <td align='center' class="fondo_fila_amarilla"><a href='javascript:cerrar_abonos_cxp();'><img src='css/imagenes/iconos/Delete.png' title="Cerrar Detalle"/></a></td>
		<td align="center" class="fondo_fila_amarilla">Compra Nº: <?php echo $id_compra_cxp;?></td>
		<td align="center" class="fondo_fila_amarilla">Abonos a Cuenta Nº: <?php echo $_REQUEST['id_cuenta_cxp'];?></td>
		<td align="left" class="fondo_fila_amarilla">Abonado: <?php echo number_format($abonado_cxp,2);?></td>
		<td align="left" class="fondo_fila_amarilla">Saldo: <?php echo number_format($saldo_cxp,2);?></td>
	</tr>  
	<tr>
		<td align="center" class="fondo_fila_amarilla" width="10%" colspan="2">Nº Cuenta</td>
		<td align="center" class="fondo_fila_amarilla" width="10%">Fecha Abono</td>
		<td align="center" class="fondo_fila_amarilla" width="10%">Monto Abonado</td>
		<td align="center" class="fondo_fila_amarilla" width="65%" colspan="2">Observaciones</td>
</tr>
<?php
while(($datos=pg_fetch_assoc($result))>0)
{
	echo "
	<tr>
		<td width='2%'></td>
		<td width='10%' align='center'>".$datos['id_cue_pagar']."</td>
		<td width='10%' align='center'>".$datos['fec_abono']."</td>
		<td width='10%' align='right'>".number_format($datos['mon_abono'],2)."</td>
		<td width='65%' align='left'>".$datos['observaciones']."</td>
	</tr>";	
}
?>
</table>


