<link rel="stylesheet" href="css/sweetalert.css" type="text/css">

<script type="text/javascript" src="javascript/ventas/cuentascobrar.js"></script>
<script type="text/javascript" src="js/javascript.js"></script>
<?php 
session_start();
require("../../../configuracion/config.php");
require("../../../configuracion/conexion.php");
require("../../../clases/funciones.php");
require_once("../../../clases/utilidades.class.php");
$objUtilidades=new utilidades;

$sql = "SELECT * FROM clientes_proveedores  where id_cli_pro = '".@$_REQUEST['id_cliente']."' and estatus='A'";
$result = pg_query($bd_conexion,$sql);
if (pg_num_rows($result)<=0)
{
	echo"<script language='javascript'>
	swal('El cliente está inactivo o no está registrado', 'Por favor verifique los datos', 'warning');
	document.getElementById('id_cliente').focus()
	</script>";
	return;
}
?>

<div id='cuerpo_datos_cliente_cxc'>
<table  width="100%" align="center" class='tbldatos1' >
	<tr>
		<td >Razón Social</td>
		<td><input type='text' style="width:200px;" value='<?php if (pg_num_rows($result)>0) echo utf8(pg_fetch_result($result,0,"nombre")); ?>' name='razoncliente_cxc' id='razoncliente_cxc' maxlength='30'  readonly/>
		<td >Dirección</td>
		<td><input type='text' style="width:400px;" value='<?php if (pg_num_rows($result)>0) echo utf8(pg_fetch_result($result,0,"direccion")); ?>' name='dircliente_cxc' id='dircliente_cxc' maxlength='50' readonly  /></td>  
	</tr>
	<tr>
		<td >Teléfono</td>
		<td><input type='text' style="width:400px;" value='<?php if (pg_num_rows($result)>0) echo utf8(pg_fetch_result($result,0,"telefono")); ?>' name='telcliente_cxc' id='telcliente_cxc' maxlength='50' readonly  /></td>  
	</tr>
</table>
<?php

$sql = "SELECT a.*,b.id_venta,c.des_tip_documento FROM cuentas_cobrar a,ventas b,tipos_documentos c where a.id_cli_pro = '".@$_REQUEST['id_cliente']."' and b.id_venta=a.id_venta and c.id_tip_documento=b.id_tipo_doc_ven order by a.id_venta";
//var_dump($sql);
$result = pg_query($bd_conexion,$sql);
?>
<table  width="100%" align="center" class='tbldatos1'>    
	<tr>
		<td colspan="9" align="center" class="fondo_fila_amarilla">Datos de las Cuentas por Cobrar</td>
	</tr>  
	<tr>
		<td align="center" class="fondo_fila_amarilla">Nº Venta</td>
		<td align="center" class="fondo_fila_amarilla">Nº Cuenta por Cobrar</td>
		<td align="center" class="fondo_fila_amarilla">Tipo Documento</td>
		<td align="center" class="fondo_fila_amarilla">Nº Documento</td>
		<td align="center" class="fondo_fila_amarilla">Fecha Venta</td>
		<td align="center" class="fondo_fila_amarilla">Fecha Vencimiento</td>
		<td align="center" class="fondo_fila_amarilla">Total Venta</td>
		<td align="center" class="fondo_fila_amarilla">Total Abonado</td>
		<td align="center" class="fondo_fila_amarilla">Saldo Pendiente</td>
	</tr>
<?php
while(($datos=pg_fetch_assoc($result))>0)
{
	$cxc=$objUtilidades->buscar_datos($sql="select sum(mon_abono) abonado from detalle_cuentas_cobrar where id_cue_cobrar='".$datos['id_cue_cobrar']."'");
//	$saldo=number_format(($datos['mon_debito']-$cxp['abonado']),2);
		$saldo=$datos['mon_credito']-$cxc['abonado'];
	$idventa=$datos['id_venta'];
	$idcxc=$datos['id_cue_cobrar'];
	$abonado=($cxc['abonado']!=0?$cxc['abonado']:0);
	if($saldo>0)
	{
	echo 
	"<tr>
		<td align='right'><a href='javascript:buscar_cuentaxcobrar(&#39;".$idcxc."&#39;,".$saldo.")' style='text-decoration:underline; color:#06F;'>".$datos['id_venta']."</a></td>
		<td align='right'>".$datos['id_cue_cobrar']."</td>
		<td align='right'>".$datos['des_tip_documento']."</td>
		<td align='right'>".$datos['num_documento']."</td>
		<td align='center'>".formato_fecha($datos['fec_reg_venta'])."</td>
		<td align='center'>".formato_fecha($datos['fec_vencimiento'])."</td>
		<td align='right'>".number_format($datos['mon_credito'],2)."</td>
		<td align='right'>".number_format($abonado,2)."</td>
		<td align='right'>".number_format($saldo,2)."</td>
	</tr>
	";
	}
}
?>     
</table>

<table  width="100%" align="center" class='tbldatos1' >
</table>
    
</div>
