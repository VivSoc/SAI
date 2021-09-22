<?php 
session_start();
require("../../../../configuracion/config.php");
require("../../../../configuracion/conexion.php");
require("../../../../clases/funciones.php");
require("../../../../clases/utilidades.class.php");
//require("../../sesion.php");
	$time=time();
//    $hora=date('H:i:s',$time);
	$fecha=date('d/m/Y');
	//esto es para voltear la fecha que viene de BD. $busqueda es el resultado del sql
	// $fecha=explode("-",$busqueda['fec_nac']);
	// $fec=$fecha['2']."/".$fecha['1']."/".$fecha['0'];
	echo"<script>document.getElementById('mov_caja_usd').focus()</script>";
?>
<html>
    <head> 
		<link rel="stylesheet" href="<?php echo $sis_estilo; ?>" type="text/css">
        <link rel="stylesheet" href="css/sweetalert.css" type="text/css">
		<script type="text/javascript" src="js/jquery.js"></script>
		<script type="text/javascript" src="js/jquery-1.4.2.min.js"></script>
		<script type="text/javascript" src="js/jquery-ui-1.8.1.custom.min.js"></script>
		<script type="text/javascript" src="js/javascript.js"></script>
        <script type="text/javascript" src="javascript/sweetalert.min.js"></script>
        <script type="text/javascript" src="javascript/ventas/movimiento_caja/movimiento_caja.js"></script>
        <title>Movimientos de Caja</title>
    </head>
    
<table width="100%" align="center" class="tbldatos1"> 
    <tr>
        
        <input type="hidden" name="fec_mov_caja" id="fec_mov_caja" value='<?php echo $fecha; ?>'/>
	
	    <td align="right"><img src="css/imagenes/dolares.png" width="50px" height="50px" />
		<td align="left"><input type="text" name="mov_caja_usd" id="mov_caja_usd"  maxlength="10" size="10" value="0.00" style="text-align:right; font-weight: bold;" onKeyPress="enter2tab(event,'mot_mov_caja',0);MASK(event,this,this.value,'-###,###,##0.00',1); return solo_dinero(event);"/>
        USD</td>

    	<td align="center">Motivo:</td>
        <td><textarea id="mot_mov_caja" name="mot_mov_caja" rows="5" cols="80" style="resize:none" maxlength="500" onClick="enter2tab(event,'mov_caja',0);"></textarea></td>
    </tr>
<table  width="100%" align="center" class='tbldatos1'>    
	<tr>
    <td align="right"><button type="button" id="limpiar_mov_caja" name="limpiar_mov_caja" onClick="limpiar_mov_caja();" style="width:65px; height:50px;"><img src="css/imagenes/iconos/cancelar.png"></button> </td>
    <td>
    </td>
	    <td align="left"> <button type="button" id="mov_caja" name="mov_caja" onClick="guarda_mov_caja();" style="width:65px; height:50px;"><img src="css/imagenes/iconos/guardar.png"></button></td>
    </tr>
    
</table>

<div id="movimiento_caja"></div>