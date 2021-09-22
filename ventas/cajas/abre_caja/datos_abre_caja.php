
<script type="text/javascript" src="js/javascript.js"></script>
<?php 
session_start();
require("../../../../configuracion/config.php");
require("../../../../configuracion/conexion.php");
require("../../../../clases/funciones.php");
require_once("../../../../clases/utilidades.class.php");
//require("../../sesion.php");
//	$time=time();
   // $hora=date('H:i:s',$time);
	$fecha=date('d/m/Y');
	$cedusu=$_SESSION['scu_cedusu'];
	//esto es para voltear la fecha que viene de BS. $busqueda es el resultado del sql
	// $fecha=explode("-",$busqueda['fec_nac']);
	// $fec=$fecha['2']."/".$fecha['1']."/".$fecha['0'];
	echo"<script>document.getElementById('fondo_caja_usd').focus()</script>";
?>

<table width="100%" align="center" class="tbldatos1">
	<tr>
		<td colspan="6" align="center" class="fondo_fila_amarilla";>Fondo de Caja</td>
	</tr>  
        <input type="hidden" name="ced_usuario" id="ced_usuario" value='<?php echo $cedusu; ?>'/>
        <input type="hidden" name="fec_aper_caja" id="fec_aper_caja" value='<?php echo $fecha; ?>'/>
	<tr>
		<td width="20%" align="center"><input type="text" name="fondo_caja_usd" id="fondo_caja_usd"  maxlength="10" size="15" value="0.00" style="text-align:right; font-weight: bold;" onkeypress="enter2tab(event,'aper_caja',0);MASK(event,this,this.value,'-###,###,###,##0.00',1);return solo_dinero(event);"/>
        USD</td>
	    <td width="45%" align="left"><button name="aper_caja" id="aper_caja" onClick="abrir_caja();"  style="width:40px;height:40px;border-radius: 12px;" title="Abrir caja"><img src="css/imagenes/iconos/inicio.png"/>Abrir</button></td>
    </tr>
    
</table>

<div id="apertura_caja"></div>