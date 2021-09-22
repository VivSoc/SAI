<script type="text/javascript" src="javascript/compras/compras.js"></script>
<?php
@session_start();
require_once("../../../configuracion/config.php");
require_once("../../../configuracion/conexion.php");
require_once("../../../clases/utilidades.class.php");
require_once("../../../clases/funciones.php");
$objUtilidades=new utilidades;
$tabla='comp'.$_SESSION["codintusu"];
//$sql="CREATE TABLE IF NOT EXISTS $tabla (like temporal_compras)";
	$sql="SELECT FROM pg_catalog.pg_tables 
				  WHERE    tablename  = '".$tabla."'";
	$ok=pg_query($sql);
	
	if(!$ok)
	{
		$sql2="CREATE TABLE $tabla (like temporal_compras)";
		$ok2=pg_query($sql2);
	}
	
if(@$_REQUEST['codpro']=='xxx')
{
	$cod='';
}
else
{
	$doc=$_REQUEST['numdoc'];
	$cod=$_REQUEST['codpro'];
	$des=$_REQUEST['despro'];
	$pre=$_REQUEST['prepro'];
	$lot=($_REQUEST['numlot']!=''?$_REQUEST['numlot']:"S/N");
	$fec=$_REQUEST['feclot'];
	$can=$_REQUEST['canpro'];
	$med=$_REQUEST['medpro'];
	$pvd=$_REQUEST['prevendet'];
	$pvm=$_REQUEST['prevenmay'];
	$iva=$_REQUEST['ivapro'];
	$tot=$_REQUEST['totven'];
}

if($cod=='')
	{
	}
else
	{
			/* inserto en la tabla temporal*/
			$idcompra=generar_id_compra('compras','id_compra','COMP');
			$tot=$pre*$can;		
			$ins_tmp="INSERT INTO ".$tabla."(id_compra,num_docu, cod_pro_com, des_pro_com, pre_pro_com, can_pro_com, pre_ven_det,mon_iva_pro, med_pro_com,num_lote,fec_lote,pre_ven_may) VALUES ('".$idcompra."','".$doc."','".$cod."','".$des."',".$pre.",".$can.",".$pvd.",".$iva.",'".$med."','".$lot."','".$fec."',".$pvm.")";
			//var_dump($ins_tmp);
		  $ok=pg_query($ins_tmp);
		  
			
	}


$numtra=0;
$total_compra=0;
echo "
<table  align='center' width='100%' class='tbldatos1'>
<tr>
	<TD colspan='10' align='center' class='fondo_fila_amarilla'><b>Detalle de la Compra</b></TD>
</tr>
<TR align='center' class='fondo_fila_amarilla'>
	<TD width='5%'><b>Item</b></TD>
	<TD width='10%'><b>Código </b></TD>
	<TD width='30%'><b>Descripción</b></TD>
	<TD width='10%'><b>Nº Lote</b></TD>
	<TD width='10%'><b>Fecha Caducidad</b></TD>
	<TD width='5%'><b>Cantidad</b></TD>
	<TD width='10%'><b>Precio Unitario</b></TD>
	<TD width='5%'><b>I.V.A.</b></TD>
	<TD width='10%'><b>Total Item</b></TD>
	<TD width='10%'><b>Acción</b></TD>
</TR>";
$tmp="select * from $tabla";
$result=pg_query($tmp);
while(($datos=pg_fetch_assoc($result))>0)
{					
		if ($numtra%2!=1){
			$clase="bgcolor='#FFFFFF'";
		}
		else
		{
			$clase="";
		}
		$numtra=$numtra+1;
		$codigo=$datos['cod_pro_com'];
		$descripcion=$datos['des_pro_com'];
		$medida=$datos['med_pro_com'];
		$precio=$datos['pre_pro_com'];
		$iva=$datos['mon_iva_pro'];
		$cantidad=$datos['can_pro_com'];
		$num_lote=$datos['num_lote'];
		$fec_lote=$datos['fec_lote'];
		$cantidad=$datos['can_pro_com'];
		$total_precio+=$precio;
		$total_item=($precio*$cantidad);	
	echo 
	"
	<tr $clase>
		<td width='5%' align='right'>$numtra</td>
		<td width='10%' align='left'>$codigo</td>
		<td width='30%' align='left'>$descripcion</td>
		<td width='10%' align='left'>$num_lote</td>
		<td width='10%' align='right'>".formato_fecha($fec_lote)."</td>
		<td width='10%' align='right'>".$cantidad." ".$medida."</td>
		<td width='10%' align='right'>".number_format($precio,2,'.',',')."</td>
		<td width='5%' align='right'>".number_format($iva,2,'.',',')."</td>
		<td width='10%' align='right'>".number_format($total_item,2,'.',',')."</td>
		<td width='10%' align='center'><a href='javascript:eliminar_item_compras(\"$codigo\",\"$tabla\",\"$num_lote\");detalle_compras();'><img src='css/imagenes/iconos/del-pedido.jpg'/></a></td>
	</tr>";
}		
?>


</table>
</div>
<table  align='center' width='100%' class='tbldatos1'>
<?php 
 $total_compra=0;
 $objUtilidades=new utilidades;
 $sql="select sum(pre_pro_com*can_pro_com) precio_prod, (sum(pre_pro_com*can_pro_com)*mon_iva_pro/100) iva, mon_iva_pro from ".$tabla." group by mon_iva_pro";
 $result=pg_query($sql);
 $fila=0;
while(($datos=pg_fetch_assoc($result))>0)
//escapar comillas: &#39
{
	$fila+=1;
	$subtotal=$datos['precio_prod']+$datos['iva'];
	$total_compra+=$subtotal;			

echo "
<tr>
    <td width='77%'  align='left'></td>
    <td width='5%' align='right'>Tarifa ".$datos['mon_iva_pro']."%</td>
    <td width='5%'align='right'>".number_format($datos['precio_prod'],2,'.',',')."</td>
    <td width='13%'align='right'></td>
</tr>
<tr>
    <td width='77%'  align='left'></td>
    <td width='10%' align='right'>I.V.A ".$datos['mon_iva_pro']."%</td>
    <td width='10%'align='right'>".number_format($datos['iva'],2,'.',',')."</td>
    <td width='10%'align='right'></td>
</tr>";

}

echo "<tr class='fondo_fila_amarilla'>
    <td width='77%'  align='left'></td>
    <td width='10%' align='right'>Total Compra</td>
    <td width='10%'align='right'>".number_format($total_compra,2,'.',',')."</td>
    <td width='10%'align='right'></td>
</tr>";
?>
</table>
<input type="hidden" id="tot_compra" value="<?php echo $total_compra?>" />
<div id="cuerpo_detalle_pago" style="height: 15%;">
<table align='center' width='100%' class="tbldatos1">
	<tr >
    <td align="center"><button id="limpiar_compra" onClick="limpiar_compras('<?php echo $tabla;?>');"  style="width:65px;height:60px;border-radius: 12px;" title="Cancelar la compra"><img src="css/imagenes/iconos/cancelar.png"/></button></td>    
    <td align="center"><button id="guarda_compra" onClick="validar_forpagos('<?php echo $tabla;?>');"  style="width:65px;height:60px;border-radius: 12px;" title="Guardar la compra"><img src="css/imagenes/iconos/guardar.png"/></button></td>    
    </tr>
</table>
</div>
