<?php
@session_start();
require("../../../configuracion/config.php");
require("../../../configuracion/conexion.php");
require("../../../clases/utilidades.class.php");
require("../../../clases/funciones.php");
$fec=date('d/m/Y');

echo "<table  align='center' width='100%' class='tbldatos1'>
<tr>
	<TD colspan='6' align='center' class='fondo_fila_amarilla'><b>Movimientos de Caja</b></TD>
</tr>

<TR align='center' class='fondo_fila_amarilla'>
	<TD width='10%'><b><a href='javascript:ordenar_tbl_mov_caja(\"cop_mov\")' style='text-decoration:none'><font color='#FFFFFF'>CoP</b></a></td>
	<TD width='15%'><b><a href='javascript:ordenar_tbl_mov_caja(\"usd_mov\")' style='text-decoration:none'><font color='#FFFFFF'>USD</a></b></td>
	<TD width='15%'><b><a href='javascript:ordenar_tbl_mov_caja(\"bs_mov\")' style='text-decoration:none'><font color='#FFFFFF'>Bs.</b></a></td>
	<TD width='40%'><b><a href='javascript:ordenar_tbl_mov_caja(\"obs_mov\")' style='text-decoration:none'><font color='#FFFFFF'>Motivo</b></a></td>
	<TD width='5%'><b><a href='javascript:ordenar_tbl_mov_caja(\"hor_mov\")' style='text-decoration:none'><font color='#FFFFFF'></b>Hora</a></td>
	<TD width='10%'><b><a href='javascript:ordenar_tbl_mov_caja(\"mov_caja\")' style='text-decoration:none'><font color='#FFFFFF'>Operación</b></a></td>

	
</TR>";

	$orden=(is_null(@$_REQUEST['orden']))?'id_mov':$_REQUEST['orden'];

$numtra=0;
$sql="select * from movimientos_caja where fec_mov='".$fec."' and ced_usuario='".$_SESSION['ced_usuario']."' order by ".$orden;

$resultado=pg_query($sql);
while(($datos=pg_fetch_assoc($resultado))>0)
{					
		if ($numtra%2!=1){
			$clase="bgcolor='#FFFFFF'";
		}
		else
		{
			$clase="";
		}
		$numtra=$numtra+1;
		$operacion=$datos['mov_caja'];
		$moncop=$datos['cop_mov'];
		$monusd=$datos['usd_mov'];
		$monbs=$datos['bs_mov'];
		$motivo=$datos['obs_mov'];
		$hora=$datos['hor_mov'];
		
		
	echo 
	"<tr $clase>
	<td width='15%'  align='right'>".number_format($datos['cop_mov'],2,',','.')."</td>
		<td width='15%'  align='right'>".number_format($datos['usd_mov'],2,',','.')."</td>
		<td width='15%'  align='right'>".number_format($datos['bs_mov'],2,',','.')."</td>
		<td width='15%'  align='left'>".$datos['obs_mov']."</td>
		<td width='15%'  align='left'>".$datos['hor_mov']."</td>	
		<td width='15%'  align='left'>".$datosmov=($datos['mov_caja']=='I')?'Ingreso':'<b><font color="#FF0000">Egreso</font></b>'."</td>
			
	</tr>";
}        
?>

</table>