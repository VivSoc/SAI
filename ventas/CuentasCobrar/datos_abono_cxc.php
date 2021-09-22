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

$sql = "SELECT * FROM detalle_cuentas_cobrar where id_cue_cobrar = '".@$_REQUEST['idventa']."'";
$result = pg_query($bd_conexion,$sql);
?>

<table  width="100%" align="center" class='tbldatos1' >
	<tr>
    	<input type="hidden" id="idctaxcobrar" value='<?php echo $_REQUEST['idventa']; ?>'/>
    	<input type="hidden" id="monabonado" value='<?php echo $_REQUEST['montosaldo']; ?>'/>
		<td >Cuenta por Cobrar: <?php echo $_REQUEST['idventa'];?></td>
		<td >Fecha Abono</td>
		<td><input type='text' value='<?php echo date('d/m/Y');?>' name='fechaabono_cxc' id='fechaabono_cxc' onKeypress="enter2tab(event,'observaciones_cxc',0);"/>
		<td >Observaciones</td>
		<td><input type='text' style="width:400px;" maxlength="200" name='observaciones_cxc' id='observaciones_cxc' onKeypress="enter2tab(event,'montoabono_cxc',0);"  /></td>  
		<td >Monto del Abono</td>
		<td><input type='text'  name='montoabono_cxc' id='montoabono_cxc' value="0.00" onKeypress="enter2tab(event,'guarda_abono_cxc',0);MASK(event,this,this.value,'-###,###,##0.00',1);return solo_dinero(event);"/></td>  
	</tr>
    <tr>
   		<td >Saldo de la Cuenta: <?php echo number_format($_REQUEST['montosaldo'],2);?></td>
    </tr>
    <tr>
     <td align="center" colspan="6">
     <button id="limpiar_venta" onClick="limpiar_abonos_cxc();"  style="width:65px;height:60px;border-radius: 12px;" title="Cancelar el Abono"><img src="css/imagenes/iconos/cancelar.png"/></button>
     
    <button id="guarda_abono_cxc" onClick="guardar_abonos_cxc();"  style="width:65px;height:60px;border-radius: 12px;" title="Guardar el Abono"><img src="css/imagenes/iconos/guardar.png"/></button>
    </td> 
    </tr>
</table> 

