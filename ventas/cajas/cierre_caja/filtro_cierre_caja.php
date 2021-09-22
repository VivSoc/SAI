<?php 
	session_start();
	require("../../../../configuracion/config.php");
	require("../../../../configuracion/conexion.php");
	require("../../../../clases/funciones.php");
	require("../../../../clases/utilidades.class.php");
	echo"<script>document.getElementById('cie_caja_cod_caja').focus()</script>";
?>
<html>
    <head> 
		<link rel="stylesheet" href="<?php echo $sis_estilo; ?>" type="text/css">
        <link rel="stylesheet" href="css/sweetalert.css" type="text/css">
        <link rel="stylesheet" href="css/autocompletar.css" type="text/css">
		<script type="text/javascript" src="js/jquery.js"></script>
		<script type="text/javascript" src="js/jquery-1.4.2.min.js"></script>
		<script type="text/javascript" src="js/jquery-ui-1.8.1.custom.min.js"></script>
		<script type="text/javascript" src="js/javascript.js"></script>
        <script type="text/javascript" src="javascript/ventas/cierre_caja/cierre_caja.js"></script>
		<script type="text/javascript" src="js/sweetalert.min.js"></script>
        
      
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    </head>
<table width="100%" align="center" class='tbldatos1'>
	<tr>
		<td colspan="6" align="center" class="fondo_fila_amarilla";>Cierre de Caja</td>
	</tr> 
    <tr>
		<td width="10%">Usuario:</td>
		<td width="20%"><font color="#000066"><?php echo $_SESSION['usuario'];?></font></td>
        <input type="hidden" name="cie_caja_ced_usuario" id="cie_caja_ced_usuario" value="<?php echo $_SESSION['scu_cedusu'];?>"><input type="hidden" name="fec_cie_caja" id="fec_cie_caja" value="<?php echo date('d-m-Y');?>">
        <td width="10%"> 
        </td>
                       
	</tr>
    <tr>
		<td >Nombre	:</td>
		<td ><font color="##000066"><?php echo $_SESSION['nomusu'];?></font></td>
        <input type="hidden" name="cie_caja_nom_usuario" id="cie_caja_nom_usuario" value="<?php echo $_SESSION['nomusu'];?>">

    	<td width="5%" align="center">Código de Caja </td>
		<td width="10%"><input type="text" name="cie_caja_cod_caja" id="cie_caja_cod_caja"  maxlength="4" size="10" value="" onBlur="CodigoToSelect(document.getElementById('cie_caja_cod_caja').value,document.getElementById('cie_caja_des_caja'));" onKeyPress="enter2tab(event,'busca_cie_caja',0);return solo_numeros(event);" lang="s"/>
        </td>
        <td width="20%">
<?php
		$accion=		"onchange=document.getElementById('cie_caja_cod_caja').value=document.getElementById('cie_caja_des_caja').options[document.getElementById('cie_caja_des_caja').selectedIndex].value;";
		$objUtilidades=new utilidades;
      	$objUtilidades->seleccionarCombo("Select a.id_caja, b.des_caja From abre_cajas a, cajas b where a.sta_abertura='A' and a.id_usuario='".$_SESSION['scu_cedusu']."' and b.id_caja=a.id_caja","cie_caja_des_caja",$accion,'',$readonly='',$retornar=0);    
?></td>   
     
<td align="left">
				<button type="button" id="busca_cie_caja" name="busca_cie_caja" title="Buscar caja" onClick="buscar_cierre_caja();" style="width:25px; height:25px;"><img src="css/imagenes/buscar.png"></button>

		</td>		
	</tr>
</table>
<div id="cuerpo_cierre_caja"></div>
</body>
</html>