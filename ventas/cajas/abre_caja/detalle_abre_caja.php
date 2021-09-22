<?php
@session_start();
require("../../../configuracion/config.php");
require("../../../configuracion/conexion.php");
require("../../../clases/utilidades.class.php");
require("../../../clases/funciones.php");

$_SESSION['ced_usuario'];
echo "<table  align='center' width='100%' class='tbldatos1'>
<tr>
	<TD colspan='9' align='center' class='fondo_fila_amarilla'><b>Listado General de Cajas Abiertas</b></TD>
</tr>

<TR align='center' class='fondo_fila_amarilla'>
	<TD width='5%'><b><a href='javascript:ordenar_tbl_cajas_abiertas(\"cod_caja\")' style='text-decoration:none'><font color='#FFFFFF'>Cód.</a></b></td>
	<TD width='12%'><b><a href='javascript:ordenar_tbl_cajas_abiertas(\"des_caja\")' style='text-decoration:none'><font color='#FFFFFF'>Descripción</a></b></td>
	<TD width='12%'><b><a href='javascript:ordenar_tbl_cajas_abiertas(\"fec_apertura\")' style='text-decoration:none'><font color='#FFFFFF'>Fecha de Inicio</b></a></td>
	<TD width='5%'><b><a href='javascript:ordenar_tbl_cajas_abiertas(\"hora_apertura\")' style='text-decoration:none'><font color='#FFFFFF'>Hora</b></a></td>
	<TD width='12%'><b><a href='javascript:ordenar_tbl_cajas_abiertas(\"ced_usuario\")' style='text-decoration:none'><font color='#FFFFFF'>Cód. Usuario</b></a></td>
	<TD width='12%'><b><a href='javascript:ordenar_tbl_cajas_abiertas(\"nom_usuario\")' style='text-decoration:none'><font color='#FFFFFF'>Nombre</b></a></td>
	<TD width='14%'><b><a href='javascript:ordenar_tbl_cajas_abiertas(\"fondo_caja_cop\")' style='text-decoration:none'><font color='#FFFFFF'>CoP</b></a></td>
	<TD width='14%'><b><a href='javascript:ordenar_tbl_cajas_abiertas(\"fondo_caja_usd\")' style='text-decoration:none'><font color='#FFFFFF'>USD</b></a></td>
	<TD width='14%'><b><a href='javascript:ordenar_tbl_cajas_abiertas(\"fondo_caja_bs\")' style='text-decoration:none'><font color='#FFFFFF'>Bs</b></a></td>
	
</TR>";

	$orden=(is_null(@$_REQUEST['orden']))?'cod_caja':$_REQUEST['orden'];

$numtra=0;
$sql="select a.*, b.nom_usuario, c.des_caja from apertura_caja a, usuarios b, cajas c where a.sta_apertura='A' and b.ced_usuario= a.ced_usuario and c.cod_caja=a.cod_caja order by ".$orden;
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
		$codcaja=$datos['cod_caja'];
		$fecaper=$datos['fec_apertura'];
		$horaper=$datos['hora_apertura'];
		$cedusu=$datos['ced_usuario'];
		$nomusu=$datos['nom_usuario'];
		$fondocop=$datos['fondo_caja_cop'];
		$fondousd=$datos['fondo_caja_usd'];
		$fondobs=$datos['fondo_caja_bs'];
	echo 
	"<tr $clase>
		<td width='5%'  align='left'>".$datos['cod_caja']."</td>
		<td width='12%'  align='left'>".$datos['des_caja']."</td>
		<td width='12%'  align='left'>".$datos['fec_apertura']."</td>
		<td width='5%'  align='left'>".$datos['hora_apertura']."</td>
		<td width='5%'  align='left'>".$datos['ced_usuario']."</td>
		<td width='12%'  align='left'>".$datos['nom_usuario']."</td>
		<td width='14%'  align='right'>".number_format($datos['fondo_caja_cop'],2,',','.')."</td>
		<td width='12%'  align='right'>".number_format($datos['fondo_caja_usd'],2,',','.')."</td>
		<td width='16%'  align='right'>".number_format($datos['fondo_caja_bs'],2,',','.')."</td>
		
	</tr>";
}        
?>

</table>