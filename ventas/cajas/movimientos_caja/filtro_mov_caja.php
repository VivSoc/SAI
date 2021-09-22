<?php 
	session_start();
	require("../../../../configuracion/config.php");
	require("../../../../configuracion/conexion.php");
	require("../../../../clases/funciones.php");
	require("../../../../clases/utilidades.class.php");
	$sis_estilo="../".$sis_estilo;
	$fec=date('d/m/Y');
	
	$objUtilidades=new utilidades;
	$nom_caja=$objUtilidades->buscar_datos($sql = "select a.*, b.des_caja from abre_cajas a, cajas b where a.id_usuario='".$_SESSION['scu_cedusu']."' and a.sta_abertura='A' 
and a.fec_abertura='".$fec."' and b.id_caja=a.id_caja");

	if($nom_caja['des_caja']!="")
	{
		$descaja=utf8_decode($nom_caja['des_caja']);
	}
	else
	{
		$descaja='NO HA ABIERTO CAJA';
	}

	
?>
<html>
    <head> 
		<link rel="stylesheet" href="<?php echo $sis_estilo; ?>" type="text/css">
        <link rel="stylesheet" href="css/sweetalert.css" type="text/css">
		<script type="text/javascript" src="js/jquery.js"></script>
		<script type="text/javascript" src="js/jquery-1.4.2.min.js"></script>
		<script type="text/javascript" src="js/jquery-ui-1.8.1.custom.min.js"></script>
		<script type="text/javascript" src="js/javascript.js"></script>
        
        <script type="text/javascript" src="js/sweetalert.min.js"></script>
        <script type="text/javascript" src="javascript/ventas/movimiento_caja/movimiento_caja.js"></script>
        
        <title>Movimientos de Caja</title>
    </head>
<table width="100%" align="center" class='tbldatos1'>
	<tr>
		<td colspan="6" align="center" class="fondo_fila_amarilla";>Movimientos de Caja</td>
	</tr>  
    <tr>
		<td width="10%" >Usuario:</td>
		<td width="90%" ><font color="#000066"><?php echo $_SESSION["nomusu"];?></font></td>
        <input type="hidden" name="mov_caja_ced_usuario" id="mov_caja_ced_usuario" value="<?php echo $_SESSION['scu_cedusu'];?>">
	</tr>
    <tr>	
    	<td >Caja:</td>
        <td><font color="#000066"><?php echo $descaja;?></font></td>
       <input type="hidden" name="mov_caja_cod_caja" id="mov_caja_cod_caja" value="<?php echo $nom_caja['id_caja'];?>">
	</tr>
</table> 

<table width="100%" align="center" class="tbldatos1">
	<tr>
		<td colspan="4" align="center" class="fondo_fila_amarilla";>Operación a Realizar</td>
	</tr> 
    <tr>
    	<td align="center"><input type="radio" id="ope_mov_caja" name="ope_mov_caja" value="E" onClick="abre_datos_mov_caja()"></td>
        <td >Egresar dinero de la caja
		<td  align="center"><input type="radio" id="ope_mov_caja" name="ope_mov_caja" value="I" onClick="abre_datos_mov_caja()"></td>
        <td>Ingresar dinero a la caja</td>
    </tr>
</table>
<div id="cuerpo_mov_caja"></div>
</body>
</html>