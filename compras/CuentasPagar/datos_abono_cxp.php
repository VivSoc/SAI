<link rel="stylesheet" href="css/sweetalert.css" type="text/css">

<script type="text/javascript" src="javascript/compras/cuentaspagar.js"></script>
<script type="text/javascript" src="js/javascript.js"></script>
<?php 
session_start();
require("../../../configuracion/config.php");
require("../../../configuracion/conexion.php");
require("../../../clases/funciones.php");
require_once("../../../clases/utilidades.class.php");
$objUtilidades=new utilidades;

$sql = "SELECT * FROM detalle_cuentas_pagar where id_cue_pagar = '".@$_REQUEST['idcompra']."'";
$result = pg_query($bd_conexion,$sql);
?>

<table  width="100%" align="center" class='tbldatos1' >
	<tr>
    	<input type="hidden" id="idctaxpagar" value='<?php echo $_REQUEST['idcompra']; ?>'/>
    	<input type="hidden" id="monabonado" value='<?php echo $_REQUEST['montosaldo']; ?>'/>
		<td >Cuenta por Pagar: <?php echo $_REQUEST['idcompra'];?></td>
		<td >Fecha Abono</td>
		<td><input type='text' value='<?php echo date('d/m/Y');?>' name='fechaabono_cxp' id='fechaabono_cxp' onKeypress="enter2tab(event,'observaciones_cxp',0);"/>
		<td >Observaciones</td>
		<td><input type='text' style="width:400px;" maxlength="200" name='observaciones_cxp' id='observaciones_cxp' onKeypress="enter2tab(event,'montoabono_cxp',0);"  /></td>  
		<td >Monto del Abono</td>
		<td><input type='text'  name='montoabono_cxp' id='montoabono_cxp' value="0.00" onKeypress="enter2tab(event,'guarda_abono_cxp',0);MASK(event,this,this.value,'-###,###,##0.00',1);return solo_dinero(event);"/></td>  
	</tr>
    <tr>
   		<td >Saldo de la Cuenta: <?php echo number_format($_REQUEST['montosaldo'],2);?></td>
    </tr>
    <tr>
     <td align="center" colspan="6">
     <button id="limpiar_compra" onClick="limpiar_abonos_cxp();"  style="width:65px;height:60px;border-radius: 12px;" title="Cancelar el Abono"><img src="css/imagenes/iconos/cancelar.png"/></button>
     
    <button id="guarda_abono_cxp" onClick="guardar_abonos_cxp();"  style="width:65px;height:60px;border-radius: 12px;" title="Guardar el Abono"><img src="css/imagenes/iconos/guardar.png"/></button>
    </td> 
    </tr>
</table> 

