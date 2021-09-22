<link rel="stylesheet" href="css/sweetalert.css" type="text/css">

<script type="text/javascript" src="javascript/compras/compras.js"></script>
<script type="text/javascript" src="js/javascript.js"></script>
<?php 
session_start();
require("../../../configuracion/config.php");
require("../../../configuracion/conexion.php");
require("../../../clases/funciones.php");
require_once("../../../clases/utilidades.class.php");
$objUtilidades=new utilidades;

$sql = "SELECT * FROM clientes_proveedores  where id_cli_pro = '".@$_REQUEST['id_proveedor']."' and estatus='A'";
$result = pg_query($bd_conexion,$sql);
if (pg_num_rows($result)<=0)
{
	echo"<script language='javascript'>
	swal('Proveedor está Inactivo o no está Registrado', 'Por favor verifique los datos', 'warning');
	document.getElementById('id_proveedor').focus()
	</script>";
	return;
}
?>

<div id='cuerpo_datos_proveedor_cxp'>
<table  width="100%" align="center" class='tbldatos1' >
	<tr>
		<td >Razón Social</td>
		<td><input type='text' style="width:200px;" value='<?php if (pg_num_rows($result)>0) echo utf8(pg_fetch_result($result,0,"nombre")); ?>' name='razonproveedor_cxp' id='razonproveedor_cxp' maxlength='30'  readonly/>
		<td >Dirección</td>
		<td><input type='text' style="width:400px;" value='<?php if (pg_num_rows($result)>0) echo utf8(pg_fetch_result($result,0,"direccion")); ?>' name='dirproveedor_cxp' id='dirproveedor_cxp' maxlength='50' readonly  /></td>  
	</tr>
	<tr>
		<td >Persona de contacto</td>
		<td><input type='text' style="width:200px;" value='<?php if (pg_num_rows($result)>0) echo utf8(pg_fetch_result($result,0,"contacto")); ?>' name='contactoproveedor_cxp' id='contactoproveedor_cxp' maxlength='30'  readonly/>
		<td >Teléfono de Contacto</td>
		<td><input type='text' style="width:400px;" value='<?php if (pg_num_rows($result)>0) echo utf8(pg_fetch_result($result,0,"telefono")); ?>' name='telproveedor_cxp' id='telproveedor_cxp' maxlength='50' readonly  /></td>  
	</tr>
</table>
<?php

$sql = "SELECT a.*,b.num_documento,c.des_tip_documento FROM cuentas_pagar a,compras b,tipos_documentos c where a.id_cli_pro = '".@$_REQUEST['id_proveedor']."' and b.id_compra=a.id_compra and c.id_tip_documento=b.id_tipo_doc_com order by a.id_compra";
$result = pg_query($bd_conexion,$sql);
?>
<table  width="100%" align="center" class='tbldatos1'>    
	<tr>
		<td colspan="9" align="center" class="fondo_fila_amarilla">Datos de las Cuentas por Pagar</td>
	</tr>  
	<tr>
		<td align="center" class="fondo_fila_amarilla">Nº Compra</td>
		<td align="center" class="fondo_fila_amarilla">Nº Cuenta por Pagar</td>
		<td align="center" class="fondo_fila_amarilla">Tipo Documento</td>
		<td align="center" class="fondo_fila_amarilla">Nº Documento</td>
		<td align="center" class="fondo_fila_amarilla">Fecha Compra</td>
		<td align="center" class="fondo_fila_amarilla">Fecha Vencimiento</td>
		<td align="center" class="fondo_fila_amarilla">Total Compra</td>
		<td align="center" class="fondo_fila_amarilla">Total Abonado</td>
		<td align="center" class="fondo_fila_amarilla">Saldo Pendiente</td>
	</tr>
<?php
while(($datos=pg_fetch_assoc($result))>0)
{
	$cxp=$objUtilidades->buscar_datos($sql="select sum(mon_abono) abonado from detalle_cuentas_pagar where id_cue_pagar='".$datos['id_cue_pagar']."'");
//	$saldo=number_format(($datos['mon_debito']-$cxp['abonado']),2);
		$saldo=$datos['mon_debito']-$cxp['abonado'];

	$idcompra=$datos['id_compra'];
	$idcxp=$datos['id_cue_pagar'];
	$abonado=($cxp['abonado']!=0?$cxp['abonado']:0);
	if($saldo>0)
	{
	echo 
	"<tr>
		<td align='right'><a href='javascript:buscar_cuentaxpagar(&#39;".$idcxp."&#39;,".$saldo.")' style='text-decoration:underline; color:#06F;'>".$datos['id_compra']."</a></td>
		<td align='right'>".$datos['id_cue_pagar']."</td>
		<td align='right'>".$datos['des_tip_documento']."</td>
		<td align='right'>".$datos['num_documento']."</td>
		<td align='center'>".formato_fecha($datos['fec_reg_compra'])."</td>
		<td align='center'>".formato_fecha($datos['fec_vencimiento'])."</td>
		<td align='right'>".number_format($datos['mon_debito'],2)."</td>
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
