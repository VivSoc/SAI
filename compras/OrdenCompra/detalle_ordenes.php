<script type="text/javascript" src="javascript/compras/ordenescompras.js"></script>
<?php
@session_start();
require_once("../../../configuracion/config.php");
require_once("../../../configuracion/conexion.php");
require_once("../../../clases/utilidades.class.php");
require_once("../../../clases/funciones.php");
$objUtilidades=new utilidades;
$tabla='ord'.$_SESSION["codintusu"];
//$sql="CREATE TABLE IF NOT EXISTS $tabla (like temporal_compras)";
	$sql="SELECT FROM pg_catalog.pg_tables 
				  WHERE    tablename  = '".$tabla."'";
	$ok=pg_query($sql);

	if(pg_num_rows($ok)==0)
	{

		$sql2="CREATE TABLE $tabla (like temporal_ordenes_compras)";
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
	$alt=$_REQUEST['codalt'];
	$des=$_REQUEST['despro'];
	$can=$_REQUEST['canpro'];
	$med=$_REQUEST['medpro'];
}

if($cod=='')
	{
	}
else
	{
			/* inserto en la tabla temporal*/
			$idorden=generar_id_compra('ordenes','id_orden','ORDE');
			$tot=$pre*$can;		
			$ins_tmp="INSERT INTO ".$tabla."(id_orden,cod_pro_com, des_pro_com, can_pro_com, med_pro_com,cod_alt) VALUES ('".$idorden."','".$cod."','".$des."',".$can.",'".$med."','".$alt."')";
//			var_dump($ins_tmp);
		  $ok=pg_query($ins_tmp);			
	}


$numtra=0;
$total_compra=0;
echo "
<table  align='center' width='100%' class='tbldatos1'>
<tr>
	<TD colspan='6' align='center' class='fondo_fila_amarilla'><b>Detalle de la Compra</b></TD>
</tr>
<TR align='center' class='fondo_fila_amarilla'>
	<TD width='5%'><b>Item</b></TD>
	<TD width='10%'><b>Código</b></TD>
	<TD width='15%'><b>Alterno</b></TD>
	<TD width='60%'><b>Descripción</b></TD>
	<TD width='10%'><b>Cantidad</b></TD>
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
		$alterno=$datos['cod_alt'];
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
	" <input type='hidden' id='items_orden' value=".$numtra."/>
	<tr $clase>
		<td width='5%' align='right'>$numtra</td>
		<td width='10%' align='left'>$codigo</td>
		<td width='15%' align='left'>$alterno</td>
		<td width='60%' align='left'>$descripcion</td>
		<td width='10%' align='right'>".$cantidad." ".$medida."</td>
		<td width='10%' align='center'><a href='javascript:eliminar_item_ordenes(\"$codigo\",\"$tabla\",\"$num_lote\");detalle_ordenes();'><img src='css/imagenes/iconos/del-pedido.jpg'/></a></td>
	</tr>";
}		
?>


</table>
</div>
<table align='center' width='100%' class="tbldatos1">
	<tr >
    <td align="center"><button id="limpiar_orden_compra" onClick="limpiar_orden_compra('<?php echo $tabla;?>');"  style="width:65px;height:60px;border-radius: 12px;" title="Cancelar la Orden"><img src="css/imagenes/iconos/cancelar.png"/></button></td>    
    <td align="center"><button id="guarda_orden_compra" onClick="guardar_orden_compra('<?php echo $tabla;?>');"  style="width:65px;height:60px;border-radius: 12px;" title="Guardar la Orden de Compra"><img src="css/imagenes/iconos/guardar.png"/></button></td>    
    </tr>
</table>
</div>
